import { shallowMount, createLocalVue } from '@vue/test-utils';
import store from '@/store';
import EmployeeUpdate from '@/views/Employee/edit.vue';
import { validEmail } from '@/utils/validate';
import router from '@/router';
import { expect, jest } from '@jest/globals';
const componentName = 'EmpUpdate';
describe('Test Component ' + componentName, () => {
    const localVue = createLocalVue();
    const wrapper = shallowMount(EmployeeUpdate, { localVue, store, router });

    const Employee = {
        mail_address: 'thangle2407@gmail.com',
        current_password: '123456',
    };

    wrapper.setData({ mail_address: 'thangle2407@gmail.com' });

    test('Case 1: Check is rendered', () => {
        expect(wrapper.html()).toContain('veho_' + componentName.toLowerCase());
    });

    test('Case 2: Input form', async() => {
        console.log(wrapper.vm.mail_address);
        expect(wrapper.vm.mail_address).toBe(Employee.mail_address);
    });

    test('Case 3: Validate email empty', async() => {
        wrapper.vm.mail_address = '';
        wrapper.find('.btn_submit').trigger('click');
        console.log(wrapper.vm.err);
        expect(wrapper.vm.err).toBe('notify.email_required');
    });

    it('Case 4: Check VALIDATE EMAIL', () => {
        expect(validEmail('')).toBe(false);
        expect(validEmail('   ')).toBe(false);
        expect(validEmail('test')).toBe(false);
        expect(validEmail('123456789')).toBe(false);
        expect(validEmail('test@')).toBe(false);
        expect(validEmail('test@gmail')).toBe(false);
        expect(validEmail('test@gamil.')).toBe(false);
        expect(validEmail('test@gmail.123')).toBe(false);
        expect(validEmail('test@123.123')).toBe(false);
        expect(validEmail('test#gamil.com')).toBe(false);

        expect(validEmail('test@gmail.com')).toBe(true);
        expect(validEmail('test@outlook.com')).toBe(true);
        expect(validEmail('test@apple.com')).toBe(true);
        expect(validEmail('test@gmail.uk')).toBe(true);
        expect(validEmail('test@veho.edu.vn')).toBe(true);
    });

    test('Case 5: Test render button BACK and SUBMIT', async() => {
        const btnSubmit = wrapper.find('.btn_submit');
        const btnBack = wrapper.find('.btn-footer');

        expect(btnSubmit.exists()).toBe(true);
        expect(btnBack.exists()).toBe(true);

        expect(btnSubmit.text()).toEqual('views.employee.save');
    });

    test('Case 6: Test click button BACK and SUBMIT', async() => {
        const returnToSalaryDetail = jest.spyOn(wrapper.vm, 'returnToSalaryDetail');
        const saveEmployeeInfo = jest.spyOn(wrapper.vm, 'submit');

        const btnSubmit = wrapper.find('.btn_submit');
        await btnSubmit.trigger('click');

        expect(saveEmployeeInfo).toHaveBeenCalled();

        const btnBack = wrapper.find('.btn-footer');
        await btnBack.trigger('click');

        expect(returnToSalaryDetail).toHaveBeenCalled();

        jest.restoreAllMocks();

        wrapper.destroy();
    });

    test('Case 7: test function returnToSalaryDetail', async() => {
        await wrapper.vm.returnToSalaryDetail();

        expect(window.location.pathname).toEqual('/employee/index');

        wrapper.destroy();
    });

    // test('Case 8: Test functtion getUserInfor', () => {
    //     const getUser = jest.fn();

    //     mount(EmployeeUpdate, {
    //         methods: {
    //             getUserInfo: getUser,
    //         }
    //     })
    //     expect(getUser).toHaveBeenCalled();
    // });
});
