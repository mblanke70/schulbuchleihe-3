<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\BuchtitelSchuljahr;
use App\Schueler;
use App\Buchwahl;

class OrderConfirm extends Mailable
{
    use Queueable, SerializesModels;

    public $schueler;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Schueler $schueler)
    {
        $this->schueler = $schueler;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $wahlen = Buchwahl::where('schueler_id', $this->schueler->id)->get();
            
        $kaufen = $wahlen->filter(function ($bw) { return $bw->wahl == 3; });
        $kaufliste = BuchtitelSchuljahr::findMany($kaufen->pluck('buchtitel_id'));
        
        $leihen = $wahlen->filter(function ($bw) { return $bw->wahl <= 2; });
        $leihliste = BuchtitelSchuljahr::findMany($leihen->pluck('buchtitel_id'));
    
        $leihenEbooks = $wahlen->filter(function ($bw) { return $bw->ebook == 1; });
        $leihlisteEbooks = BuchtitelSchuljahr::findMany($leihenEbooks->pluck('buchtitel_id'));

        $summeKaufen = $kaufliste->sum('kaufpreis');
        $summeLeihen = $leihliste->sum('leihpreis') + $leihlisteEbooks->sum('ebook');
            
        return $this->from('blanke@ursulaschule.de')
            ->subject('Bestellbestätigung')
            ->markdown('emails.orders.confirm')
            ->with([
                'leihliste'        => $leihliste,
                'leihlisteEbooks'  => $leihlisteEbooks,
                'kaufliste'        => $kaufliste,
                'summeLeihen'      => $summeLeihen,
                'summeKaufen'      => $summeKaufen,
                'schueler'         => $this->schueler,
            ]);
    }
}
