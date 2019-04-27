<template>
    <v-container>
        <user-management-table></user-management-table>
        <router-view></router-view>

    </v-container>
</template>

<script>
    import UserManagementTable from "./UserManagementTable";

    export default {
        name: "BaseUserManagement",
        components: {UserManagementTable},
        data() {
            return {}
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
