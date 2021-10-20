import { shallowMount, createLocalVue } from '@vue/test-utils';
import store from '@/store';
import Login from '@/views/Auth/login.vue';
import { authenticateLogin } from '@/api/login.js';

const componentName = 'Login';

describe('Test Component ' + componentName, () => {
    const localVue = createLocalVue();
    const wrapper = shallowMount(Login, { localVue, store });

    const Account = {
        url: '/auth/login',
        emp_code: '123456',
        password: '123456789',
    };
    wrapper.setData({ Account });
    const handleLogin = jest.fn();
    wrapper.setMethods({ handleLogin });
    let TOKEN = null, USER;

    test('Case 1: Check is rendered', () => {
        expect(wrapper.html()).toContain('veho_' + componentName.toLowerCase());
    });

    test('Case 2: Input (username, password)', async() => {
        expect(wrapper.vm.Account.username).toBe(Account.username);
        expect(wrapper.vm.Account.password).toBe(Account.password);
    });

    test('Case 3: Check call function handleLogin', async() => {
        wrapper.find('.btn_submit').trigger('click');
        expect(handleLogin).toHaveBeenCalled();
    });
    test('Case 4: Check function call api and save token', async() => {
        const accountData = {
            emp_code: '123456',
            password: '123456789',
        };
        await authenticateLogin(accountData)
            .then((res) => {
                TOKEN = res.data.access_token;
                USER = res.data.profile;
            })
            .catch((err) => {
                console.log(err);
            });

        expect(TOKEN).not.toBeNull();
        await store.dispatch('saveLogin', { USER, token: TOKEN });
        expect(store.getters.token).toBe(TOKEN);
        expect(store.getters.auth.USER.email).toStrictEqual(USER.email);
    });

    test('Case 5: Redirect to change password page', async() => {
        await authenticateLogin(Account)
            .then((res) => {
                TOKEN = res.data.access_token;
                USER = res.data.profile;
            })
            .catch((err) => {
                console.log(err);
            });

        expect(USER.is_new_pw).toBe(0);
    });

    test('Case 6: Redirect to my salary page', async() => {
        // const wrapper = shallowMount(Login, { localVue, store });
        const Account2 = {
            url: '/auth/login',
            emp_code: '555555',
            password: '123456789',
        };
        await authenticateLogin(Account2)
            .then((res) => {
                TOKEN = res.data.access_token;
                USER = res.data.profile;
            })
            .catch((err) => {
                console.log(err);
            });

        expect(USER.is_new_pw).toBe(0);
    });
});
