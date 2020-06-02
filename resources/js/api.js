import axios from 'axios';

axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

export default {
    get(url, params = {}) {
        return axios.get(url, {
            params
        });
    },
    post(url, data = {}) {
        return axios.post(url, data);
    }
};
