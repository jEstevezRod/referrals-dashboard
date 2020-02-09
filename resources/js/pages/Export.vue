<template>
    <v-container>
        <v-row>
            <v-col cols="10">
                <h3>Select the domain to export -
                    <v-btn text @click="clearOption">Clear option</v-btn>
                </h3>
                <v-radio-group v-model="domainSelected" column>
                    <v-radio v-for="domain in domains" :label="domain.name" :value="domain.id" :key="domain.id"/>
                </v-radio-group>
            </v-col>
            <v-col cols="2">
                <v-btn  class="customBtn" @click="exportJson">Export JSON</v-btn>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: "Export",
        mounted() {
            this.$store.dispatch('listDomains')
        },
        computed: {
            domains() {
                return this.$store.getters.domains
            }
        },
        data() {
            return {
                domainSelected: ''
            }
        },
        methods: {
            clearOption() {
                this.domainSelected = '';
            },
            exportJson() {
                this.$store.dispatch('exportJson', this.domainSelected)
            }
        }
    }
</script>

<style scoped>
    .customBtn {
        text-decoration: none;
        background-color: tomato;
        padding: 20px 30px;
        border-radius: 5px;
        color: white !important;
        border: 1px solid #f5adad;
    }

</style>
