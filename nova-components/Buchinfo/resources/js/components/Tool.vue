<template>
    
    <div>
        <h1 class="mb-3 text-90 font-normal text-2xl">Ausleihe</h1>

        <div class="card">

            <div class="flex items-center py-3 border-b border-50">
            
                <div class="flex items-center mr-auto px-3">

                    <div class="flex items-center mr-3">
                        <select
                            v-model="selectedJahrgang" 
                            v-on:change='getKlassen()' 
                            class="form-control form-select mr-2">
                            <option disabled :value="-1">Jahrgang wählen</option>
                            <option v-for="(j, index) in jahrgaenge" :value="index">
                                {{ j.jahrgangsstufe }}
                            </option>
                        </select>
                    </div>

                    <div class="flex items-center mr-3">
                        <select 
                            v-model="selectedKlasse" 
                            v-if="selectedJahrgang!=-1" 
                            v-on:change='getSchueler()' 
                            class="form-control form-select mr-2">
                            <option disabled :value="-1">Klasse wählen</option>
                            <option v-for="(k,index) in klassen" :value="index">
                                {{ k.bezeichnung }}
                            </option>
                        </select>
                    </div>

                    <div class="flex items-center mr-3">
                        <select 
                            v-model="selectedSchueler" 
                            v-if="selectedKlasse!=-1" 
                            v-on:change='getAusleiher()' 
                            class="form-control form-select mr-2">
                            <option disabled :value="-1">Schüler wählen</option>
                            <option v-for="(s, index) in schueler" :value="index">
                                {{ s.nachname }}, {{ s.vorname }}
                            </option>
                        </select>
                    </div>

                    <div 
                        class="flex items-center mr-3" 
                        v-if="selectedSchueler>0"
                    >
                        <button 
                            @click="prevAusleiher" 
                            class="btn btn-default btn-primary">
                            Prev
                        </button>
                    </div>
                    
                    <div   
                        class="flex items-center mr-3" 
                        v-if="selectedSchueler!=-1 && selectedSchueler<schueler.length-1"
                    >
                        <button 
                            @click="nextAusleiher" 
                            class="btn btn-default btn-primary">
                            Next
                        </button>
                    </div>

                    <div>
                        <input 
                            type="text" 
                            class="w-full form-control form-input form-input-bordered"
                            ref="ausleihen"
                            v-on:keyup.enter="buchAusleihen"
                            v-if="selectedSchueler>0"
                            v-model="buchId" 
                            placeholder="Buch ausleihen" 
                        >
                    </div>

                </div>

            </div>


            
        </div>

        <div class="card mt-6" v-if="selectedSchueler!=-1">

            

            <table
                class="table w-full"
                cellpadding="0"
                cellspacing="0"
                data-testid="resource-table"
            >
                <thead>
                    <tr>
                        <th class="text-left">
                            <span class="inline-flex items-center">
                                Leihstatus
                            </span>
                        </th>
                        <th class="text-left">
                            <span class="inline-flex items-center">
                                Fach
                            </span>
                        </th>
                        <th class="text-left">
                            <span class="inline-flex items-center">
                                ID
                            </span>
                        </th>
                        <th class="text-left">
                            <span class="inline-flex items-center">
                                Titel
                            </span>
                        </th>
                        <th class="text-left">
                            <span class="inline-flex items-center">
                                Wahl
                            </span>
                        </th>
                    </tr>
                </thead>

                 <tbody v-for="buch in buecher">
                    <tr>
                        <td class="w-8">
                            <svg class="w-6 h-6 text-green fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM6.7 9.29L9 11.6l4.3-4.3 1.4 1.42L9 14.4l-3.7-3.7 1.4-1.42z"/></svg>
                        </td>
                        <td>{{ buch.buchtitel.fach_id }}</td>
                        <td>{{ buch.id }}</td>
                        <td>{{ buch.buchtitel.titel }}</td>
                        <td></td>
                    </tr>
                </tbody>

            </table>
        </div>
                    
    </div>

</template>

<script>
export default {
    
    data() {
        return {
            buchId:   null,
            jahrgaenge:   {}, 
            klassen:      {},
            schueler:     {},
            buecher:      {},
            buecherliste: {},
            summe:    null,
            summeErm: null,
            selectedJahrgang: -1,
            selectedKlasse:   -1,
            selectedSchueler: -1,
        }
    },

    created() {
        this.getJahrgaenge();
    },

    methods: {

        findeBuch() {            
            Nova.request().post('/nova-vendor/buchinfo', {
                buch_id: this.buch_id
            })
            .then(response => {
                console.log(response);
            })  
        },

        getJahrgaenge() {
            Nova.request().post('/nova-vendor/buchinfo')
                .then(response => {
                    this.jahrgaenge = response.data.jahrgaenge;
                })
        },

        getKlassen() {
            Nova.request().get('/nova-vendor/buchinfo/' 
                + this.jahrgaenge[this.selectedJahrgang].id)
                .then(response => {
                    this.klassen  = response.data.klassen;
                })
            
            this.selectedKlasse   = -1;
            this.schueler         = {}; 
            this.selectedSchueler = -1;
            this.buecher          = {};
            this.buecherliste     = {};
            this.summe            = null;
            this.summeErm         = null;
        },

        getSchueler() {
            Nova.request().get('/nova-vendor/buchinfo/' 
                + this.jahrgaenge[this.selectedJahrgang].id + '/' 
                + this.klassen   [this.selectedKlasse  ].id)
                .then(response => {
                    this.schueler = response.data.schueler;
                })

            this.selectedSchueler = -1;
            this.buecher          = {};
            this.buecherliste     = {};
            this.summe            = null;
            this.summeErm         = null;
        },

        getAusleiher() {
            Nova.request().get('/nova-vendor/buchinfo/' 
                + this.jahrgaenge[this.selectedJahrgang].id + '/'  
                + this.klassen   [this.selectedKlasse  ].id + '/'
                + this.schueler  [this.selectedSchueler].id)
                .then(response => {
                    this.buecher      = response.data.buecher;
                    this.buecherliste = response.data.buecherliste;
                    this.summe        = response.data.summe;
                    this.summeErm     = response.data.summeErm;
                })
            
            this.$nextTick(() => {
                this.$refs.ausleihen.focus()
            })
        },

        nextAusleiher() {
            this.selectedSchueler++;
            this.getAusleiher();
        },

        prevAusleiher() {
            this.selectedSchueler--;
            this.getAusleiher();
        },

        buchAusleihen() {                       
            Nova.request().post('/nova-vendor/buchinfo/'
                + this.jahrgaenge[this.selectedJahrgang].id + '/'  
                + this.klassen   [this.selectedKlasse  ].id + '/'
                + this.schueler  [this.selectedSchueler].id, {
                    buchId: this.buchId,
                })
                .then(response => {
                    this.buecher.push(response.data.buch);
                })
                .catch(function (error) {
                    console.log(error);
                });
            
            this.buchId = null;
        },

    }
}
</script>

<style>
/* Scoped Styles */
</style>
