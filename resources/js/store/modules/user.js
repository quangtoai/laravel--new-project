import Cookies from 'js-cookie';
import { getToken } from '../../utils/getToken';

function getUserInfo() {
    const USER_INFO = Cookies.get('auth');
    if (USER_INFO) {
        return JSON.parse(USER_INFO);
    }
    const USER = {
        employee_number: '',
        id: '',
        proxy_email: '',
        email: '',
        is_new_password: '',
        retirement_date: '',
        role: '',
        temp_password: '',
        first_name: '',
        last_name: '',
    };

    return USER;
}

export default {
    state: {
        auth: getUserInfo(),
        token: getToken(),
    },
    mutations: {
        SET_AUTH(state, auth) {
            state.auth = auth;
        },
        SET_TOKEN(state, token) {
            state.token = token;
        },
    },
    actions: {
        saveLogin({ commit }, auth) {
            commit('SET_AUTH', auth);
            commit('SET_TOKEN', auth.token);
            Cookies.set('auth', auth);
            Cookies.set('token', auth.token);
        },

        logout({ commit }) {
            commit('SET_AUTH', {});
            Cookies.set('auth', {});
            Cookies.set('token', '');
        },
    },
};
