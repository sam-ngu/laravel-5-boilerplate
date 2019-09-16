<template>
    <v-container>
        <v-row>
            <v-col>
                <v-toolbar flat>
                    <v-toolbar-title>User Management</v-toolbar-title>

                    <v-spacer></v-spacer>

                    <button-tooltip
                        tooltip="Add new user"
                        icon="add"
                        @click="() => $router.push({name: 'user-create'})"
                    />
<!--                    <v-tooltip bottom class="ml-auto">-->
<!--                        <template slot="activator">-->
<!--                            <v-btn-->
<!--                                icon-->
<!--                                color="success"-->
<!--                                class="no-underline"-->
<!--                                :to="{-->
<!--                                    name: 'user-create',-->
<!--                                }"-->
<!--                            ><v-icon>add</v-icon></v-btn>-->
<!--                        </template>-->
<!--                        <span>Add new user</span>-->
<!--                    </v-tooltip>-->
                </v-toolbar>
            </v-col>
        </v-row>

        <v-row> <!--search bar-->
            <v-col>
                <v-text-field
                    class="pl-2 pr-12"
                    append-icon="fas fa-search"
                    label="Search"
                    v-model="searchKeywords"></v-text-field>
            </v-col>
        </v-row>



        <v-row>
            <v-col>

                <v-tabs fixed-tabs
                        v-model="tab"
                        @change="switchTab"
                >
                    <v-tab
                        v-for="(item, index) in tabList"
                        :key="index"
                    >
                        {{titleCase(item.title)}}
                    </v-tab>
                </v-tabs>

                <user-table
                    :data="data.users"
                    :is-loading="states.isLoading"
                ></user-table>
            </v-col>
        </v-row>

        <v-row >
            <v-col>

                <div class="pt-4">
                    <h5>Total: {{apiMeta.total}}</h5>
                </div>
            </v-col>
        </v-row>
        <v-divider></v-divider>
        <v-row justify-space-between>

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
        </v-row>


    </v-container>
</template>

<script>
    import {EventBus} from "../../../../vue-tools/event-bus";
    import SwalMixin from "../../../../mixins/SwalMixin";
    import UserTable from "./UserTable";
    import StringHelperMixin from "../../../../mixins/StringHelperMixin";
    import ButtonTooltip from "../../../../vue-tools/ButtonTooltip";

    export default {
        name: "BaseTableLayout",
        components: {ButtonTooltip, UserTable},
        mixins: [SwalMixin, StringHelperMixin],
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

                tab: 0,
                tabList: [
                    {title: "active"},
                    {title: "deactivated"},
                    {title: "deleted"},
                ]
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

            async fetchUsers(){
                await this.$nextTick();
                this.swalLoader();
                this.states.isLoading = true;
                let uri;
                uri = `/api/v1/users?page=${this.apiMeta.current_page}`;
                if(this.searchKeywords != null)
                    uri += `&search_keywords=${this.searchKeywords}`;

                let userStatus = this.tabList[this.tab].title;

                uri += `&status=${userStatus}&page_size=${this.pageSize}`;

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
            },
            switchTab(tabIndex){
                this.tab = tabIndex;
                this.reloadTable()
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
