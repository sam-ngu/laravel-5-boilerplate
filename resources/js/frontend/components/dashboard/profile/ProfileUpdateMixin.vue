<script>
    import {MessageBus} from "../../../../vue-tools/message-bus";
    import SwalMixin from "../../../../mixins/SwalMixin";
    import AxiosHelperMixin from "../../../../mixins/AxiosHelperMixin";
    import {EventBus} from "../../../../vue-tools/event-bus";

    export default {
        name: "ProfileUpdateMixin",
        mixins: [AxiosHelperMixin, SwalMixin],
        components: {},
        data() {
            return {
                inputData: {
                    phone: null,
                    first_name: null,
                    last_name: null,
                    old_password: null,
                    password: null,
                    password_again: null,

                },
                states: {
                    hasEdited: false,
                    is_form_valid: false,
                },
                uri: null, //uri for api call
            }
        },
        props: {},
        computed: {
            user(){
                return MessageBus.getSession().user;
            }
        },
        methods: {
            save(){
                if(!this.states.is_form_valid && !this.states.hasEdited)
                    return;
                this.swalConfirm("",
                    function () {
                        this.swalLoader();
                        return axios.patch(this.uri, this.inputData)
                            .then(function (response) {
                                EventBus.$emit('fetch-session-required');
                                this.swalTimer('success', 500)
                                    .then(function () {
                                        this.$router.push({
                                            name: 'user-profile'
                                        })
                                    }.bind(this));
                            }.bind(this))
                            .catch(this.axiosErrorCallback)
                    }.bind(this)
                );
            },
            edit(){
                this.states.hasEdited = true
            }
        },
        mounted() {
            this.uri = `/api/v1/users/${this.user.id}/profile`
        },
    }
</script>

<style scoped>

</style>
