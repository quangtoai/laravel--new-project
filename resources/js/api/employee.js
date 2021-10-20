// import * as RequestApi from './request';
import request from '../utils/request.js';
import { template } from './template.js';

const urlAPI = {
    urlGETUser: template`/user`,
    urlGETSingleUser: template`/user/${'emp_code'}`,
    urlPUTSingleUser: template`/user/${'emp_code'}`,
    urlGETFilterEmp: template`/user/`,
};

export function getUser(params) {
    return request.getRequest(urlAPI.urlGETUser(), params);
}

export function getSpecifyUserInfo(emp_code) {
    return request.getRequest(urlAPI.urlGETSingleUser({ emp_code: emp_code }));
}

export function changeSpecifyUserInfo(emp_code, data) {
    return request.putRequest(urlAPI.urlPUTSingleUser({ emp_code: emp_code }), data);
}

export function filterEmp(data) {
    return request.getRequest(urlAPI.urlGETFilterEmp(), data);
}

