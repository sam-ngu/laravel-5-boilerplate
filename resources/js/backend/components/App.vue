<template>
    <v-app :dark="dark">
        <layout-master :disable-sidebar="showSidebar" v-if="messageBus.isReady()">
            <v-breadcrumbs :items="breadcrumbItems" divider=">"></v-breadcrumbs>
            <router-view></router-view>
        </layout-master>
        <loading-eclipse v-if="!messageBus.isReady()"></loading-eclipse>
    </v-app>
</template>

<script>
    import LayoutMaster from "./layout/Master";
    import {EventBus} from "../../vue-tools/event-bus";
    import {MessageBus} from "../../vue-tools/message-bus";
    import LoadingEclipse from "../../vue-tools/LoadingEclipse";

    export default {
        name: 'app',
        components: {
            LoadingEclipse,
            LayoutMaster,
        },
        data(){
            return{
                dark: false,
                breadcrumbItems : this.$route.meta.breadcrumb,
                messageBus: MessageBus,
            }
        },
        computed: {
            showSidebar(){
                // if is in control then show
                if(this.$router.full)
                    return true;
                else
                    return false;
            }
        },
        watch: {
            '$route'(){
                this.breadcrumbItems = this.$route.meta.breadcrumb
            }
        },
        methods: {


        },
        mounted(){
            EventBus.$on('toggled-dark', function () {
                this.dark = !this.dark;
            }.bind(this))
        }
    }
</script>

<style>
    /*#app {*/
        /*font-family: 'Avenir', Helvetica, Arial, sans-serif;*/
        /*-webkit-font-smoothing: antialiased;*/
        /*-moz-osx-font-smoothing: grayscale;*/
        /*text-align: center;*/
        /*color: #2c3e50;*/
        /*margin-top: 60px;*/
    /*}*/
</style>
