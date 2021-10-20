// import * as RequestApi from './request';
import request from '../utils/request.js';
import { template } from './template.js';

const urlAPI = {
    urlPOSTAuthLogin: template`/auth/login`,
    urlGETUserProxyContacts: template`/userproxy`,
    urlPUTRegistration: template`/change_pass/${'emp_code'}`,
};

export function authenticateLogin(data) {
    return request.postRequest(urlAPI.urlPOSTAuthLogin(), data);
}

export function getUserProxyContacts(params) {
    return request.getRequest(urlAPI.urlGETUserProxyContacts(), params);
}

export function registrationUser(emp_code, data) {
    return request.putRequest(urlAPI.urlPUTRegistration({ emp_code }), data);
}
