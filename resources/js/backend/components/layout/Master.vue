<template>
    <div>
        <v-alert
            v-if="displayLogInAsAlert()"
            :value="true"
            color="info"
            icon="info"
            outline>
            You are currently logged in as {{ session.user.first_name + ' ' + session.user.last_name }}.
            <a href="{{ route("frontend.auth.logout-as") }}">Re-Login as {{ session.session.admin_user_name }}</a>.
        </v-alert>

        <sidebar v-if="!disableSidebar" v-model="showSidebar"></sidebar>

        <navbar v-if="!disableSidebar" @toggled-sidebar="showSidebar=!showSidebar"></navbar>

        <v-content>
            <slot></slot>
        </v-content>
    </div>

</template>

<script>
    import Sidebar from "./Sidebar";
    import Navbar from "./NavBar";
    import {EventBus} from "../../../vue-tools/event-bus";
    import {MessageBus} from "../../../vue-tools/message-bus";


    export default {
        name: "layout-master",
        components: {Navbar, Sidebar},
        data() {
            return {
                showSidebar: null,
                session: null,
            }
        },
        props: {
            disableSidebar: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            displayLogInAsAlert(){
                let session = MessageBus.getSession();
                return !_.isEmpty(session.user) && session.session.admin_user_id && session.session.temp_user_id;
            }
        },
        mounted() {
            EventBus.$on('toggled-sidebar', function () {
                this.showSidebar = !this.showSidebar;
            }.bind(this))
        },
    }


</script>

<style scoped>

</style>
