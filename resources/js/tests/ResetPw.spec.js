import { shallowMount, createLocalVue } from '@vue/test-utils';
import store from '@/store';
import UserCreate from '@/views/Auth/recovery.vue';
import { validEmpcode } from '@/utils/validate';

const componentName = 'Recovery';

describe('Test Component ' + componentName, () => {
    const localVue = createLocalVue();
    const wrapper = shallowMount(UserCreate, { localVue, store });

    const Employee = {
        mail_address: 'david@gmail.com',
        current_password: '123456',
    };

    wrapper.setData({ Employee });

    test('Case 1: Check is rendered', () => {
        expect(wrapper.html()).toContain('veho_' + componentName.toLowerCase());
    });

    test('Case 2: Input form', async() => {
        expect(wrapper.vm.Employee.mail_address).toBe(Employee.mail_address);
    });

    it('Case 3: Check valid employee code', () => {
        expect(validEmpcode('')).toBe(false);
        expect(validEmpcode('   ')).toBe(false);
        expect(validEmpcode('.test')).toBe(false);
        expect(validEmpcode('123456789')).toBe(false);
        expect(validEmpcode('123456')).toBe(true);
    });

    test('Case 4: Check call function handleRecovery', async() => {
        const wrapper = shallowMount(UserCreate, { localVue, store });
        const handleRecovery = jest.spyOn(wrapper.vm, 'handleRecovery');

        await wrapper.find('#btn-recovery').trigger('click');

        expect(handleRecovery).toHaveBeenCalled();
    });
});
