<template>
    <collapsible-sidebar v-model="states.show">
        <template slot="header">
            <h1>Create User</h1>
        </template>

        <template slot="content">
            <v-container>
                <v-row >
                    <v-col>
                        <user-create-form @user-created="back"></user-create-form>

                    </v-col>
                </v-row>
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
        components: {UserCreateForm, CollapsibleSidebar},
        data() {
            return {
                states: {
                    show: false,
                }
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
