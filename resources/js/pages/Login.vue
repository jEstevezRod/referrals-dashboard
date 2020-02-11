<template>

    <v-container>
        <v-row justify="center">
            <v-col cols="6">
                <v-card>
                    <v-form method="post" @submit.prevent="login" ref="form">

                        <v-card-text>
                            <v-container>
                                <div class="overline mb-4">Referrals Dashboard</div>
                                <v-list-item-title class="headline mb-3">Login</v-list-item-title>
                                <v-text-field
                                    v-model="email"
                                    :rules="emailRules"
                                    label="E-mail"
                                    required
                                    filled
                                />
                                <v-text-field
                                    v-model="password"
                                    label="Password"
                                    required
                                    filled
                                    :rules="passwordRules"
                                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                    :type="showPassword ? 'text' : 'password'"
                                    @click:append="showPassword = !showPassword"
                                />
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer/>
                            <v-btn color="primary" type="submit" class="mr-5 mb-5">Login</v-btn>
                        </v-card-actions>
                    </v-form>
                </v-card>

            </v-col>
        </v-row>
    </v-container>
</template>
<script>
    export default {
        data() {
            return {
                email: 'admin@test.com',
                password: 'admin',
                has_error: false,
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
                ],
                passwordRules: [
                    value => !!value || 'Required.',
                    v => v.length >= 4 || 'Min 8 characters'
                ],
                showPassword: false
            }
        },
        mounted() {
            //
        },
        methods: {
            login() {
                if (this.validate()) {
                    // get the redirect object
                    let redirect = this.$auth.redirect();
                    let app = this
                    this.$auth.login({
                        params: {
                            email: app.email,
                            password: app.password
                        },
                        success: function () {
                            // handle redirection
                            // const redirectTo = redirect ? redirect.from.name : this.$auth.user().role === 2 ? 'admin.dashboard' : 'admin.dashboard';
                            this.$router.push({name: 'admin.dashboard'})
                        },
                        error: function () {
                            app.has_error = true
                        },
                        rememberMe: true,
                        fetchUser: true
                    })
                }

            },
            validate() {
                if (this.$refs.form.validate()) {
                    return true
                } else {
                    return false
                }
            }
        }
    }
</script>
