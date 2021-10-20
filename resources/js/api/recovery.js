// import * as RequestApi from './request';
import request from '../utils/request.js';
import { template } from './template.js';

const urlAPI = {
    urlPOSTResetPassword: template`/remind-passwords`,
};

export function recoveryPassword(data) {
    return request.postRequest(urlAPI.urlPOSTResetPassword(), data);
}
