import router from './router';
import { getToken } from './utils/getToken';
// import getPageTitle from './utils/getPageTitle';
// import store from './store';

const whiteList = ['/login', '/admin', '/recovery', '/notification', '/change-password'];
// const ROLE = store.getters.role;
// const IS_NEW = store.getters.is_new_password;

router.beforeEach(async(to, from, next) => {
    // document.title = getPageTitle(to.meta.title);

    const TOKEN = getToken();

    if (TOKEN) {
        const arr = ['/change-password', '/login', '/admin'];
        if (TOKEN === 'temporary_password' && !arr.includes(to.path)){
            next(`/change-password`);
        } else {
            next();
        }
    } else {
        if (whiteList.indexOf(to.matched[0] ? to.matched[0].path : '') !== -1) {
            next();
        } else {
            next(`/login?redirect=${to.path}`);
        }
    }
});
