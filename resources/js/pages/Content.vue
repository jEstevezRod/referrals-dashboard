<template>
    <v-container>
        <p class="display-1 grey--text text--darken-3 mt-5">Manage domain content</p>
        <v-row>
            <v-col cols="12" sm="6">
                <v-row>
                    <v-col>
                        <v-radio-group v-model="domainSelected" column @change="setData">
                            <v-radio v-for="domain in domains" :label="domain.name" :value="domain" :key="domain.id"/>
                        </v-radio-group>
                    </v-col>
                </v-row>
                <section v-if="domainSelected">
                    <v-row>
                        <v-col>
                            <v-text-field filled v-model="content.domainName" label="Domain name"
                            />

                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-text-field filled v-model="content.domainUrl" label="Domain url"/>

                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-text-field filled v-model="content.homeHeaderTitle" label="Home header title H1"
                            />
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-textarea filled v-model="content.homeExplanation" label="Home Explanation"/>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-textarea filled v-model="content.categoriesExplanation" label="Category Explanation"/>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-file-input
                                v-model="content.homeHeroImage"
                                :disabled="typeof content.homeHeroImage == 'string'"
                                color="deep-purple accent-4"
                                label="Home Hero Image"
                                placeholder="Select your files"
                                prepend-icon="mdi-paperclip"
                                outlined
                            />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-file-input
                                v-model="content.websiteIcon"
                                :disabled="typeof content.websiteIcon == 'string'"
                                color="deep-purple accent-4"
                                label="Favicon"
                                placeholder="Select your files"
                                prepend-icon="mdi-paperclip"
                                outlined
                            />
                        </v-col>
                    </v-row>
                    <v-row class="mb-6">
                        <v-col>
                            <v-btn color="success" @click="save">Save</v-btn>
                        </v-col>
                    </v-row>
                </section>
            </v-col>
            <v-col cols="12" sm="6">
                <v-row>
                    <v-col v-if="content.homeHeroImage">
                        <v-card>
                            <v-img
                                :src="`storage/${content.homeHeroImage}`"
                                class="black--text align-end"
                                height="250px"

                            >
                                <v-card-title>Home Hero</v-card-title>
                            </v-img>

                        </v-card>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col v-if="content.websiteIcon">
                        <v-card>
                            <v-img
                                :src="`storage/${content.websiteIcon}`"
                                class="black--text align-end"
                                height="250px"
                                style="background-size: inherit !important;"
                            >
                                <v-card-title>Favicon</v-card-title>
                            </v-img>

                        </v-card>
                    </v-col>
                </v-row>

            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: "Content",
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
                files: [],
                content: {
                    domainName: '',
                    domainUrl: '',
                    homeHeaderTitle: '',
                    homeHeroImage: null,
                    homeExplanation: '',
                    websiteIcon: null,
                    categoriesExplanation: ''
                },
                domainSelected: '',
                formData: new FormData()
            }
        },
        methods: {
            setData() {
                this.content.id = this.domainSelected.id;
                this.content.domainName = this.domainSelected.name;
                this.content.domainUrl = this.domainSelected.url;
                this.content.homeHeaderTitle = this.domainSelected.homeHeaderTitle;
                this.content.homeHeroImage = this.domainSelected.homeHeroImage;
                this.content.homeExplanation = this.domainSelected.homeExplanation;
                this.content.websiteIcon = this.domainSelected.websiteIcon;
                this.content.categoriesExplanation = this.domainSelected.categoriesExplanation;
            },
            save() {
                let formData = new FormData();
                for (let [key, value] of Object.entries(this.content)) {
                    console.log(key)
                    console.log(value)
                    formData.append(key, value);
                }
                this.axios.post('updateDomain', formData, {headers: {'Content-type': 'multipart/form-data'}})
                    .then(res => {
                        console.log(res)
                    });
            },
            show() {
                console.dir(this.files[0])
            }
        }
    }
</script>

<style>
.v-image__image{
    background-size: auto !important;
}

</style>
