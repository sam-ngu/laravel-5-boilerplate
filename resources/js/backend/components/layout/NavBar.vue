<template>
    <v-toolbar
            app
            clipped-left
            dense
            fixed
            color="red darken-4">
        <v-toolbar-side-icon @click="toggleSideBar"></v-toolbar-side-icon>

        <v-toolbar-title > <router-link class="white--text" style="text-decoration: none;" :to="{name: 'home'}">Boilerplate</router-link></v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon>
            <v-icon>search</v-icon>
        </v-btn>

        <v-btn icon>
            <v-icon>apps</v-icon>
        </v-btn>

        <v-btn @click="toggleDarkMode" icon>
            <v-icon :color="darkModeIconColor">brightness_3</v-icon>
        </v-btn>

        <v-menu offset-y>
            <v-btn
                slot="activator"
                icon
            >
                <v-icon>more_vert</v-icon>
            </v-btn>
            <v-list>
                <v-list-tile
                    v-for="(item, index) in menuItems"
                    :key="index"
                    @click="item.action.call()"
                >
                    <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                </v-list-tile>
            </v-list>
        </v-menu>
        <!--<v-btn icon>-->
            <!--<v-icon>more_vert</v-icon>-->
        <!--</v-btn>-->
    </v-toolbar>
</template>

<script>
    import {EventBus} from "../../../vue-tools/event-bus";

    export default {
        name: "navbar",
        components: {},
        data() {
            return {
                dark: false,

                menuItems: [
                    {title: 'Control', action: this.control},
                    {title: 'Logout', action: this.logout}
                ]
            }
        },
        props: {},
        computed: {
            darkModeIconColor(){
                return this.dark ? "white" : null
            }
        },
        methods: {
            toggleDarkMode(){
                this.dark = !this.dark;
                EventBus.$emit('toggled-dark')

            },
            toggleSideBar(){
                EventBus.$emit('toggled-sidebar')
            },
            logout(){
                window.location.href = '/logout';
            },
            control(){
                this.$router.push({
                    name: 'control',
                })
            }

        },
        mounted() {

        },
    }


</script>

<style scoped>

</style>
