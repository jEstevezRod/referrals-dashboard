<template>
    <v-container fluid>
        <p class="display-1 grey--text text--darken-3 mt-5">Adding a new category</p>

        <v-row>
            <v-col cols="8">
                <v-row>
                    <v-col cols="6">
                        <v-select
                            :items="domains"
                            label="Domain"
                            v-model="domainSelected"
                            :hint="domainSelected.url"
                            item-text="name"
                            clearable
                            filled
                            return-object
                            :persistent-hint="!!domainSelected"
                        >
                        </v-select>
                    </v-col>
                </v-row>
                <fade-transition>

                    <v-row v-if="domainSelected">
                        <v-col cols="12">
                            <v-text-field
                                filled
                                v-model="category.name"
                                label="Category name"
                                required
                            />


                            <v-file-input
                                v-model="category.categoryImg"
                                color="deep-purple accent-4"
                                label="Category image"
                                prepend-icon="mdi-paperclip"
                                filled
                            />
                            <v-textarea
                                filled
                                v-model="category.description"
                                label="Description"
                            />
                        </v-col>
                    </v-row>
                </fade-transition>
                <fade-transition>

                    <v-row v-if="domainSelected">
                        <v-col>
                            <v-btn @click="createCategory" color="success">Create</v-btn>
                        </v-col>
                    </v-row>
                </fade-transition>

            </v-col>
            <v-col cols="4" v-if="domainSelected">
                <h3>List of categories for this domain: </h3>
                <hr>
                <v-list id="categoriesDomain">
                    <v-list-item v-for="category of domainSelect.categories" :key="category.id">
                        <v-list-item-content>
                            <v-list-item-title v-text="category.name"/>
                        </v-list-item-content>
                        <v-list-item-action>
                            <v-btn icon @click="deleteCategory(category.id)">
                                <v-icon color="red lighten-1">mdi-delete</v-icon>
                            </v-btn>
                        </v-list-item-action>
                    </v-list-item>
                </v-list>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: "Category",
        data: () => ({
            domainSelected: '',
            category: {name: '', categoryImg: '', description: ''}

        }),
        mounted() {
            this.$store.dispatch('listDomains')
        },
        computed: {
            domains() {
                return this.$store.getters.domains
            },
            domainSelect() {
                return (this.$store.getters.domains.filter(x => x.id == this.domainSelected.id))[0];
            }
        },
        methods: {
            createCategory() {
                this.category['domain_id'] = this.domainSelected.id;
                // this.$store.dispatch('createCategory', this.category).then((res) => {
                //     console.log(res)
                // })

                let formData = new FormData();
                for (let [key, value] of Object.entries(this.category)) {
                    formData.append(key, value);
                }
                this.axios.post('addCategory', formData, {headers: {'Content-type': 'multipart/form-data'}})
                    .then(res => {
                        console.log(res)
                    });
            },
            deleteCategory(id) {
                this.$store.dispatch('deleteCategory', id)
            }
        }
    }
</script>

<style scoped>

    #categoriesDomain {
        background-color: transparent;
    }
</style>
