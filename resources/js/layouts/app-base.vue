<template>
    <div id="main">
        <Navbar/>

        <v-content id="content">
            <v-container fluid>
                <router-view/>
            </v-container>
        </v-content>
        <FooterComponent/>
    </div>
</template>

<script>
    import Navbar from "../components/Global/Navbar";
    import FooterComponent from "../components/Global/FooterComponent";

    export default {
        components: {Navbar, FooterComponent},
        data() {
            return {
                routes: {
                    // UNLOGGED
                    unlogged: [
                        {
                            name: 'Inscription',
                            path: 'register'
                        },
                        {
                            name: 'Connexion',
                            path: 'login'
                        }
                    ],
                    // LOGGED USER
                    user: [
                        {
                            name: 'Dashboard',
                            path: 'dashboard'
                        }
                    ],
                    // LOGGED ADMIN
                    admin: [
                        {
                            name: 'Dashboard',
                            path: 'admin.dashboard'
                        }
                    ]
                }
            }
        },
        mounted() {
            //
        }
    }
</script>

<style>

    #app {
        background-color: #f5f5f5;
        font-family: "Raleway", sans-serif !important;
    }

    .v-application .display-1, .v-application .display-2, .v-application .headline {
        font-family: "Raleway", sans-serif !important;

    }


</style>
