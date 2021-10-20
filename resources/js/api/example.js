import request from '../utils/request.js';
import { template } from './templateURL.js';

const urlAPI = {
    // Get
    urlGETUser: template`/demo`,
    // Post
    urlPOSTUser: template`/demo`,
    // Put
    urlPUTUser: template`/demo`,
    // Delete
    urlDELETEUser: template`/demo`,
};

/**
 * Validate a full-lowercase string
 * @param {Object} params
 * @returns {Object}
 */
export function getUser(params) {
    return request.getRequest(urlAPI.urlGETUser(), params);
}

/**
 * Validate a full-lowercase string
 * @param {Object} data
 * @returns {Object}
 */
export function postUser(data) {
    return request.postRequest(urlAPI.urlPOSTUser(), data);
}

/**
 * Validate a full-lowercase string
 * @param {Object} params
 * @param {Object} data
 * @returns
 */
export function putUser(data, params) {
    return request.putRequest(urlAPI.urlPUTUser(params), data);
}

/**
 * Validate a full-lowercase string
 * @param {Object} params
 * @returns {Object}
 */
export function deleteUser(params) {
    return request.deleteRequest(urlAPI.urlDELETEUser(), params);
}
