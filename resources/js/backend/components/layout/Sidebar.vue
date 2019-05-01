<template>
    <v-navigation-drawer
            app
            floating
            hide-overlay
            clipped
            fixed
            :value="value"
            floating
            @input="($event)=>{$emit('input', $event)}"

    >
        <v-list inset>

            <v-list-tile to="/">
                <v-list-tile-action>
                    <v-icon>home</v-icon>
                </v-list-tile-action>
                <v-list-tile-title>Dashboard</v-list-tile-title>
            </v-list-tile>

            <v-list-tile to="/backtest">
                <v-list-tile-action>
                    <v-icon>equalizer</v-icon>
                </v-list-tile-action>
                <v-list-tile-title>Menu</v-list-tile-title>
            </v-list-tile>

            <v-list-tile to="/trade-history">
                <v-list-tile-action>
                    <v-icon>av_timer</v-icon>
                </v-list-tile-action>
                <v-list-tile-title>Menu</v-list-tile-title>
            </v-list-tile>

            <v-list-group
                    v-if="session.user.roles_label === 'Administrator'"
                    prepend-icon="account_circle"
                    value="true"
            >
                <v-list-tile slot="activator">
                    <v-list-tile-title>Users</v-list-tile-title>
                </v-list-tile>

                <v-list-group
                        no-action
                        sub-group
                        value="true"
                >
                    <v-list-tile slot="activator">
                        <v-list-tile-title>Access</v-list-tile-title>
                    </v-list-tile>

                    <v-list-tile
                            v-for="(admin, i) in admins"
                            :key="i"
                            @click=""
                            :to="admin.to"
                    >
                        <v-list-tile-title v-text="admin.name"></v-list-tile-title>
                        <v-list-tile-action >
                            <v-icon v-text="admin.icon"></v-icon>
                        </v-list-tile-action>
                    </v-list-tile>
                </v-list-group>

                <v-list-group
                        sub-group
                        no-action
                >
                    <v-list-tile slot="activator">
                        <v-list-tile-title>Actions</v-list-tile-title>
                    </v-list-tile>

                    <v-list-tile
                            v-for="(crud, i) in cruds"
                            :key="i"
                            @click=""
                    >
                        <v-list-tile-title v-text="crud[0]"></v-list-tile-title>
                        <v-list-tile-action>
                            <v-icon v-text="crud[1]"></v-icon>
                        </v-list-tile-action>
                    </v-list-tile>
                </v-list-group>
            </v-list-group>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
    import {EventBus} from "../../../vue-tools/event-bus";
    import {MessageBus} from "../../../vue-tools/message-bus";

    export default {
        name: "sidebar",
        components: {},
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
                cruds: [
                    ['Create', 'add'],
                    ['Read', 'insert_drive_file'],
                    ['Update', 'update'],
                    ['Delete', 'delete']
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
