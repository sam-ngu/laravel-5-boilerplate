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
                                icon color="success"
                                :to="{
                                    name: 'create',
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
                            <td class="text-xs-left" >
                                <router-link :to="{
                            name: 'show',
                            params: {
                                id: props.item.id,
                                data: props.item,
                                show: true,
                            }
                        }">
                                    {{ props.item.last_name }}
                                </router-link>
                            </td>
                            <td class="text-xs-left">{{ props.item.first_name }}</td>
                            <td class="text-xs-left">{{ props.item.email }}</td>
                            <td class="text-xs-right">
                                <v-chip text-color="white" :color="props.item.confirmed_label ? 'green' : 'red'">
                                    {{ props.item.confirmed_label ? 'Yes' : 'No' }}
                                </v-chip>
                            </td>
                            <td class="text-xs-left">{{ props.item.roles_label }}</td>
                            <td class="text-xs-right">{{ props.item.permissions_label }}</td>
                            <td class="text-xs-right">{{ props.item.social_buttons }}</td>
                            <td class="text-xs-right">{{ props.item.updated_at }}</td>
                            <td class="justify-center layout px-0">
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
    import {EventBus} from "../../../vue-tools/event-bus";
    import SwalMixin from "../../../mixins/SwalMixin";
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
                        value: 'last_name'
                    },
                    { text: 'First Name', value: 'first_name', sortable: true },
                    { text: 'E-mail', value: 'email', sortable: true },
                    { text: 'Confirmed', value: 'confirmed', sortable: false },
                    { text: 'Roles', value: 'roles', sortable: false},
                    { text: 'Other Permissions', value: 'other', sortable: false },
                    { text: 'Social', value: 'social', sortable: false },
                    { text: 'Last Updated', value: 'last_updated', sortable: false },
                    { text: 'Actions', value: 'action', sortable: false },
                ],

            }
        },
        props: {},

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
                let uri = '/api/v1/user/' + String(item.id);
                axios.delete(uri)
                    .then(function (response) {
                        swal.close();
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
            fetchUsers(){
                this.swalLoader();
                this.states.isLoading = true;
                let uri;
                uri = `/api/v1/user?page=${this.apiMeta.current_page}`;
                if(this.searchKeywords != null)
                    uri += `&search_keywords=${this.searchKeywords}`;

                uri += `&page_size=${this.pageSize}`;

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
            }
        },
        mounted() {
            // call api -- grab users deets
            this.fetchUsers();

            EventBus.$on("table-reload-required", function () {
                this.fetchUsers()
            }.bind(this))
        },
    }
</script>

<style scoped>

</style>
