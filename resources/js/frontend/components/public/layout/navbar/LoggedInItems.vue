<template>

    <div>
        <v-toolbar-items v-if="!viewport_xs">

            <v-menu bottom left>
                <template v-slot:activator="{on: menu}">
                        <v-tooltip bottom >
                            <template v-slot:activator="{on: tooltip}">
                                <div v-on="{...tooltip, ...menu}">
                                    <base-avatar
                                        class="pt-2"
                                        :name="user.full_name"
                                        :size="35"
                                        :avatar-location="user.avatar_location"
                                    />
                                </div>
                            </template>
                            <span>{{user.full_name}}</span>
                        </v-tooltip>
                </template>


                <v-list dark>
                    <v-list-item
                        v-for="(item, index) in menuItems"
                        :key="index"
                        @click="item.action.call()"
                    >
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item>

                    <v-list-item
                        @click="logout"
                    >
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item>
                </v-list>

            </v-menu>
        </v-toolbar-items>

        <!--xs view port-->
        <v-list v-else>

            <v-list-item avatar>
                <v-list-item-avatar>
                    <base-avatar
                        class="pt-2"
                        :name="user.full_name"
                        :size="35"
                        :avatar-location="user.avatar_location"
                    />
                </v-list-item-avatar>

                <v-list-item-content >
                    <v-list-item-title >
                        {{user.full_name}}
                    </v-list-item-title>

                </v-list-item-content>

                <v-list-item-action>
                    <v-btn text color="red" @click="logout">
                        Logout
                    </v-btn>
                </v-list-item-action>

            </v-list-item>

            <v-divider></v-divider>

            <v-list-item
                v-for="(item, index) in menuItems"
                :key="index"
                @click="item.action.call()"
            >
                <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item>

            <v-divider></v-divider>

        </v-list>

    </div>

</template>

<script>
    import BaseAvatar from "../../../../../vue-tools/BaseAvatar";
    import {MessageBus} from "../../../../../vue-tools/message-bus";
    import ViewportHelperMixin from "../../../../../mixins/ViewportHelperMixin";

    export default {
        name: "LoggedInItems",
        components: {BaseAvatar},
        mixins: [ViewportHelperMixin],
        data() {
            return {
                menuItems: [
                    {
                        title: "Dashboard",
                        url: "",
                        action: this.dashboard
                    },
                    {
                        title: "My Profile",
                        action: this.profile,
                    },
                ]
            }
        },
        props: {},
        computed: {
            user(){
                return MessageBus.getSession().user
            },
        },
        methods: {
            dashboard(){
                // redirect to dashboard
                window.location.href = '/dashboard'
            },
            logout(){
                // redirect to logout
                window.location.href = '/logout';

            },
            profile(){
                // redirect to user profile
                // this.$router.push({name: 'user-profile'});
                window.location.href = '/dashboard#/profile'

            },

        },
        mounted() {
            this.fetchCart();
        },
    }
</script>

<style scoped>
</style>
