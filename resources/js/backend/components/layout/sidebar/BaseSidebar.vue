<template>
    <v-navigation-drawer
            app
            hide-overlay
            width="300"
            clipped
            fixed
            :value="value"
            floating
            @input="($event)=>{$emit('input', $event)}"

    >
        <v-list inset>
            <sidebar-list-tile to="/" title="Dashboard" icon="home"/>


            <!--<v-list-item to="/">-->
                <!--<v-list-item-action>-->
                    <!--<v-icon>home</v-icon>-->
                <!--</v-list-item-action>-->
                <!--<v-list-item-title>Dashboard</v-list-item-title>-->
            <!--</v-list-item>-->

            <!--<v-list-item to="/backtest">-->
                <!--<v-list-item-action>-->
                    <!--<v-icon>equalizer</v-icon>-->
                <!--</v-list-item-action>-->
                <!--<v-list-item-title>Menu</v-list-item-title>-->
            <!--</v-list-item>-->

            <!--<v-list-item to="/trade-history">-->
                <!--<v-list-item-action>-->
                    <!--<v-icon>av_timer</v-icon>-->
                <!--</v-list-item-action>-->
                <!--<v-list-item-title>Menu</v-list-item-title>-->
            <!--</v-list-item>-->

            <v-list-group
                    v-if="session.user.roles_label === 'Administrator'"
                    prepend-icon="account_circle"
                    value="true"
            >
                <v-list-item slot="activator">
                    <v-list-item-title>Users</v-list-item-title>
                </v-list-item>

                <v-list-group
                        no-action
                        sub-group
                        value="true"
                >
                    <v-list-item slot="activator">
                        <v-list-item-title>Access</v-list-item-title>
                    </v-list-item>

                    <sidebar-list-tile
                        v-for="(admin, i) in admins"
                        :key="i"
                        :to="admin.to"
                        :icon="admin.icon"
                        :title="admin.name"
                    />

                    <!--<v-list-item-->
                            <!--v-for="(admin, i) in admins"-->
                            <!--:key="i"-->
                            <!--@click=""-->
                            <!--:to="admin.to"-->
                    <!--&gt;-->
                        <!--<v-list-item-title v-text="admin.name"></v-list-item-title>-->
                        <!--<v-list-item-action >-->
                            <!--<v-icon v-text="admin.icon"></v-icon>-->
                        <!--</v-list-item-action>-->
                    <!--</v-list-item>-->

                </v-list-group>
            </v-list-group>

            <v-list-item
                v-if="session.user.roles_label === 'Administrator'"
                href="/admin/log-viewer">
                <v-list-item-action>
                    <v-icon>event_note</v-icon>
                </v-list-item-action>
                <v-list-item-title>Log Viewer</v-list-item-title>
            </v-list-item>


        </v-list>
    </v-navigation-drawer>
</template>

<script>
    import {EventBus} from "../../../../vue-tools/event-bus";
    import {MessageBus} from "../../../../vue-tools/message-bus";
    import SidebarListTile from "./SidebarListTile";

    export default {
        name: "sidebar",
        components: {SidebarListTile},
        data() {
            return {
                admins: [
                    {
                        name: "User Management",
                        icon: "people_outline",
                        to: {name: 'user-management'}

                    },
                    {
                        name: "Role Management",
                        icon: "settings",
                        to: {name: 'role-management'}

                    },
                ],
                session: MessageBus.getSession(),
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
