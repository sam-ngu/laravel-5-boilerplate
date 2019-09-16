<template>
    <collapsible-sidebar v-model="show" @dismiss-sidebar="back">
        <template slot="header">
            {{titleCase(data.name)}}
        </template>

        <template slot="content">
            <role-update-form :data="data" @role-updated="back"></role-update-form>
        </template>

    </collapsible-sidebar>
</template>

<script>
    import CollapsibleSidebar from "../../../../vue-tools/CollapsibleSidebar";
    import SwalMixin from "../../../../mixins/SwalMixin"
    import StringHelperMixin from "../../../../mixins/StringHelperMixin"
    import RoleUpdateForm from "./RoleUpdateForm";

    export default {
        name: "BaseRoleUpdate",
        components: {RoleUpdateForm, CollapsibleSidebar},
        mixins: [SwalMixin, StringHelperMixin],
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
        methods: {
            back() {
                this.$router.push({name: 'role-management'})
            },
        },
        mounted() {
            this.show = true;  // trigger fade effect
        },
    }
</script>

<style scoped>

</style>
