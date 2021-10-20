import { shallowMount, mount, createLocalVue } from '@vue/test-utils';
import EmployeeUpdate from '@/views/Employee/edit';
import router from '@/router';
import store from '@/store';

// Component Name
const componentName = 'EmpUpdate';

describe(`TEST COMPONENT ${componentName}`, () => {
    const Employee = {
        employee_number: '1',
        first_name: '',
        last_name: '',
        mail_address: null,
        current_password: '',
        new_password: null,
        confirm_new_password: '',
        user_authority: '',
        retirement: '',
        retirementStatus: 'unchecked',
        original_retirement: '',
        isHiddenRetirement: false,
    };
    const USER = {
        employee_number: '1234',
        id: 1,
        role: 'CREW',
    };
    const wrapper = shallowMount(EmployeeUpdate, {
        data: Employee,
    });

    // wrapper.setData({ Employee });
    it('Case 1: Test component render', async() => {
        await store.dispatch('saveLogin', { USER });
        expect(wrapper.html()).toContain('veho_' + componentName.toLowerCase());
    });

    it('Case 2: Test EMPLOYEE object has full properties', () => {
        expect(wrapper.vm.Employee).toEqual(Employee);
        // wrapper.destroy();
    });

    it('Case 3: Test render all input', () => {
        const wrapper = mount(EmployeeUpdate);

        expect(wrapper.find('#fieldset-1').exists()).toBe(true);
        expect(wrapper.find('#fieldset-2').exists()).toBe(true);
        expect(wrapper.find('#fieldset-3').exists()).toBe(true);
        expect(wrapper.find('#fieldset-4').exists()).toBe(true);
        expect(wrapper.find('#fieldset-5').exists()).toBe(true);
        expect(wrapper.find('#fieldset-6').exists()).toBe(true);
        expect(wrapper.find('#fieldset-7').exists()).toBe(true);

        expect(wrapper.find('#fieldset-1').find('legend').exists()).toBe(true);
        expect(wrapper.find('#fieldset-2').find('legend').exists()).toBe(true);
        expect(wrapper.find('#fieldset-3').find('legend').exists()).toBe(true);
        expect(wrapper.find('#fieldset-4').find('legend').exists()).toBe(true);
        expect(wrapper.find('#fieldset-5').find('legend').exists()).toBe(true);
        expect(wrapper.find('#fieldset-6').find('legend').exists()).toBe(true);
        expect(wrapper.find('#fieldset-7').find('legend').exists()).toBe(true);

        expect(wrapper.find('#fieldset-1').find('legend').text()).toEqual('views.employee-data.employee-number');
        expect(wrapper.find('#fieldset-2').find('legend').text()).toEqual('views.employee-data.first-name');
        expect(wrapper.find('#fieldset-3').find('legend').text()).toEqual('views.employee-data.last-name');
        expect(wrapper.find('#fieldset-4').find('legend').text()).toEqual('views.employee-data.mail-address');
        expect(wrapper.find('#fieldset-5').find('legend').text()).toEqual('views.employee-data.current-password');
        expect(wrapper.find('#fieldset-6').find('legend').text()).toEqual('views.employee-data.new-password');
        expect(wrapper.find('#fieldset-7').find('legend').text()).toEqual('views.employee-data.confirm-new-password');

        expect(wrapper.find('#fieldset-1').find('input').exists()).toBe(true);
        expect(wrapper.find('#fieldset-2').find('input').exists()).toBe(true);
        expect(wrapper.find('#fieldset-3').find('input').exists()).toBe(true);
        expect(wrapper.find('#fieldset-4').find('input').exists()).toBe(true);
        expect(wrapper.find('#fieldset-5').find('input').exists()).toBe(true);
        expect(wrapper.find('#fieldset-6').find('input').exists()).toBe(true);
        expect(wrapper.find('#fieldset-7').find('input').exists()).toBe(true);

        expect(wrapper.find('#fieldset-1').find('input').props('type')).toBe('number');
        expect(wrapper.find('#fieldset-2').find('input').props('type')).toBe('text');
        expect(wrapper.find('#fieldset-3').find('input').props('type')).toBe('text');
        expect(wrapper.find('#fieldset-4').find('input').props('type')).toBe('email');
        expect(wrapper.find('#fieldset-5').find('input').props('type')).toBe('password');
        expect(wrapper.find('#fieldset-6').find('input').props('type')).toBe('password');
        expect(wrapper.find('#fieldset-7').find('input').props('type')).toBe('password');

        expect(wrapper.find('#fieldset-1').find('input').props('placeholder')).toBe('views.employee-data.employee-number');
        expect(wrapper.find('#fieldset-2').find('input').props('placeholder')).toBe('views.employee-data.first-name');
        expect(wrapper.find('#fieldset-3').find('input').props('placeholder')).toBe('views.employee-data.last-name');
        expect(wrapper.find('#fieldset-4').find('input').props('placeholder')).toBe('views.employee-data.mail-address');
        expect(wrapper.find('#fieldset-5').find('input').props('placeholder')).toBe('views.employee-data.current-password');
        expect(wrapper.find('#fieldset-6').find('input').props('placeholder')).toBe('views.employee-data.new-password');
        expect(wrapper.find('#fieldset-7').find('input').props('placeholder')).toBe('views.employee-data.confirm-new-password');

        wrapper.destroy();
    });

    it('Case 4: Test v-model all input', async() => {
        const Employee = {
            employee_number: 1310,
            origin_employee_number: 1310,
            first_name: 'Chester',
            last_name: 'Klein',
            mail_address: 'ck@gmail.com',
            current_password: '594-292-6689',
            new_password: '583-426-2923',
            confirm_new_password: '583-426-2923',
        };

        const wrapper = mount(EmployeeUpdate, {
            data() {
                return {
                    Employee,
                };
            },
        });

        expect(wrapper.find('#fieldset-1').find('input').element.value).toBe(Employee.employee_number + '');
        expect(wrapper.find('#fieldset-2').find('input').element.value).toBe(Employee.first_name);
        expect(wrapper.find('#fieldset-3').find('input').element.value).toBe(Employee.last_name);
        expect(wrapper.find('#fieldset-4').find('input').element.value).toBe(Employee.mail_address);
        expect(wrapper.find('#fieldset-5').find('input').element.value).toBe(Employee.current_password);
        expect(wrapper.find('#fieldset-6').find('input').element.value).toBe(Employee.new_password);
        expect(wrapper.find('#fieldset-7').find('input').element.value).toBe(Employee.confirm_new_password);

        wrapper.destroy();
    });

    it('Case 5: Test render button BACK and SUBMIT', () => {
        const wrapper = shallowMount(EmployeeUpdate);

        const BUTTON_BACK = wrapper.find('button.btn-footer');
        const BUTTON_SUBMIT = wrapper.find('button.btn-footer.btn_submit');

        expect(BUTTON_BACK.exists()).toBe(true);
        expect(BUTTON_SUBMIT.exists()).toBe(true);

        expect(BUTTON_BACK.text()).toEqual('views.employee-data.back');
        expect(BUTTON_SUBMIT.text()).toEqual('views.employee-data.save');

        wrapper.destroy();
    });

    it('Case 6: Test click button BACK and SUBMIT', async() => {
        const localVue = createLocalVue();
        const wrapper = shallowMount(EmployeeUpdate, { localVue, router });

        const returnToSalaryDetail = jest.spyOn(wrapper.vm, 'returnToSalaryDetail');
        const saveEmployeeInfo = jest.spyOn(wrapper.vm, 'saveEmployeeInfo');

        const BUTTON_BACK = wrapper.find('button.btn-footer');
        await BUTTON_BACK.trigger('click');

        expect(returnToSalaryDetail).toHaveBeenCalled();

        const BUTTON_SUBMIT = wrapper.find('button.btn-footer.btn_submit');
        await BUTTON_SUBMIT.trigger('click');

        expect(saveEmployeeInfo).toHaveBeenCalled();

        jest.restoreAllMocks();

        wrapper.destroy();
    });

    it('Case 7: Test function returnToSalaryDetail', async() => {
        const localVue = createLocalVue();
        const wrapper = shallowMount(EmployeeUpdate, { localVue, router });

        await wrapper.vm.returnToSalaryDetail();

        expect(window.location.pathname).toEqual('/employee-data/index');

        wrapper.destroy();
    });

    it('Case 8: Test function getUserInfo to call when MOUNTED', () => {
        const getUserInfoMock = jest.fn();

        mount(EmployeeUpdate, {
            methods: {
                getUserInfo: getUserInfoMock,
            },
        });

        expect(getUserInfoMock).toHaveBeenCalled();
    });

    it('Case 9: Test click button SUBMIT with DATA WRONG', () => {
        const wrapper = shallowMount(EmployeeUpdate);

        const BUTTON_SUBMIT = wrapper.find('button.btn-footer.btn_submit');
        BUTTON_SUBMIT.trigger('click');

        expect(wrapper.vm.show).toBe(false);

        wrapper.destroy();
    });

    it('Case 10: Test click button SUBMIT with DATA CORRECT', () => {
        const Employee = {
            employee_number: 1310,
            origin_employee_number: 1310,
            first_name: 'Chester',
            last_name: 'Klein',
            mail_address: 'ck@gmail.com',
            current_password: '594-292-6689',
            new_password: '583-426-2923',
            confirm_new_password: '583-426-2923',
        };

        const wrapper = mount(EmployeeUpdate, {
            data() {
                return {
                    Employee,
                };
            },
        });

        const BUTTON_SUBMIT = wrapper.find('button.btn-footer.btn_submit');
        BUTTON_SUBMIT.trigger('click');

        expect(wrapper.vm.show).toBe(true);

        wrapper.destroy();
    });
});
