import Vue from 'vue';
import api from '../api';
import {getRequestError} from "../helpers";
import vSelect from 'vue-select';

Vue.component('v-select', vSelect);

const countries = [
    {
        label: 'Bolivia',
        value: 'BO'
    },
    {
        label: 'Brazil',
        value: 'BRA'
    },
    {
        label: 'Colombia',
        value: 'CO'
    },
    {
        label: 'Perú',
        value: 'PE'
    }
];

const userTypes = [
    {
        label: 'Super Administrador',
        value: 1
    },
    {
        label: 'Administrador',
        value: 2
    },
    {
        label: 'Trabajador',
        value: 3
    },
    {
        label: 'Supervisor',
        value: 4
    }
];

window['app'] = new Vue({
    el: '#user-create',
    components: {
    },
    data: {
        companies: window.companies,
        countries,
        user: {
            name: '',
            surname: '',
            username: '',
            user_type: userTypes[0],
            country: countries[0],
            company: null,
            password: '',
            password_confimation: '',
            app_code: '10+2'
        },
        saving: false,
        userTypes,
    },
    methods: {
        save() {
            const data = {...this.user};
            data.user_type = (data.user_type && data.user_type.value) || null;
            data.country = (data.country && data.country.value) || null;
            data.company = (data.company && data.company.id) || null;
            this.saving = true;
            api.post(window.saveUserUrl, data)
                .then(response => {
                    Swal.fire({
                        title: 'Creado!',
                        text: 'Usuario creado correctamente.',
                        icon: 'success'
                    }).then((result) => {
                        if (result.value) {
                            window.location = window.listUserUrl;
                        }
                    })
                }, error => {
                    this.saving = false;
                    Swal.fire({
                        icon: 'error',
                        html: getRequestError(error)
                    });
                });
        }
    }
});
