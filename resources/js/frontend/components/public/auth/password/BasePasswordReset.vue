<template>
    <layout-master>

        <div style="height: 100%">

            <v-container align-content-center fill-height>

                <v-row align="center" justify="center" fill-height>


                    <v-card style="width: 400px">
                        <v-form ref="form" v-model="states.is_form_valid" @submit.prevent="submitForm">


                            <v-card-title class="text-center ">
                                <h3 class="text-center mx-auto display-1 font-weight-bold">Forgot your password?</h3>
                                <h5 class="text-center mx-auto subtitle-1">Don't worry. We'll help you reset it.</h5>
                            </v-card-title>

                            <v-card-text>
                                <v-text-field
                                    label="Email Address"
                                    v-model="inputData.email"
                                    :rules="rules.email"
                                >
                                </v-text-field>
                            </v-card-text>

                            <v-card-actions>
                                <v-row column align="center">
                                    <v-col xs12>
                                        <v-btn
                                            :disabled="!states.is_form_valid"
                                            rounded
                                            color="red lighten-1 white--text"
                                            @click="submitForm">Reset Password</v-btn>
                                    </v-col>
                                    <v-col xs12 class="mt-2">
                                        <v-btn  small text href="/login"><span class="body-1">Back</span></v-btn>
                                    </v-col>
                                </v-row>
                            </v-card-actions>
                        </v-form>

                    </v-card>


                </v-row>

            </v-container>
        </div>

    </layout-master>
</template>
<script>

    import AxiosHelperMixin from "../../../../../mixins/AxiosHelperMixin";
    import LayoutMaster from "../../layout/Master";
    import SwalMixin from "../../../../../mixins/SwalMixin";
    import {emailValidator} from "../../../../../vue-tools/ValidationHelper";

    export default {
        name: "BasePasswordReset",
        components: { LayoutMaster},
        mixins: [AxiosHelperMixin, SwalMixin],
        data() {
            return {
                states: {
                    is_form_valid: false
                },
                inputData: {
                    email: null,
                },
                rules: {
                    email: [
                        v => !!v || "Required",
                        emailValidator,
                    ]
                }

            }
        },
        props: {},
        computed: {},
        methods: {
            submitForm() {
                if(!this.$refs.form.validate())
                    return this.swalMessage('error', 'Please complete the form');
                this.swalLoader();
                let uri = '/password/email';

                return axios.post(uri, this.inputData)
                    .then((response) => {
                        this.swalMessage('success', response.data.message)
                    })
                    .catch(response => this.axiosErrorCallback(response, response.response.data.error))
            }
        },
        mounted() {

        },
    }
</script>

<style scoped>

</style>
