<template>
    <v-container fluid>
        <h1>Adding a new domain</h1>
        <v-row>
            <v-col cols="8">
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                            filled
                            v-model="newDomain.name"
                            label="Domain name"
                            required
                            filled
                        />
                        <v-text-field
                            filled
                            v-model="newDomain.url"
                            label="Domain url"
                            required
                            filled
                        />
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-btn color="success" @click="createDomain">Create</v-btn>
                    </v-col>

                </v-row>
            </v-col>
            <v-col cols="4"  >
                <h3>List of domains</h3>
                <hr>
                <v-list id="categoriesDomain">
                    <v-list-item v-for="domain of domains" :key="domain.id">
                        <v-list-item-content>
                            <v-list-item-title v-text="domain.name"/>
                            <v-list-item-subtitle v-text="domain.url"/>
                        </v-list-item-content>
                        <v-list-item-action>
                            <v-btn icon @click="deleteDomain(domain.id)">
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
        name: "Domain",
        data: () => ({
            newDomain: {name: '', url: ''}
        }),
        mounted() {
            this.$store.dispatch('listDomains')
        },
        computed: {
            domains() {
                return this.$store.getters.domains;
            }
        },
        methods: {
            createDomain() {
                this.$store.dispatch('createDomain', this.newDomain).then(() => {
                    this.newDomain = {name: '', url: ''};
                })
            },

            deleteDomain(id) {
                console.log(id)
                this.$store.dispatch('deleteDomain', id)
            }
        }
    }
</script>

<style scoped>

    .v-list {
        background-color: transparent;
    }

</style>
