<template>
    <user-management-table></user-management-table>
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
