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
                <v-btn :disabled="!domainSelected" color="red lighten-1" dark @click="exportJson">Export JSON</v-btn>

            </v-col>
        </v-row>
        <v-row v-if="data" justify="center">
            <v-col cols="10" sm="8" md="6">
                <v-sheet
                    class="pa-12"
                    color="grey lighten-3"
                >
                    <v-row>
                        <v-col class="text-center">
                            <v-btn color="primary" type="button"
                                   v-clipboard:copy="data"
                                   v-clipboard:success="onCopy"
                                   v-clipboard:error="onError">Copy!
                            </v-btn>
                            <v-switch v-model="prettyView" inset :label="`Pretty view: ${prettyView.toString()}`"/>


                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col v-if="!prettyView">
                            {{data}}
                        </v-col>
                        <v-col v-if="prettyView">
                            <code>
                                {{data}}
                            </code>

                        </v-col>
                    </v-row>
                    <v-snackbar
                        v-model="snackbar"
                        center
                        top
                        color="green lighten-1"
                    >
                        <v-btn
                            color="white"
                            text
                            @click="snackbar = false"
                        >
                            Copied correctly!
                        </v-btn>
                    </v-snackbar>
                </v-sheet>
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
                domainSelected: '',
                data: '',
                snackbar: false,
                timeout: 3000,
                prettyView: true
            }
        },
        methods: {
            clearOption() {
                this.domainSelected = '';
            },
            exportJson() {
                this.$store.dispatch('exportJson', this.domainSelected)
                    .then(res => this.data = JSON.stringify(JSON.parse(res), null, 2))
            },
            onCopy: function (e) {
                this.snackbar = true
            },
            onError: function (e) {
                alert('Failed to copy texts')
            }
        }
    }
</script>

<style scoped>

    .v-application code {
        background-color: transparent;
        color: #bd4147;
        box-shadow: none;
    }


    .theme--dark.v-btn.v-btn--disabled:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined) {
        background-color: hsla(0, 72%, 59%, 0.27)!important;
    }

</style>
