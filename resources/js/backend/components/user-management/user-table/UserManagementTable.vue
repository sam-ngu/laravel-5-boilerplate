<template>
    <v-container>
        <v-layout row>
            <v-flex>
                <v-toolbar flat>
                    <v-toolbar-title>User Management</v-toolbar-title>

                    <v-spacer></v-spacer>

                    <v-tooltip bottom class="ml-auto">
                        <template slot="activator">
                            <v-btn
                                icon
                                color="success"
                                class="no-underline"
                                :to="{
                                    name: 'user-create',
                                }"
                            ><v-icon>add</v-icon></v-btn>
                        </template>
                        <span>Add new user</span>
                    </v-tooltip>
                </v-toolbar>
            </v-flex>
        </v-layout>

        <v-layout row> <!--search bar-->
            <v-flex>
                <v-text-field
                    class="pl-2 pr-5"
                    append-icon="fas fa-search"
                    label="Search"
                    v-model="searchKeywords"></v-text-field>
            </v-flex>
        </v-layout>

        <v-layout row>
            <v-flex>
                <v-data-table
                    :headers="headers"
                    :items="data.users"
                    :loading="states.isLoading"
                    hide-actions
                    class="elevation-3"
                >
                    <template slot="items" slot-scope="props">
                        <tr>
                            <td class="px-2 text-xs-left" >
                                <router-link :to="{
                                    name: 'user-show',
                                    params: {
                                        id: props.item.id,
                                        data: props.item,
                                        show: true,
                                    }
                                }">
                                    {{ props.item.last_name }}
                                </router-link>
                            </td>
                            <td class="px-2 text-xs-left">{{ props.item.first_name }}</td>
                            <td class="px-2 text-xs-left">{{ props.item.email }}</td>
                            <td class="px-2 text-xs-left">
                                <v-chip text-color="white" :color="props.item.confirmed_label ? 'green' : 'red'">
                                    {{ props.item.confirmed_label ? 'Yes' : 'No' }}
                                </v-chip>
                            </td>
                            <td class="px-2 text-xs-left">{{ props.item.roles_label }}</td>
                            <td class="px-2 text-xs-left">{{ props.item.permissions_label }}</td>
                            <td class="px-2 text-xs-left">{{ props.item.social_buttons }}</td>
                            <td class="px-2 text-xs-left">{{ props.item.updated_at }}</td>
                            <td class="px-2 justify-center layout px-0">
                                <v-layout row align-center justify-center fill-height>

                                    <user-management-table-action-list :user="props.item" />

                                    <v-tooltip bottom>
                                        <v-icon
                                            slot="activator"
                                            small
                                            @click="deleteItem(props.item)"
                                        >
                                            delete
                                        </v-icon>
                                        <span>Delete</span>
                                    </v-tooltip>
                                </v-layout>
                            </td>
                        </tr>

                    </template>
                </v-data-table>
            </v-flex>
        </v-layout>

        <v-layout column>
            <div class="pt-3">
                <h5>Total: {{apiMeta.total}}</h5>
            </div>
        </v-layout>
        <v-divider></v-divider>
        <v-layout row justify-space-between>

            <div>
                <v-pagination
                    v-model="apiMeta.current_page"
                    round
                    :length="apiMeta.last_page"
                    total-visible="10"
                    @input="fetchUsers"
                ></v-pagination>
            </div>

            <div>
                <v-select
                    v-if="!states.isLoading"
                    solo
                    messages="Items per page"
                    :items="[10,25,50,100,200,500,1000]"
                    v-model="pageSize"
                    @change="fetchUsers"
                    label="Items per page"
                    style="width: 150px;"
                ></v-select>
            </div>
        </v-layout>



    </v-container>
</template>

<script>
    import {EventBus} from "../../../../vue-tools/event-bus";
    import SwalMixin from "../../../../mixins/SwalMixin";
    import UserManagementTableActionList from "./UserManagementTableActionList";

    export default {
        name: "UserManagementTable",
        components: {UserManagementTableActionList},
        mixins: [SwalMixin],
        data() {
            return {
                states: {
                    isLoading : false,  // if true then show loader
                },
                apiMeta:{},
                pageSize: 200,
                searchKeywords: "",
                searchProductTimeoutId: null,

                data: {
                    users : [],  // hold users info from api call
                },

                headers: [
                    {
                        text: 'Last Name',
                        align: 'left',
                        sortable: true,
                        value: 'last_name',
                        class: "px-2"
                    },
                    { text: 'First Name', value: 'first_name', sortable: true, class: "px-2" },
                    { text: 'E-mail', value: 'email', sortable: true, class: "px-2" },
                    { text: 'Confirmed', value: 'confirmed', sortable: false, class: "px-2" },
                    { text: 'Roles', value: 'roles', sortable: false, class: "px-2"},
                    { text: 'Other Permissions', value: 'other', sortable: false, class: "px-2" },
                    { text: 'Social', value: 'social', sortable: false, class: "px-2" },
                    { text: 'Last Updated', value: 'last_updated', sortable: false, class: "px-2" },
                    { text: 'Actions', value: 'action', sortable: false, class: "px-2" },
                ],

            }
        },
        props: {
            userType: {  // could be 'active', 'deactivated', 'deleted', 'all',
                type: String,
                default: "active"
            }
        },

        watch: {
            searchKeywords: _.throttle(function () {
                clearTimeout(this.searchProductTimeoutId);
                this.isLoading = false;
                this.searchProductTimeoutId = setTimeout(function(){
                    this.fetchUsers();
                }.bind(this), 1500);
            }),
        },
        computed: {

        },
        methods: {
            deleteItem(item){
                this.swalLoader();
                this.states.isLoading = true;
                let uri = '/api/v1/users/' + String(item.id);
                axios.delete(uri)
                    .then(function (response) {
                        swal.close();
                        this.states.isLoading = false;
                        this.reloadTable();

                    }.bind(this)).catch(function (response) {
                        console.log('Error: ' + response);

                        let errors = response.response.data.error;
                        if ((typeof errors) === "string")
                            errors = {errors};
                        swal.close();
                        this.swalMessage("error", errors)

                    }.bind(this));
            },
            fetchUsers(){
                this.swalLoader();
                this.states.isLoading = true;
                let uri;
                uri = `/api/v1/users?page=${this.apiMeta.current_page}`;
                if(this.searchKeywords != null)
                    uri += `&search_keywords=${this.searchKeywords}`;

                uri += `&status=${this.userType}&page_size=${this.pageSize}`;

                //fetch data / call api
                return axios.get(uri)
                    .then(function (response) {
                        swal.close();
                        this.data.users = response.data.data;
                        this.states.isLoading = false;
                        this.apiMeta = response.data.meta;

                    }.bind(this)).catch(function (response) {
                        console.log('Error: ' + response);

                        let errors = response.response.data.error;
                        if ((typeof errors) === "string")
                            errors = {errors};
                        swal.close();
                        this.swalMessage("error", errors)

                }.bind(this));
            },
            reloadTable(){
                this.fetchUsers()
            }
        },
        mounted() {
            // call api -- grab users deets
            this.reloadTable();

            EventBus.$on("table-reload-required", function () {
                this.reloadTable();
            }.bind(this))
        },
    }
</script>

<style scoped>
    .no-underline:hover {
        text-decoration: none;
    }
</style>
