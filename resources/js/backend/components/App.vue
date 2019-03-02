<template>
    <v-app :dark="dark">
        <layout-master :disable-sidebar="showSidebar">
            <router-view></router-view>
        </layout-master>
    </v-app>
</template>

<script>
    import LayoutMaster from "./layout/Master";
    import {EventBus} from "../../vue-tools/event-bus";

    export default {
        name: 'app',
        components: {
            LayoutMaster,
        },
        data(){
            return{
                dark: false,
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
        methods: {
            fetchAppConfig(){

            },

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
