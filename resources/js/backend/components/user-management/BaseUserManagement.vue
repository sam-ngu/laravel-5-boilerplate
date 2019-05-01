<template>
    <v-container>
        <v-tabs fixed-tabs v-model="tab">
            <v-tab v-for="(item, index) in tabList" :key="index">{{titleCase(item.title)}}</v-tab>
        </v-tabs>
        <user-management-table :user-type="tabList[tab].title"></user-management-table>
        <router-view></router-view>
    </v-container>
</template>

<script>
    import UserManagementTable from "./user-table/UserManagementTable";
    import StringHelperMixin from "../../../mixins/StringHelperMixin";

    export default {
        name: "BaseUserManagement",
        mixins: [StringHelperMixin],
        components: {UserManagementTable},
        data() {
            return {
                tab: 0,
                tabList: [
                    {title: "active"},
                    {title: "deactivated"},
                    {title: "deleted"},
                ]
            }
        },
        props: {},
        computed: {},
        methods: {},
        mounted() {

        },
    }
</script>

<style scoped>

</style>
