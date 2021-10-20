// import * as RequestApi from './request';
import request from '../utils/request.js';
import { template } from './template.js';
const module = 'payslip';
const urlAPI = {
    getAll: `/` + module,
    getDetail: `/` + module + '/detail',
    urlGETSingleUserPayslip: template`/payslip/${'id'}`,
    urlGETListMonthPayslip: template`/payslip/month`,
    urlPOSTPayslipCSV: template`/payslip`,
    urlGETCrewPayslip: template`/payslip/me`,
};
export function getAll(data) {
    return request.getRequest(urlAPI.getAll, data);
}
export function getOne(data) {
    return request.getRequest(urlAPI.getDetail, data);
}
export function getSpecifyUserPayslip(id) {
    return request.getRequest(urlAPI.urlGETSingleUserPayslip({ id: id }));
}

export function getListMonthPayslip(param) {
    return request.getRequest(urlAPI.urlGETListMonthPayslip(), param);
}

export function postPayslipCSV(data) {
    return request.postRequest(urlAPI.urlPOSTPayslipCSV(), data);
}

