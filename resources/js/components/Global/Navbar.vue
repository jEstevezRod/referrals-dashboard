<template>
    <v-app-bar
        color="indigo darken-1"
        dark
        elevation="0"
    >
        <v-app-bar-nav-icon/>
            <v-toolbar-title>
                Referrals Dashboard
            </v-toolbar-title>
        <v-spacer></v-spacer>

        <v-toolbar-items>
            <v-flex
                align-center
                layout
                py-2
            >
                <v-btn text v-if="!$auth.check()" v-for="(route, key) in routes.unlogged"
                       v-bind:key="route.path"
                       :to="{ name : route.path }" exact :key="key">{{route.name}}
                </v-btn>
                <v-btn text v-if="$auth.check(1)" v-for="(route, key) in routes.user"
                       v-bind:key="route.path"
                       :to="{ name : route.path }" exact :key="key">{{route.name}}
                </v-btn>
                <v-btn text v-if="$auth.check(2)" v-for="(route, key) in routes.admin"
                       v-bind:key="route.path"
                       :to="{ name : route.path }" exact :key="key">{{route.name}}
                </v-btn>
                <v-btn text v-if="$auth.check()" @click.prevent="$auth.logout()">Logout</v-btn>
            </v-flex>
        </v-toolbar-items>


    </v-app-bar>
</template>

<script>
    export default {
        name: "Navbar",
        data() {
            return {
                routes: {
                    // UNLOGGED
                    unlogged: [
                        // {
                        //     name: 'Register',
                        //     path: 'register'
                        // },
                        {
                            name: 'Login',
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
                            name: 'Homepage',
                            path: 'home'
                        },
                        {
                            name: 'Dashboard',
                            path: 'admin.dashboard'
                        },
                        {
                            name: 'Content',
                            path: 'content'
                        },
                        {
                            name: 'Export',
                            path: 'export'
                        }
                    ]
                }
            }
        },
    }
</script>

<style scoped>

</style>
