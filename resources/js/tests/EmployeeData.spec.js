import { shallowMount, mount, createLocalVue } from '@vue/test-utils';
import EmployeeData from '@/views/Employee/index';
import router from '@/router';

// Component Name
const COMPONENT_NAME = 'EMPLOYEE DATA';

describe(`TEST COMPONENT ${COMPONENT_NAME}`, () => {
    it('CASE 1: Test component render TITLE PAGE', () => {
        const wrapper = shallowMount(EmployeeData);

        const TITLE = wrapper.find('.title');
        const TITLE_TEXT = wrapper.find('.title-text');

        const TITLE_PAGE = 'routes.employee-data';

        expect(TITLE.exists()).toBe(true);
        expect(TITLE.exists()).toBe(true);
        expect(TITLE_TEXT.text()).toEqual(TITLE_PAGE);

        wrapper.destroy();
    });

    it('Case 2: Test function getUserInfo to call when MOUNTED', () => {
        const getUserInfoMock = jest.fn();

        mount(EmployeeData, {
            methods: {
                getUserInfo: getUserInfoMock,
            },
        });

        expect(getUserInfoMock).toHaveBeenCalled();
    });

    it('CASE 3: Test component render Table EMPLOYEE DATA', () => {
        const wrapper = shallowMount(EmployeeData);

        const TABLE_EMPLOYEE_DATA = wrapper.find('.employee-data-table');
        expect(TABLE_EMPLOYEE_DATA.exists()).toBe(true);

        expect(TABLE_EMPLOYEE_DATA.props('bordered')).toBe(true);
        expect(TABLE_EMPLOYEE_DATA.props('outlined')).toBe(false);
        expect(TABLE_EMPLOYEE_DATA.props('fixed')).toBe(false);

        const HEADER_TABLE = TABLE_EMPLOYEE_DATA.find('thead');
        expect(HEADER_TABLE.exists()).toBe(true);

        const LIST_TH = HEADER_TABLE.findAll('th');
        expect(LIST_TH.length).toBe(4);

        const LIST_TEXT_TH = [
            'views.employee-data.employee-number',
            'views.employee-data.employee-name',
            'views.employee-data.mail-address',
            '-',
        ];

        for (let indexTH = 0; indexTH < LIST_TH.length; indexTH++) {
            expect(LIST_TH.at(indexTH).text()).toEqual(LIST_TEXT_TH[indexTH]);
        }

        const BODY_TABLE = TABLE_EMPLOYEE_DATA.find('tbody');
        expect(BODY_TABLE.exists()).toBe(true);
        expect(BODY_TABLE.find('.functional-buttons').exists()).toBe(true);

        wrapper.destroy();
    });

    it('Case 4: Test click text CHANGE in table', async() => {
        const localVue = createLocalVue();
        const wrapper = shallowMount(EmployeeData, { localVue, router });

        const goToChangeScreen = jest.spyOn(wrapper.vm, 'goToChangeScreen');

        const TEXT_CHANGE = wrapper.find('.functional-buttons');

        await TEXT_CHANGE.trigger('click');

        expect(goToChangeScreen).toHaveBeenCalled();

        wrapper.destroy();
    });
});
