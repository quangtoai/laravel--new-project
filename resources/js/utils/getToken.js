import Cookies from 'js-cookie';

export function getToken() {
    const TOKEN = Cookies.get('token');

    if (TOKEN) {
        return TOKEN;
    }

    return '';
}
