import { mount, shallowMount } from '@vue/test-utils';
import PayslipImport from '@/views/Payslip/import';

// Component Name
const componentName = 'PayslipImport';

describe(`Test Component ${componentName}`, () => {
    const wrapper = shallowMount(PayslipImport);
    it('Case 1: Test component render', () => {
        expect(wrapper.html()).toContain('veho_' + componentName.toLowerCase());
    });

    it('Case 2: Test component render INPUT FILE', () => {
        expect(wrapper.html()).toContain('select_month');
        expect(wrapper.html()).toContain('my_file');
        expect(wrapper.html()).toContain('import_csv');
    });

    it('Case 3: Test component when click input SELECT', async() => {
        // const wrapper = shallowMount(PayslipImport);

        const SELECT_FILE = wrapper.find('input#get_file');
        expect(SELECT_FILE.exists()).toBe(true);

        const openFileInput = jest.spyOn(wrapper.vm, 'openFileInput');

        await SELECT_FILE.trigger('click');
        expect(openFileInput).toHaveBeenCalled();

        wrapper.destroy();
    });

    it('Case 4: Test component validate file csv', () => {
        const wrapper = mount(PayslipImport);

        let FILE = {
            name: 'Fake.xlsx',
            size: 10393,
            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        };

        expect(wrapper.vm.isValidateTypeFile(FILE)).toBe(true);
        expect(wrapper.vm.isValidateSizeFile(FILE)).toBe(true);

        FILE = {
            name: 'Fake.word',
            size: 100000000,
            type: 'word',
        };

        expect(wrapper.vm.isValidateTypeFile(FILE)).toBe(false);
        expect(wrapper.vm.isValidateSizeFile(FILE)).toBe(false);

        wrapper.destroy();
    });
});
