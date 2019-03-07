<template>
    <v-container>
        <v-toolbar flat color="white">
                <v-toolbar-title>User Management</v-toolbar-title>
                <v-divider
                    class="mx-2"
                    inset
                    vertical
                ></v-divider>
                <v-spacer></v-spacer>
                <!--<v-dialog v-model="dialog" max-width="500px">-->
                <!--<template v-slot:activator="{ on }">-->
                <!--<v-btn color="primary" dark class="mb-2" v-on="on">New Item</v-btn>-->
                <!--</template>-->
                <!--<v-card>-->
                <!--<v-card-title>-->
                <!--<span class="headline">{{ formTitle }}</span>-->
                <!--</v-card-title>-->

                <!--<v-card-text>-->
                <!--<v-container grid-list-md>-->
                <!--<v-layout wrap>-->
                <!--<v-flex xs12 sm6 md4>-->
                <!--<v-text-field v-model="editedItem.name" label="Dessert name"></v-text-field>-->
                <!--</v-flex>-->
                <!--<v-flex xs12 sm6 md4>-->
                <!--<v-text-field v-model="editedItem.calories" label="Calories"></v-text-field>-->
                <!--</v-flex>-->
                <!--<v-flex xs12 sm6 md4>-->
                <!--<v-text-field v-model="editedItem.fat" label="Fat (g)"></v-text-field>-->
                <!--</v-flex>-->
                <!--<v-flex xs12 sm6 md4>-->
                <!--<v-text-field v-model="editedItem.carbs" label="Carbs (g)"></v-text-field>-->
                <!--</v-flex>-->
                <!--<v-flex xs12 sm6 md4>-->
                <!--<v-text-field v-model="editedItem.protein" label="Protein (g)"></v-text-field>-->
                <!--</v-flex>-->
                <!--</v-layout>-->
                <!--</v-container>-->
                <!--</v-card-text>-->

                <!--<v-card-actions>-->
                <!--<v-spacer></v-spacer>-->
                <!--<v-btn color="blue darken-1" flat @click="close">Cancel</v-btn>-->
                <!--<v-btn color="blue darken-1" flat @click="save">Save</v-btn>-->
                <!--</v-card-actions>-->
                <!--</v-card>-->
                <!--</v-dialog>-->
            </v-toolbar>

        <v-data-table
            :headers="headers"
            :items="data.users"
            :loading="states.isLoading"
            class="elevation-1"
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
                    <v-icon
                        small
                        class="mr-2"
                        @click="editItem(props.item)"
                        >
                        edit
                    </v-icon>
                    <v-icon
                        small
                        @click="deleteItem(props.item)"
                    >
                        delete
                    </v-icon>
                    </td>
                </tr>

            </template>
        </v-data-table>


    </v-container>
</template>

<script>
    export default {
        name: "UserManagementTable",
        data() {
            return {
                states: {
                    isLoading : false,  // if true then show loader
                },
                data: {
                    users : []  // hold users info from api call
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
        computed: {},
        methods: {
            fetchUsers(){
                this.states.isLoading = true;
                let uri;

                uri = `/api/v1/user`;

                let params = {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    page_size: 25,
                };

                //fetch data / call api
                return axios.get(uri, {
                    params: params
                }).then(function (response) {
                    this.data.users = response.data.data;
                    this.states.isLoading = false;

                }.bind(this)).catch(function (response) {
                    console.log('Error: ' + response);
                });
            }
        },
        mounted() {
            // call api -- grab users deets
            this.fetchUsers()

        },
    }
</script>

<style scoped>

</style>
