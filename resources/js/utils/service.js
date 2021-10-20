import axios from 'axios';
import { MakeToast } from './toast_message';
import i18n from '../lang/index';
import router from '../router';
import { getToken } from './getToken';

const baseURL = process.env.MIX_BASE_API;

const service = axios.create({
    baseURL: baseURL,
    timeout: 10000,
});

const whiteList = ['/recovery', '/notification'];

service.interceptors.request.use(
    config => {
        const token = getToken();

        if (token || whiteList) {
            config.headers['Authorization'] = token;
        } else {
            if (router.currentRoute.path !== '/login') {
                router.push({ path: '/login' });
            }
            // console.log(router.currentRoute.path !== '/login')
            // router.push({ path: '/login' });
        }

        return config;
    },
    error => {
        Promise.reject(error);
    }
);

service.interceptors.response.use(
    response => {
        return response.data;
    },
    error => {
        var isCheckTitle = i18n.te(error.response.data.title);
        var isCheckContent = i18n.te(error.response.data.message);

        var title;
        var content;

        const STATUS_DEBUG = true;

        if (isCheckTitle && isCheckContent) {
            title = i18n.t(error.response.data.title);
            content = i18n.t(error.response.data.message);

            MakeToast({
                variant: 'warning',
                title: title,
                content: content,
                toaster: 'b-toaster-top-right',

            });
        } else {
            if (STATUS_DEBUG === true) {
                title = 'You have error';
                content = 'Unknown error. Please check Network';

                console.log('【❌ - ERROR - ❌】');
                console.log(title);
                console.log(content);
                console.log('【❌ - -END- - ❌】');
            }
        }

        return Promise.reject(error);
    }
);

export { service };
