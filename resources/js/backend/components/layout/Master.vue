<template>
    <div>
        <logged-in-as-alert/>

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
    import LoggedInAsAlert from "./LoggedInAsAlert";


    export default {
        name: "layout-master",
        components: {LoggedInAsAlert, Navbar, Sidebar},
        data() {
            return {
                showSidebar: null,
            }
        },
        props: {
            disableSidebar: {
                type: Boolean,
                default: false
            }
        },
        methods: {

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
