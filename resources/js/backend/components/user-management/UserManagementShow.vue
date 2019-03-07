<template>
    <collapsible-sidebar :show-sidebar="show" @dismiss-sidebar="back">
        <template slot="header">
            {{data.first_name}} {{data.last_name}}
        </template>

        <template slot="content">
            <v-container>
                <v-layout row wrap>
                    <v-flex xs12>
                        <v-card
                            class="mb-5 pa-5"
                        >
                            <v-form ref="formEditDetails" v-model="formsValidity.formEditDetails" @submit.prevent="" >

                                <v-text-field
                                    label="First Name"
                                    v-model="inputData.first_name"
                                    :rules="rules.name"
                                >
                                </v-text-field>
                                <v-text-field
                                    label="Last Name"
                                    v-model="inputData.last_name"
                                    :rules="rules.name"
                                >
                                </v-text-field>
                                <v-text-field
                                    label="Email"
                                    v-model="inputData.email"
                                    :rules="rules.name"
                                >
                                </v-text-field>

                                <v-text-field
                                    label="Change password"
                                    v-model="inputData.password"
                                    type="password"
                                    :rules="rules.password"
                                >
                                </v-text-field>

                                <v-text-field
                                    label="Password confirmation"
                                    :rules="rules.password_again"
                                    type="password"
                                >
                                </v-text-field>

                                <v-container>
                                    <v-subheader>Roles</v-subheader>
                                    <v-layout row>
                                        <v-flex xs12 md6>
                                            <v-card>
                                                <v-switch label="Administrator" v-model="inputData.is_admin"></v-switch>
                                                <v-card-text>
                                                    All Permissions
                                                </v-card-text>

                                            </v-card>
                                        </v-flex>
                                        <v-flex xs12 md6>
                                            <v-card>
                                                <v-switch label="Executive" v-model="inputData.is_executive"></v-switch>
                                                <v-card-text>
                                                    View-backend
                                                </v-card-text>
                                            </v-card>
                                        </v-flex>
                                        <v-flex xs12 md6>
                                            <v-card>
                                                <v-switch label="User" v-model="inputData.is_user"></v-switch>
                                                <v-card-text>
                                                    None
                                                </v-card-text>
                                            </v-card>
                                        </v-flex>
                                    </v-layout>
                                </v-container>

                                <!--permission-->

                                <v-container>
                                    <v-subheader>Permissions</v-subheader>
                                    <v-layout row>
                                        <v-flex xs12 md6>
                                            <v-card>
                                                <v-switch label="View Backed" v-model="inputData.view_backend"></v-switch>
                                                <v-card-text>
                                                    None
                                                </v-card-text>
                                            </v-card>
                                        </v-flex>
                                    </v-layout>
                                </v-container>

                            </v-form>

                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </template>

    </collapsible-sidebar>
</template>

<script>
    import CollapsibleSidebar from "../../../vue-tools/CollapsibleSidebar";

    export default {
        name: "UserManagementShow",
        components: {CollapsibleSidebar},
        data() {
            return {
                show: false,
                formsValidity: { //validity of all forms, depending on rules
                    formEditDetails: false
                },
                rules: {
                    email: [
                        v => this.inputData.email ? ((v && /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) ) || "Incorrect Format") : true
                    ],
                    name:[
                        v => !!v || 'Name is required',
                        v => (v && v.length <= 30) || 'Name must be less than 30 characters'
                    ],
                    password: [

                    ],
                    password_again: [
                        v => this.inputData.email_password ? ((v && v === this.inputData.email_password) || "Passwords do not match!") : true,

                    ],
                },
                inputData: this.data
            }

        },
        props: {
            data: {
                type: Object,
                required: true,
            }
        },
        computed: {},
        methods: {
            back() {
                this.$router.push({name: 'user-management'})
            }
        },
        mounted() {
            this.show = true;  // trigger fade effect
        },
    }
</script>

<style scoped>

</style>
