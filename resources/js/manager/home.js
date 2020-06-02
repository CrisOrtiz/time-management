import {generateRoute, getRequestError} from "../helpers";
import api from '../api';
import axios from 'axios';
import Vue from 'vue';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-default.css';
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/default.css'
import User from '../models/user.model'
import ToggleButton from 'vue-js-toggle-button'
import VueCircleSlider from 'vue-circle-slider'
 
Vue.use(VueCircleSlider)
Vue.use(VueToast);
Vue.forceUpdate;
Vue.use(ToggleButton);
Vue.component('VueSlider', VueSlider);

var managerHome = new Vue({
        el: '#manager-home',
        data: {
            user: new User(window.user),
            oldPassword: "",
            newPassword: "",
            newPasswordRepeat: "",
        },
        computed: {

        },
        methods: {
            updateUserData(){
                api.post(window.updateUserDataUrl, this.user)
                .then(response => {
                    Vue.$toast.success('Datos Actualizados');
                }, error => {
                    Vue.$toast.error(getRequestError(error));
                });
            },
            updateUserPassword(){
                api.post(window.updateUserPasswordUrl, {'id':this.user.id,'username':this.user.username,'oldPassword':this.oldPassword,'newPassword':this.newPassword,'newPasswordRepeat':this.newPasswordRepeat})
                .then(response => {
                    this.oldPassword = "";
                    this.newPassword = "";
                    this.newPasswordRepeat = "";
                    Vue.$toast.success('Contraseña Actualizada');
                }, error => {
                    Vue.$toast.warning('Fallo! Verifica las contraseñas');
                });
            },
        },
});



 
