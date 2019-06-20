/* Get App params nad helper functions*/
import Vue from 'vue'
import SwalMixin from '../mixins/SwalMixin'

export const MessageBus = new Vue({
    data(){
        return {
            session: {},
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
        setSession(sessionJsonString){
            this.session.session = JSON.parse(sessionJsonString)  // available only if an admin log in as another user
        },

        isReady(){
            return this.states.ready;
        },

        fetchSession(){
            return axios.get('/api/v1/auth/current-user')
                .then(function (response) {
                    this.session.user = response.data.data;
                }.bind(this))
                .catch(function (response) {
                    if(response.response.data.message && response.response.data.message === 'Unauthenticated.')
                        return this.session.user = null;

                    let errors = response.data.data.error;
                    if ((typeof errors) === "string")
                        errors = {errors};
                    swal.close();
                    this.swalMessage("error", errors);
                }.bind(this))
                .then(function () {
                    this.states.ready= true;
                }.bind(this))
        }
    },
    created(){
        this.fetchSession();
    }
});
