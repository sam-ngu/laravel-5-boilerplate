<template>
    <v-snackbar v-model="snackShow" :timeout="3000" :color="snackColor">
        {{ snackText }}
        <v-btn flat @click="snackShow = false">Close</v-btn>
    </v-snackbar>
</template>

<script>
    export default {
        name: "SnackMixin",
        data() {
            return {
                snackShow: false,
                snackText: null,
                snackColor: null,
            }
        },
        props: {},
        computed: {},
        methods: {
            /* Helper function to display snack
            * Message type could be 'success' 'error' 'loading'
            * */
            snack(messageType) {
                this.snackShow = true;
                switch (messageType) {
                    case 'success':
                        this.snackColor = 'success';
                        this.snackText = 'Saved';
                        break;
                    case 'error':
                        this.snackColor = 'error';
                        this.snackText = 'Canceled';
                        break;
                    case 'loading':
                        this.snackColor = 'info';
                        this.snackText = 'Loading';
                        break;
                    default:
                        this.snackColor = 'info';
                        this.snackText = 'Info';
                        break;
                }
            },
        },
        mounted() {
            console.log("Snack Mixin loaded")
        },
    }
</script>

<style scoped>

</style>
