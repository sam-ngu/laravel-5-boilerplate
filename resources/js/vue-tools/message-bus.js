/* Get App params nad helper functions*/
import Vue from 'vue'
import SwalMixin from '../mixins/SwalMixin'

export const MessageBus = new Vue({
    data(){
        return {
            session: null,
            states: {
                ready: false, // if false then will load page loader. This is to ensure all variable eg session are loaded before mounting our app
            }
        }
    },
    mixins: [SwalMixin],
    methods: {
        getSession(){
            return this.session;
        },

        isReady(){
            return this.states.ready;
        },

        fetchSession(){
            return axios.get('/api/v1/auth/session')
                .then(function (response) {
                    this.session = response.data.data;
                    this.states.ready = true
                }.bind(this))
                .catch(function (response) {
                    let errors = response.data.data.error;
                    if ((typeof errors) === "string")
                        errors = {errors};
                    swal.close();
                    this.swalMessage("error", errors);
                    this.swalMessage("error", response.response.error)
                }.bind(this))
        }
    },
    created(){
        this.fetchSession();
    }
});
