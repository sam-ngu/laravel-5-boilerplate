<template>
    <collapsible-sidebar :show-sidebar="show" @dismiss-sidebar="back">
        <template slot="header">
            <h1>Create User</h1>
        </template>

        <template slot="content">
            <v-container>
                <v-layout row>
                    <v-flex>
                        <user-create-form @user-created="back"></user-create-form>

                    </v-flex>
                </v-layout>
            </v-container>
        </template>

    </collapsible-sidebar>
</template>

<script>
    import CollapsibleSidebar from "../../../../vue-tools/CollapsibleSidebar";
    import SwalMixin from "../../../../mixins/SwalMixin";
    import UserCreateForm from "./UserCreateForm";
    export default {
        name: "BaseUserCreate",
        mixins: [SwalMixin],
        components: {UserCreateForm, SwalMixin, CollapsibleSidebar},
        data() {
            return {
                show: false,
            }
        },
        props: {},
        computed: {},
        methods: {
            back() {
                this.$router.push({name: 'user-management'})
            }
        },
        mounted() {
            this.show = true; // trigger fade effect
        },
    }
</script>

<style scoped>

</style>
