import { mount, shallowMount } from '@vue/test-utils';
import PayslipSalaryDetails from '@/views/Payslip/detail';

// Component Name
const COMPONENT_NAME = 'PAYSLIP SALARY DETAILS';

describe(`TEST COMPONENT ${COMPONENT_NAME}`, () => {
    it('Case 1: Test component render TITLE PAGE', () => {
        const wrapper = shallowMount(PayslipSalaryDetails);

        const TITLE = wrapper.find('.title');
        expect(TITLE.exists()).toBe(true);

        const TITLE_TEXT = TITLE.find('.title-text');
        expect(TITLE_TEXT.exists()).toBe(true);
        expect(TITLE_TEXT.text()).toEqual('routes.salary-details');

        wrapper.destroy();
    });

    it('Case 2: Test component render SALARY DETAILS HEADER - SELECT MONTH YEAR', () => {
        const wrapper = mount(PayslipSalaryDetails, {
            stubs: {
                BTooltip: true,
            },
        });

        const MONTH_YEAR = wrapper.find('#month_year');
        expect(MONTH_YEAR.exists()).toBe(true);

        const CALENDAR = wrapper.vm.calendar;
        expect(MONTH_YEAR.findAll('option').length).toEqual(CALENDAR.length);

        for (let item = 0; item < CALENDAR.length; item++) {
            expect(MONTH_YEAR.findAll('option').at(item).element.value).toEqual(CALENDAR[item].value + '');
            expect(MONTH_YEAR.findAll('option').at(item).text()).toEqual(CALENDAR[item].text);
        }

        wrapper.destroy();
    });

    it('Case 3: Test component render SALARY DETAILS HEADER - BUTTON PRINT PDF', () => {
        const wrapper = mount(PayslipSalaryDetails, {
            stubs: {
                BTooltip: true,
            },
        });

        const BTN_PRINT_PDF = wrapper.find('#btn-print-pdf');
        expect(BTN_PRINT_PDF.exists()).toBe(true);

        const printPDF = jest.spyOn(wrapper.vm, 'printPDF');
        BTN_PRINT_PDF.trigger('click');
        expect(printPDF).toHaveBeenCalled();

        wrapper.destroy();
    });

    it('Case 4: Test component render all TABLE', () => {
        const wrapper = mount(PayslipSalaryDetails, {
            stubs: {
                BTooltip: true,
            },
        });

        const LIST_TABLE = wrapper.findAll('table');

        expect(LIST_TABLE.length).toEqual(6);

        const LIST_TH = [
            [
                'views.salary-details.employee-table.title',
            ],
            [
                'views.salary-details.service-record-table.title',
            ],
            [
                'views.salary-details.payment-table.title',
            ],
            [
                'views.salary-details.deduction-table.title',
            ],
            [
                'views.salary-details.excess-tax-table.title',
            ],
            [
                'views.salary-details.payment-amount-table.title',
            ],
        ];

        const LIST_TD = [
            [
                'views.salary-details.employee-table.department',
                'views.salary-details.employee-table.employee-number',
                'views.salary-details.employee-table.full-name',
            ],
            [
                'views.salary-details.service-record-table.commuting-days',
                'views.salary-details.service-record-table.number-of-days-off',
                'views.salary-details.service-record-table.paid-days',
                'views.salary-details.service-record-table.absence-days',
                'views.salary-details.service-record-table.remaining-holidays',
                'views.salary-details.service-record-table.commuting-days-2',
                'views.salary-details.service-record-table.commuting-time',
                'views.salary-details.service-record-table.late-time',
                'views.salary-details.service-record-table.normal-overtime-hours',
                'views.salary-details.service-record-table.holiday-time',
                'views.salary-details.service-record-table.midnight-allowance-time',
                '',
            ],
            [
                'views.salary-details.payment-table.basic-salary',
                'views.salary-details.payment-table.wages-on-the-job',
                'views.salary-details.payment-table.job-title-allowance',
                'views.salary-details.payment-table.large-allowance',
                'views.salary-details.payment-table.passenger-allowance',
                'views.salary-details.payment-table.other-allowance',
                'views.salary-details.payment-table.overtime-allowance',
                'views.salary-details.payment-table.holiday-work-allowance',
                'views.salary-details.payment-table.midnight-allowance',
                'views.salary-details.payment-table.paid-absence-adjustment',
                'views.salary-details.payment-table.overtime-allowance-adjustment-amount',
                'views.salary-details.payment-table.last-month-adjustment',
                'views.salary-details.payment-table.adjust-salary',
                'views.salary-details.payment-table.bounty',
                'views.salary-details.payment-table.service-record-deduction',
                'views.salary-details.payment-table.other-payment-paid',
                'views.salary-details.payment-table.overtime-adjustment-allowance',
                'views.salary-details.payment-table.reduction',
                'views.salary-details.payment-table.taxable-amount',
                'views.salary-details.payment-table.commuting-allowance',
                'views.salary-details.payment-table.total-amount-paid',
                '',
                '',
                '',
            ],
            [
                'views.salary-details.deduction-table.health-insurance-premium',
                'views.salary-details.deduction-table.long-term-care-insurance-premium',
                'views.salary-details.deduction-table.welfare-pension-insurance',
                'views.salary-details.deduction-table.employment-insurance-premiums',
                'views.salary-details.deduction-table.total-amount-of-company-insurance',
                'views.salary-details.deduction-table.income-tax',
                'views.salary-details.deduction-table.resident-tax',
                'views.salary-details.deduction-table.resident-tax-deduction',
                'views.salary-details.deduction-table.dormitory-fee',
                'views.salary-details.deduction-table.other-1',
                'views.salary-details.deduction-table.other-2',
                'views.salary-details.deduction-table.other-3',
                'views.salary-details.deduction-table.transfer-separately-from-the-previous-month',
                'views.salary-details.deduction-table.advance-payment',
                'views.salary-details.deduction-table.deposit',
                'views.salary-details.deduction-table.adjustment-deduction',
                'views.salary-details.deduction-table.year-end-adjustment',
                'views.salary-details.deduction-table.total-deduction',
            ],
            [
                'views.salary-details.excess-tax-table.excess-and-deficiency-tax-amount',
            ],
            [
                'views.salary-details.payment-amount-table.deduction-payment-amount',
                'views.salary-details.payment-amount-table.cash-payment-amount',
                'views.salary-details.payment-amount-table.bank-1-transfer-amount',
            ],
        ];

        for (let table = 0; table < LIST_TABLE.length; table++) {
            const GET_LIST_HEADER = LIST_TABLE.at(table).findAll('th');
            const GET_LIST_TD = LIST_TABLE.at(table).findAll('td.horizontal-header');

            for (let header = 0; header < GET_LIST_HEADER.length; header++) {
                expect(GET_LIST_HEADER.at(header).text()).toEqual(LIST_TH[table][header]);
            }

            for (let td = 0; td < GET_LIST_TD.length; td++) {
                expect(GET_LIST_TD.at(td).find('span').text()).toEqual(LIST_TD[table][td]);
            }
        }

        wrapper.destroy();
    });
});
