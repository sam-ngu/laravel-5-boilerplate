<template>
    <v-layout row align-center justify-center fill-height>



        <v-menu offset-y left>
            <v-tooltip
                bottom
                slot="activator"
            >
                <v-icon
                    slot="activator"
                    small
                    class="mr-2"
                >
                    more_vert
                </v-icon>
                <span>More</span>
            </v-tooltip>
            <v-list>
                <v-list-tile
                    v-for="(item, index) in listItems"
                    :key="index"
                    :disabled="item.disabled"
                    @click="item.action.call()"
                    v-show="item.show"
                >
                    <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                </v-list-tile>
            </v-list>
        </v-menu>

        <v-tooltip bottom>
            <v-icon
                slot="activator"
                small
                @click="deleteItem"
            >
                delete
            </v-icon>
            <span>Delete</span>
        </v-tooltip>
    </v-layout>


</template>

<script>
    import {MessageBus} from "../../../../vue-tools/message-bus";
    import {EventBus} from "../../../../vue-tools/event-bus";
    import SwalMixin from "../../../../mixins/SwalMixin";

    export default {
        name: "UserTableActions",
        mixins: [SwalMixin],
        components: {},
        data() {
            return {}
        },
        props: {
            user: {
                type: Object,
                required: true,
            },

        },
        computed: {
            listItems(){
                return [
                    {
                        title: "Log in as " + this.user.first_name + ' ' + this.user.last_name,
                        action: this.logInAsUser,
                        disabled: MessageBus.getSession().user.id === this.user.id,
                        show: !this.isDeleted,
                    },
                    {
                        title: 'Deactivate',
                        action: this.deactivate,
                        disabled: MessageBus.getSession().user.id === this.user.id,
                        show: this.isActive,
                    },
                    {
                        title: 'Reactivate',
                        action: this.reactivate,
                        disabled: MessageBus.getSession().user.id === this.user.id,
                        show: this.isDeactivated,
                    },
                    {
                        title: 'Restore',
                        action: this.restore,
                        disabled: MessageBus.getSession().user.id === this.user.id,
                        show: this.isDeleted,
                    },

                ]
            },
            isActive(){
                return this.user.active && !this.isDeleted;
            },
            isDeactivated(){
                return !this.isActive && !this.isDeleted;
            },
            isDeleted(){
                return this.user.deleted_at !== "";
            }


        },
        methods: {
            logInAsUser(){
                let uri = '/admin/auth/user/' + String(this.user.id) + '/login-as';
                // axios.get(uri)
                window.location.href = window.location.protocol + "//" + window.location.hostname + uri;
            },
            deactivate(){
                let uri = '/api/v1/users/' + String(this.user.id) + '/mark/0';
                this.callApi(uri);
            },
            reactivate(){
                let uri = '/api/v1/users/' + String(this.user.id) + '/mark/1';
                this.callApi(uri);
            },
            restore(){
                let uri = '/api/v1/users/' + String(this.user.id) + '/restore';
                this.callApi(uri);
            },
            callApi(uri, method = 'get'){
                this.swalLoader();
                axios({
                    method: method,
                    url: uri,
                }).then(function (response) {
                    swal.close();
                    EventBus.$emit('table-reload-required');
                }).catch(function (response) {
                    let errors = response.response.data.error;
                    if ((typeof errors) === "string")
                        errors = {errors};
                    swal.close();
                    this.swalMessage("error", errors)
                }.bind(this))
            },
            deleteItem(){
                this.swalLoader();
                let uri;

                this.swalConfirm("", function(){
                    if(this.isActive || this.isDeactivated){
                        uri = '/api/v1/users/' + String(this.user.id);
                        this.callApi(uri, 'delete')
                    }
                    if(this.isDeleted){
                        uri = '/api/v1/users/' + String(this.user.id) + '/delete';
                        this.callApi(uri, 'get');
                    }
                }.bind(this));




            },
        },
        mounted() {

        },
    }
</script>

<style scoped>

</style>
