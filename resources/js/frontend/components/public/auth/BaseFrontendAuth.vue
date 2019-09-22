<template>
    <v-app>

        <v-row align="center" justify="center" fill-height>
            <v-col xs10>
                <slot></slot>
            </v-col>
        </v-row>
    </v-app>


</template>

<script>
    import LayoutMaster from "../layout/Master";
    export default {
        name: "BaseFrontendAuth",
        components: {LayoutMaster},
    }
</script>

<style scoped>



</style>
