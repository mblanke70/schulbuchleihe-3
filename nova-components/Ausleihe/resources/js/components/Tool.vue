<template>
    <div>
        <heading class="mb-6">Klassen</heading>

        <card>
            <div class="overflow-hidden overflow-x-auto relative">
              <table>
                <thead>
                  <tr>
                    <th>Klasse</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="klasse in klassen">
                    <td>{{ klasse.bezeichnung }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
        </card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            klassen: [],
        }
    },
    mounted() {
        this.getKlassen();
    },
    methods: {
        getKlassen() {
   
        },
    },
}
</script>

<style>
/* Scoped Styles */
</style>
