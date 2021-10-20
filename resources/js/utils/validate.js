import { trim } from 'jquery';

export function validEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

export function validPassword(password) {
    const re = /^\S{8,16}$/;
    return re.test(password);
}
export function validEmpcode(code) {
    code = trim(code);
    const re = /^[A-Za-z0-9]{1,6}$/;
    return re.test(code);
}
