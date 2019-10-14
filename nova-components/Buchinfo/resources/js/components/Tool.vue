<template>
    <div>
        <heading class="mb-6">Buchinfo</heading>

        <card class="flex flex-col items-center justify-center" style="min-height: 300px">
        
            <h1 class="text-black text-4xl text-90 font-light mb-6">Buchinfo</h1>
            
            <button @click="findeBuch" class="btn btn-default btn-primary">Finde Buch</button>

        </card>
    </div>
</template>

<script>
export default {
    methods: {

        findeBuch() {            
            Nova.request().post('/nova-vendor/buchinfo')
                .then(response => {
                    console.log(response);
                })  
        }

    }
}
</script>

<style>
/* Scoped Styles */
</style>
