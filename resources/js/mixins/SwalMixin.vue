<script>
    export default {
        name: "SwalMixin",
        data() {
            return {

            }
        },
        props: {},
        computed: {},
        methods: {
            /*
            * Helper function to show user the current status
            * Message type could be 'success' 'error' 'info', "warning"
            * Info is pretty printed JSON to display as swal body
            * * */
            swalTimer(messageType, timer=1500, info){
                let title = messageType.toUpperCase();
                if(_.isEmpty(info))
                    info = "";

                swal({
                    title: title,
                    type: messageType,
                    showCancelButton: false,
                    showConfirmButton: true,
                    confirmButtonText: 'Okay',
                    confirmButtonClass: 'success',
                    buttonsStyling: true,
                    timer: timer,
                    html:"<pre><code>" + info + "</code></pre>",
                }).then(function (result) {
                    if(result.value){ //confirm
                        return;
                    }
                    if(result.dismiss === swal.DismissReason.cancel){ //cancel
                        return;
                    }
                }.bind(this));
            },

            swalMessage(messageType, info){
                let title = messageType.toUpperCase();
                if(_.isEmpty(info))
                    info = "";
                swal({
                    title: title,
                    type: messageType,
                    showCancelButton: false,
                    confirmButtonText: 'Okay',
                    confirmButtonClass: 'success',
                    buttonsStyling: true,
                    html:"<pre><code>" + info + "</code></pre>",
                }).then(function (result) {
                    if(result.value){ //confirm
                        return;
                    }
                }.bind(this));
            },

            swalLoader(info){
                if(_.isEmpty(info))
                    info = "";

                swal({
                    persistent: true,
                    title: "Loading",
                    showCancelButton: false,
                    showConfirmButton: false,
                    buttonsStyling: true,
                    html:"<pre><code>" + info + "</code></pre>",
                    onBeforeOpen(){
                        swal.showLoading()
                    }
                }).then(function (result) {
                    if(result.value){ //confirm

                        return;
                    }
                }.bind(this));
            },

            swalConfirm(html="", confirmCallback, rejectCallback){
                return swal({
                    title: "Are you sure?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    confirmButtonClass: 'success',
                    cancelButtonClass: 'error',
                    buttonsStyling: true,
                    html:html,
                    cancelButtonText: 'No'
                }).then(function (result) {
                    if(result.value){ //confirm
                        if(confirmCallback)
                            confirmCallback();
                        return;
                    }
                    if(result.dismiss === swal.DismissReason.cancel){ //cancel
                        if(rejectCallback)
                            rejectCallback();
                        return;
                    }
                }.bind(this));
            }


        },
        mounted() {

        },
    }
</script>

<style scoped>

</style>
