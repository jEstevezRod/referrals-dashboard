<template>
    <v-container style="height: 100%">
        <v-row>
            <v-col cols="9">
                <h1>Welcome back {{user.name}} !</h1>
                <p class="overline">{{user.email}}</p>
                <h2 class="mt-10">Projects</h2>
                <v-row>
                    <v-col cols="12" sm="12" v-for="project of projects" :key="project.id">
                        <v-sheet color="grey lighten-3 my-5">
                            <v-container>
                                <v-row justify="center">

                                    <v-col cols="12">
                                        <v-list-item three-line>
                                            <v-list-item-content>
                                                <div class="overline mb-1">Created at {{new
                                                    Date(project.createdAt).toLocaleDateString('en-US')}} - Last update
                                                    {{new Date(project.updatedAt).toLocaleDateString('en-US')}}
                                                </div>
                                                <v-list-item-title class="display-1 mb-1">
                                                    {{project.name}}
                                                </v-list-item-title>
                                                <v-list color="transparent">
                                                    <v-list-item
                                                        v-for="domain of project.alias"
                                                        :key="domain.createdAt"
                                                        :href="`https://${domain.domain}`"
                                                        target="_blank"

                                                    >
                                                        <v-list-item-icon>
                                                            <v-icon color="green accent-3">mdi-checkbox-blank-circle
                                                            </v-icon>
                                                        </v-list-item-icon>

                                                        <v-list-item-content>
                                                            <v-list-item-title>{{domain.domain}}</v-list-item-title>

                                                        </v-list-item-content>

                                                        <v-list-item-icon>
                                                            <v-icon color="blue">mdi-open-in-new</v-icon>
                                                        </v-list-item-icon>
                                                    </v-list-item>
                                                </v-list>
                                            </v-list-item-content>

                                        </v-list-item>
                                    </v-col>

                                </v-row>
                            </v-container>
                        </v-sheet>
                    </v-col>
                </v-row>

            </v-col>
            <v-col cols="3">
                <section id="tokenCreator">
                    <span id="tokenCreatorLabel" class="overline">Token generator</span>
                    <v-text-field
                        label="Email"
                        v-model="email"
                    />

                    <v-text-field
                        label="Token name"
                        v-model="tokenName"
                    />
                    <v-btn @click="zeitRegistration">Register Login</v-btn>
                    <v-btn @click="verifyLogin">Verify Login</v-btn>
                </section>
            </v-col>
        </v-row>
        <v-overlay v-model="loading">
            <v-progress-circular indeterminate size="64"/>
        </v-overlay>
    </v-container>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "Home",
        data() {
            return {
                email: 'jesestrod1@gmail.com',
                tokenName: 'API REFERRALS DASHBOARD',
                token2: '',
                token: '',
                code: '',
                loading: false,
                options: {
                    headers: {
                        'Content-Type': 'application/json',
                        'Access-Control-Allow-Origin': '*'

                    }
                },
                proxy: 'https://cors-anywhere.herokuapp.com/'
            }
        },
        methods: {
            zeitRegistration() {
                axios.post('https://api.zeit.co/now/registration', {
                    email: this.email,
                    tokenName: this.tokenName
                }, this.headers).then(response => this.token2 = response.data.token)
            },
            verifyLogin() {
                axios.get(`https://api.zeit.co/now/registration/verify?email=${this.email}&token=${this.token2}`)
                    .then(async res => {
                        await this.$store.commit('setToken', res.data.token);
                        this.getData();
                    })
            },
            async getData() {
                this.loading = true;
                try {
                    await this.me();
                    await this.getProjects();
                    this.loading = false

                } catch (e) {
                    this.loading = false;
                    console.log(e);
                }


            },
            me() {
                fetch(this.proxy + 'https://api.zeit.co/www/user', {
                    headers: {
                        'Authorization': 'Bearer ' + this.zeitToken,
                        'Content-Type':  'application/json',
                    },
                    method: 'GET'
                })
                    .then(res => res.json())
                    .then(data => {
                        console.log(data.user)
                        this.$store.commit('setUser', data.user)
                    })
            },
            getProjects() {
                fetch(this.proxy + 'https://api.zeit.co/v2/projects', {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + this.zeitToken,
                    },
                    method: 'GET'
                })
                    .then(res => res.json())
                    .then(data => {
                        this.$store.commit('setProjects', data);
                        console.log(data)
                    })
            }
        },
        computed: {
            zeitToken() {
                return this.$store.getters.zeitToken;
            },
            user() {
                return this.$store.getters.zeitUser;
            },
            projects() {
                return this.$store.getters.zeitProjects;
            }
        },
        mounted() {
            this.getData()
        }

    };
</script>

<style scoped>
    .bottom-gradient {
        background-image: linear-gradient(
            to top,
            rgba(0, 0, 0, 0.4) 0%,
            transparent 72px
        );
    }

    #tokenCreator {
        border-radius: 6px;
        padding: 25px;
        position: relative;
        background-color: #eee !important;
        border-color: #eee !important;
    }

    #tokenCreatorLabel {
        position: absolute;
        top: 4px;
    }

    .v-application--is-ltr .v-list-item__action:first-child, .v-application--is-ltr .v-list-item__icon:first-child {
        margin-right: 15px !important;
    }
</style>
