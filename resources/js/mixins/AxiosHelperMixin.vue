<script>

    import SwalMixin from "./SwalMixin";
    export default {
        name: "AxiosHelperMixin",
        components: {},
        mixins : [SwalMixin],
        data() {
            return {}
        },

        methods: {

            /*Helper function to catch error returned by axios, afterCallback function accept the response object
            *
            * */
            axiosErrorCallback(response, afterCallback){
                let errors = response.response.data.error;
                if ((typeof errors) === "string")
                    errors = {errors};
                swal.close();
                this.swalMessage("error", errors);
                afterCallback(response)
            }
        },
        mounted() {

        },
    }
</script>

<style scoped>

</style>
