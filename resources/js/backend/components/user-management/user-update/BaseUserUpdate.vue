<template>
    <collapsible-sidebar :show-sidebar="show" @dismiss-sidebar="back">
        <template slot="header">
            {{data.first_name}} {{data.last_name}}
        </template>

        <template slot="content">
            <user-update-form :data="data" @user-updated="back"></user-update-form>
        </template>

    </collapsible-sidebar>
</template>

<script>
    import CollapsibleSidebar from "../../../../vue-tools/CollapsibleSidebar";
    import SwalMixin from "../../../../mixins/SwalMixin"
    import UserUpdateForm from "./UserUpdateForm";

    export default {
        name: "BaseUserUpdate",
        components: {UserUpdateForm, CollapsibleSidebar},
        mixins: [SwalMixin],
        data() {
            return {
                show: false,
            }

        },
        props: {
            data: {
                type: Object,
                required: true,
            }
        },
        computed: {},
        methods: {

            back() {
                this.$router.push({name: 'user-management'})
            }
        },
        mounted() {
            this.show = true;  // trigger fade effect
        },
    }
</script>

<style scoped>

</style>
