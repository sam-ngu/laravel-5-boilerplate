<template>
    <v-navigation-drawer
            app
            hide-overlay
            clipped
            fixed
            :value="value"
            floating
            @input="($event)=>{$emit('input', $event)}"

    >
        <v-list inset>

            <sidebar-list-tile to="/" title="Dashboard" icon="home"/>

            <sidebar-list-tile :to="{name: 'user-profile'}" title="My Profile" icon="account_circle"/>

        </v-list>
    </v-navigation-drawer>
</template>

<script>
    import {EventBus} from "../../../../../utils/event-bus";
    import SidebarListTile from "./SidebarListTile";

    export default {
        name: "sidebar",
        components: {SidebarListTile},
        data() {
            return {
            }
        },
        computed:{

        },
        props: {
            value: ""
        },
        methods: {},
        mounted() {
            EventBus.$on('toggled-sidebar', function(){
                this.show = !this.show;
            }.bind(this))
        },
    }


</script>

<style scoped>

</style>
