<template>
    <div>
        <v-app v-if="messageBus.isReady()">
            <navbar :initial-colour="navbarInitialColour"></navbar>

            <v-content>
                <slot></slot>
            </v-content>
            <base-footer></base-footer>

            <base-privacy-notice/>

        </v-app>
        <loading-eclipse v-else/>

    </div>


</template>

<script>
    import Navbar from "./navbar/NavBar";
    import BaseFooter from "./footer/BaseFooter";
    import {MessageBus} from "../../../../utils/message-bus";
    import LoadingEclipse from "../../../../utils/LoadingEclipse";
    import BasePrivacyNotice from "./privacy-notice/BasePrivacyNotice";

    export default {
        name: "layout-master",
        components: {BasePrivacyNotice, LoadingEclipse, BaseFooter, Navbar},
        data() {
            return {
                messageBus: MessageBus
            }
        },
        props: {
            navbarInitialColour: {
                default: "grey darken-3",
                type: String,
            }
        },
        mounted() {

        },
    }


</script>

<style scoped>

</style>
