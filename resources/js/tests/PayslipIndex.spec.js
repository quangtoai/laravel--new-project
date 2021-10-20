import { shallowMount, mount, createLocalVue } from '@vue/test-utils';
import PayslipIndex from '@/views/Payslip/index';
import router from '@/router';
import { expect, it, jest } from '@jest/globals';

// Component Name
const COMPONENT_NAME = 'PAYSLIP INDEX';

describe(`TEST COMPONENT ${COMPONENT_NAME}`, () => {
    it('Case 1: Test component render NOTIFICATION', () => {
        const wrapper = shallowMount(PayslipIndex);

        const NOTIFICATION = wrapper.find('.notification');

        expect(NOTIFICATION.exists()).toBe(true);
        expect(NOTIFICATION.text()).toEqual('views.payslip.notification');

        wrapper.destroy();
    });

    it('Case 2: Test component render all INPUT', () => {
        const wrapper = mount(PayslipIndex);

        expect(wrapper.find('#fieldset-1').exists()).toBe(true);
        expect(wrapper.find('#fieldset-2').exists()).toBe(true);

        expect(wrapper.find('#fieldset-1').find('legend').exists()).toBe(true);
        expect(wrapper.find('#fieldset-2').find('legend').exists()).toBe(true);

        expect(wrapper.find('#fieldset-1').find('legend').text()).toEqual('views.payslip.email');
        expect(wrapper.find('#fieldset-2').find('legend').text()).toEqual('views.payslip.password');

        expect(wrapper.find('#fieldset-1').find('input').exists()).toBe(true);
        expect(wrapper.find('#fieldset-2').find('input').exists()).toBe(true);

        expect(wrapper.find('#fieldset-1').find('input').props('type')).toBe('email');
        expect(wrapper.find('#fieldset-2').find('input').props('type')).toBe('password');

        expect(wrapper.find('#fieldset-1').find('input').props('placeholder')).toBe('例) 〇〇〇〇@〇〇〇〇');
        expect(wrapper.find('#fieldset-2').find('input').props('placeholder')).toBe('パスワード');

        wrapper.destroy();
    });

    it('Case 3: Test ENTER when input EMAIL or PASSWORD', () => {
        const localVue = createLocalVue();
        const wrapper = mount(PayslipIndex, { localVue, router });

        const INPUT_EMAIL = wrapper.find('#fieldset-1').find('input');
        const INPUT_PASSWORD = wrapper.find('#fieldset-2').find('input');

        expect(INPUT_EMAIL.exists()).toBe(true);
        expect(INPUT_PASSWORD.exists()).toBe(true);

        const validateFormData = jest.spyOn(wrapper.vm, 'validateFormData');

        INPUT_EMAIL.trigger('keyup.enter');

        expect(validateFormData).toHaveBeenCalled();

        INPUT_PASSWORD.trigger('keyup.enter');

        expect(validateFormData).toHaveBeenCalled();

        jest.restoreAllMocks();

        wrapper.destroy();
    });

    it('Case 4: Test render button REGISTRATION', () => {
        const wrapper = shallowMount(PayslipIndex);

        const BTN_REGISTRATION = wrapper.find('button#btn-registration');

        expect(BTN_REGISTRATION.exists()).toBe(true);
        expect(BTN_REGISTRATION.text()).toEqual('views.payslip.btn-registration');

        wrapper.destroy();
    });

    it('Case 5: Test click button REGISTRATION', () => {
        const localVue = createLocalVue();
        const wrapper = shallowMount(PayslipIndex, { localVue, router });

        const BTN_REGISTRATION = wrapper.find('button#btn-registration');

        const validateFormData = jest.spyOn(wrapper.vm, 'validateFormData');

        BTN_REGISTRATION.trigger('click');

        expect(validateFormData).toHaveBeenCalled();

        wrapper.destroy();
    });

    it('Case 6: Test function validateFormData (Data Correct)', () => {
        const localVue = createLocalVue();
        const wrapper = shallowMount(PayslipIndex, { localVue, router });

        const handleRegister = jest.spyOn(wrapper.vm, 'handleRegister');
        const BTN_REGISTRATION = wrapper.find('button#btn-registration');

        // Start Step 1: Account correct
        let Employee = {
            email: 'izumidxteam@admin',
            password: 'a7bg111s',
        };

        wrapper.vm.Employee = Employee;

        BTN_REGISTRATION.trigger('click');
        expect(handleRegister).toBeCalled();
        // End Step 1: Account correct

        // Start Step 2: Account empty
        handleRegister.mockClear();

        Employee = {
            email: '',
            password: '',
        };

        wrapper.vm.Employee = Employee;
        BTN_REGISTRATION.trigger('click');
        expect(handleRegister).not.toBeCalled();
        // End Step 2: Account empty

        // Start Step 3: Account: Email correct - Password: empty
        handleRegister.mockClear();

        Employee = {
            email: 'test@gmail.com',
            password: '',
        };

        wrapper.vm.Employee = Employee;
        BTN_REGISTRATION.trigger('click');
        expect(handleRegister).not.toBeCalled();
        // End Step 3: Account: Email correct - Password: empty

        // Start Step 4: Account: Email empty - Password: correct
        handleRegister.mockClear();

        Employee = {
            email: '',
            password: '123123123',
        };

        wrapper.vm.Employee = Employee;
        BTN_REGISTRATION.trigger('click');
        expect(handleRegister).not.toBeCalled();
        // End Step 4: Account: Email empty - Password: correct

        // Start Step 5: Account: Email space - Password: space
        handleRegister.mockClear();

        Employee = {
            email: '         ',
            password: '              ',
        };

        wrapper.vm.Employee = Employee;
        BTN_REGISTRATION.trigger('click');
        expect(handleRegister).not.toBeCalled();
        // End Step 5: Account: Email space - Password: space

        // Start Step 6: Account: Email space (include @) - Password: space
        handleRegister.mockClear();

        Employee = {
            email: '    @     ',
            password: '              ',
        };

        wrapper.vm.Employee = Employee;
        BTN_REGISTRATION.trigger('click');
        expect(handleRegister).not.toBeCalled();
        // End Step 6: Account: Email space (include @) - Password: space

        // Start Step 7: Account: Email incorrect - Password: correct
        handleRegister.mockClear();

        Employee = {
            email: '@admin',
            password: 'a7bg111s',
        };

        wrapper.vm.Employee = Employee;
        BTN_REGISTRATION.trigger('click');
        expect(handleRegister).not.toBeCalled();
        // End Step 7: Account: Email incorrect - Password: correct

        jest.restoreAllMocks();

        wrapper.destroy();
    });
});
