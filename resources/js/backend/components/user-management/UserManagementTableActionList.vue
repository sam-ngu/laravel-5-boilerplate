<template>
    <v-menu offset-y left>
        <v-tooltip
            bottom
            slot="activator"
        >
            <v-icon
                slot="activator"
                small
                class="mr-2"
            >
                more_vert
            </v-icon>
            <span>more</span>
        </v-tooltip>
        <v-list>
            <v-list-tile
                v-for="(item, index) in listItems"
                :key="index"
                :disabled="item.disabled"
                @click="item.action.call()"
            >
                <v-list-tile-title>{{ item.title }}</v-list-tile-title>
            </v-list-tile>
        </v-list>
    </v-menu>
</template>

<script>
    import {MessageBus} from "../../../vue-tools/message-bus";

    export default {
        name: "UserManagementTableActionList",
        data() {
            return {
                listItems: [
                    {
                        title: "Log in as " + this.user.first_name + ' ' + this.user.last_name,
                        action: this.logInAsUser,
                        disabled: MessageBus.getSession().user.id === this.user.id,
                    },
                    {
                        title: 'Deactivate',
                        action: this.deactivate,
                        disabled: MessageBus.getSession().user.id === this.user.id,
                    }
                ]
            }
        },
        props: {
            user: {
                type: Object,
                required: true,
            }
        },
        computed: {},
        methods: {
            logInAsUser(){
                let uri = '/api/v1/admin/auth/'
                axios.get()
            },
            deactivate(){

            }
        },
        mounted() {

        },
    }
</script>

<style scoped>

</style>
