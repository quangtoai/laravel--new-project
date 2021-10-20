import request from '../utils/request.js';

export function getAll(data) {
    return request.getRequest(data.url, data);
}

export function postOne(data) {
    return request.postRequest(data.url, data);
}

export function getOne(data) {
    return request.getRequest(data.url);
}

export function putOne(data) {
    return request.putRequest(data.url, data);
}

export function deleteOne(data) {
    return request.deleteRequest(data.url);
}
