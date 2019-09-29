<template>
    <layout-master navbar-initial-colour="transparent">
        <base-index></base-index>
    </layout-master>
</template>

<script>
    import LayoutMaster from "./layout/Master";
    import BaseIndex from "./index/BaseIndex";
    export default {
        name: "BasePublic",
        components: {
            BaseIndex, LayoutMaster,
        },
        data() {
            return {}
        },
        props: {},
        computed: {},
        methods: {},
        mounted() {

        },
    }
</script>

<style scoped>

</style>
