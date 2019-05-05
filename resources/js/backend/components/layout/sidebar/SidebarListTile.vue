<template>
    <v-list-tile :to="to">
        <v-list-tile-action>
            <v-icon>{{icon}}</v-icon>
        </v-list-tile-action>
        <v-list-tile-title v-text="title"></v-list-tile-title>
    </v-list-tile>
</template>

<script>
    export default {
        name: "SidebarListTile",
        props: {
            to: {
                default: "#",
                type: Object | String,
            },
            icon: {
                default: 'home',
                type: String,
            },
            title: {
                required: true,
                type: String,
            }
        }
    }
</script>

<style scoped>

</style>
