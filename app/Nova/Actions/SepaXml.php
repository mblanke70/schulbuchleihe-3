<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\File;
use Carbon\Carbon;

use Digitick\Sepa\TransferFile\Factory\TransferFileFacadeFactory;
use Digitick\Sepa\PaymentInformation;

class SepaXML extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return ('Sepa-XML erzeugen');
    }

    public function handleResult(ActionFields $fields, $results)
    {
        $models = collect();
        foreach($results as $chunk) 
        {
            $models = $models->merge($chunk);
        }

        // Set the initial information
        // third parameter 'pain.008.003.02' is optional would default to 'pain.008.002.02' if not changed
        $directDebit = TransferFileFacadeFactory::createDirectDebit('SampleUniqueMsgId', 'Schulbuchleihe', 'pain.008.003.02');

        // create a payment, it's possible to create multiple payments,
        // "firstPayment" is the identifier for the transactions
        // This creates a one time debit. If needed change use ::S_FIRST, ::S_RECURRING or ::S_FINAL respectively
        $directDebit->addPaymentInfo('sbl-2021', array(
            'id'                    => 'sbl-2021-',
            'dueDate'               => Carbon::now()->addDays(7), // Fälligkeitsdatum
            'creditorName'          => 'Ursulaschule', // Gläubiger-Name
            'creditorAccountIBAN'   => 'DE02265501050000203661',    // Gläubiger-IBAN
            'creditorAgentBIC'      => 'NOLADE22XXX', // Gläubiger-BIC
            'seqType'               => PaymentInformation::S_RECURRING,    // Rhythmus
            'creditorId'            => 'DE0310400000173836',    // Gläubiger-ID
            'localInstrumentCode'   => 'CORE' // default. optional.
        ));

        foreach($models as $model) 
        {
            $buecher = $model->buecher;
            $ebooks  = $model->ebooks;
            $familie = $model->user->familie;

            if($familie == null || $familie->befreit) continue;

            $summe = 0;

            /* Bücher */
            foreach($buecher as $buch) {
                $btsj = $buch->buchtitel->buchtitelSchuljahr->first();

                $leihpreis = $btsj->leihpreis;
                if($leihpreis != null) { $summe += $leihpreis; }
            }

            /* Ebooks */
            foreach($ebooks as $ebook) {
                $btsj = $ebook->buchtitel->buchtitelSchuljahr->first();

                $leihpreis = $btsj->ebook;
                if($leihpreis != null) { $summe += $leihpreis; }
            }

            if($familie != null)
            {
                if($familie->users()->count() 
                    + $familie->externe()->where('bestaetigt', 1)->count() > 2)
                {
                    $summe = $summe * 0.8;
                }

                if($familie->befreit)
                {
                    $summe = 0;
                } 
            }

            $sepa = $familie->sepa_mandat;

            if($summe>0)
            {
                // Add a Single Transaction to the named payment
                $directDebit->addTransfer('sbl-2021', array(
                    'amount'                => $summe,   // Betrag
                    'debtorIban'            => $sepa->debtorIban,    // Zahlungspflichtiger-IBAN
                    'debtorBic'             => $sepa->debtorBic,     // Zahlungspflichtiger-BIC
                    'debtorName'            => $sepa->debtorName,    // Zahlungspflichtiger-Name
                    'debtorMandate'         => $sepa->debtorMandate, // Mandatsreferenz
                    'debtorMandateSignDate' => $sepa->debtorMandateSignDate, // Signaturdatum
                    'remittanceInformation' => $model->vorname . " " . $model->nachname,    // Verwendungdzweck
                    //'endToEndId'            => 'Invoice-No X'      // optional, if you want to provide additional structured info
                ));
            }
        }

        file_put_contents( public_path().'/xml/sepa.xml', $directDebit->asXML() );

        return Action::download( url('xml/sepa.xml'), 'sepa.xml' );
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        return $models;
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
