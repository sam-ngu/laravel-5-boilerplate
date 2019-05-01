<script>
    export default {
        name: "PermissionMixin",
        data() {
            return {
                permissions: [],
                states: {
                    isLoading: false,
                }
            }
        },
        methods: {
            fetchPermissions(){
                let uri = "/api/v1/permissions";
                this.states.isLoading = true;

                //fetch data / call api
                return axios.get(uri)
                    .then(function (response) {
                        swal.close();
                        this.permissions = response.data.data;
                        this.states.isLoading = false;
                        // this.apiMeta = response.data.meta;

                    }.bind(this)).catch(function (response) {
                        console.log('Error: ' + response);

                        let errors = response.response.data.error;
                        if ((typeof errors) === "string")
                            errors = {errors};
                        swal.close();

                        this.swalMessage("error", errors)

                    }.bind(this));
            }
        },
        mounted() {
            this.fetchPermissions()
        },
    }
</script>

<style scoped>

</style>
