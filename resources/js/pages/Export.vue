<template>
    <v-container>
        <v-row>
            <v-col cols="6">
                <h3>Select the domain to export

                </h3>
                <v-radio-group v-model="domainSelected" column>
                    <v-radio v-for="domain in domains" :label="domain.name" :value="domain.id" :key="domain.id"/>
                </v-radio-group>
            </v-col>
            <v-col cols="6">
                <div id="adminControl">
                    <span id="AdminControlLabel" class="overline">Admin Control</span>
                <v-btn :disabled="!domainSelected" :loading="loading" color="red lighten-1" dark @click="exportJson">
                    Export Products
                </v-btn>
                <v-btn :disabled="!domainSelected" :loading="loading3" color="teal darken-4" dark
                       >Export Content
                </v-btn> <v-btn :disabled="!domainSelected" :loading="loading2" color="light-blue darken-4" dark
                       @click="generateSitemap">Generate Sitemap
                </v-btn>
                    <v-btn text @click="clearOption">Clear option</v-btn>
                </div>

            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col cols="5" v-if="data">
                <v-sheet
                    class="pa-12"
                    color="grey lighten-3"
                >
                    <v-row>
                        <v-col class="text-center">
                            <p class="display-1 mb-5">Products</p>

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
            <v-col cols="5" v-if="sitemap">
                <v-sheet
                    class="pa-12"
                    color="grey lighten-3"
                >
                    <v-row>
                        <v-col class="text-center">
                            <p class="display-1 mb-5">Sitemap.xml</p>

                            <v-btn color="primary" type="button"
                                   v-clipboard:copy="sitemap"
                                   v-clipboard:success="onCopy"
                                   v-clipboard:error="onError">Copy!
                            </v-btn>
                            <v-switch v-model="prettyView2" inset :label="`Pretty view: ${prettyView.toString()}`"/>


                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col v-if="!prettyView2">
                            {{sitemap}}
                        </v-col>
                        <v-col v-if="prettyView2">
                            <code>
                                {{sitemap}}
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
                prettyView: true,
                prettyView2: true,
                sitemap: '',
                loading: false,
                loading3: false,
                loading2: false
            }
        },
        methods: {
            clearOption() {
                this.domainSelected = '';
            },
            exportJson() {
                this.loading = true;
                this.$store.dispatch('exportJson', this.domainSelected)
                    .then(res => {
                            this.data = JSON.stringify(JSON.parse(res), null, 2)
                            this.loading = false;
                        }
                    )
            },
            onCopy: function (e) {
                this.snackbar = true
            },
            onError: function (e) {
                alert('Failed to copy texts')
            },
            generateSitemap() {
                this.loading2 = true;
                this.$store.dispatch('generateSitemap', {id: this.domainSelected})
                    .then(response => {
                        console.log('Sitemap generated')
                        this.loading2 = false;
                        this.sitemap = response.toString()
                    })
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

    #adminControl {
        border-radius: 6px;
        padding: 25px;
        position: relative;
        background-color: #eee !important;

        border-color: #eee !important;
    }
    #AdminControlLabel {
        position: absolute;
        top: 4px;
    }

    .theme--dark.v-btn.v-btn--disabled:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined) {
        background-color: hsla(264, 26%, 85%, 0.32) !important;
        color: #dbdbdb !important;
    }

</style>
