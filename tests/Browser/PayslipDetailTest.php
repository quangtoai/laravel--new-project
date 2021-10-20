<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PayslipDetailTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testGeneral()
    {
        $this->browse(function ($browser) {
            $this->accessByManager($browser);
            $this->accessByCrew($browser);
            $this->accessByCrewChangeMonth($browser);
            $this->crewAccessShowHelper($browser);
            $this->crewAccessToOtherPeoplePayslip($browser);
        });
    }

    function accessByManager($browser)
    {
        $this->login($browser,'MANAGER');
        $browser->visit('/payslip/detail/888888/2021-08-01?dtext=Access payslip detail by Manager&dstatus=1');
        $this->assertField($browser);
    }

    function accessByCrew($browser)
    {
        $this->login($browser, 'CREW','Access payslip detail by Crew &dstatus=1');
        // $browser->visit('/payslip/detail?dtext=Access payslip detail by Crew &dstatus=1');
        $this->assertField($browser);
    }

    function accessByCrewChangeMonth($browser)
    {
        // $this->login($browser, 'CREW','CREW change month in payslip &dstatus=1');
        // $browser->visit('/payslip/detail?dtext=Access payslip detail Crew  by Change Month &dstatus=1')
        $browser->waitForText('pigion nakamoto')->select('.select_month', '2021-07-01');
        $this->assertChangeMonth($browser);
    }

    function crewAccessToOtherPeoplePayslip($browser)
    {
        // $this->login($browser, 'CREW');

        //crew trying to access payroll account 1234
        $browser->visit('/payslip/detail/1234/2021-08-01?dtext=CREW access to 1234 payslip')
            ->waitUntilMissing('.loading')->assertDontSee('David crew')

            //crew trying to access payroll account 55555
            ->visit('/payslip/detail/555555/2021-08-01?dtext=CREW access to 555555 payslip')
            ->waitUntilMissing('.loading')->assertDontSee('satoshi nakamoto')

            //crew trying to access payroll account 123456
            ->visit('/payslip/detail/123456/2021-08-01?dtext=CREW access to 123456 payslip')
            ->waitUntilMissing('.loading')->assertDontSee('Admin')

            //crew trying to access payroll account 666888
            ->visit('/payslip/detail/666888/2021-08-01?dtext=CREW access to 666888 payslip')
            ->waitUntilMissing('.loading')->assertDontSee('Shin');
    }

    function crewAccessShowHelper($browser)
    {
            //staff press help guide key
            $browser->scrollIntoView('#app')
            ->click('#helper')->waitFor('.helper_master')->assertSee('各項目の解説が表示されます。')
            // ->scrollIntoView('#helper')
            //Show Helper Number of working days in a month
            ->mouseover('.btn_helper')->pause('100')->assertSee('対象月の出勤日数（法定休日出勤日数を除く)')
            //Show Helper Legal holiday work days
            ->mouseover('#working-out-of-days')->pause('100')->assertSee('法定休日出勤日数')
            //Show Helper special leave days
            ->mouseover('#special-leave-days')->pause('100')->assertSee('特別休暇日数')
            //Show Helper paid off days
            ->mouseover('#paid-off-days')->pause('100')->assertSee('有給休暇使用日数')
            //Show Helper off-days
            ->mouseover('#off-days')->pause('500')->assertSee('欠勤日数（所定労働日数内で休日）')
            //Show Helper remaining paid off days
            ->mouseover('#remaining-paid-off-days')->pause('100')->assertSee('有給休暇の残日数')
            //Show Helper basic salary
            ->mouseover('#basic-salary')->pause('100')->assertSee('基本給')
            //Show HelperAbsence days
            ->mouseover('#basic-salary')->pause('100')->assertSee('欠勤日数')
            //Show Helper other payment paid off
            ->scrollIntoView('#basic-salary')
            ->mouseover('#other-payment-paid-off')->pause('100')
            ->assertSee('対象月の所定労働時間に満たない時間で減額される金額')
            //Show Helper Eligible amount of paid leave
            ->mouseover('#ot-adjustment-cp')->pause('1000')->assertSee('有給休暇取得による対象金額');
    }

    function assertField($browser) //2021年08月 888888
    {
        $browser->waitUntilMissing('.loading')
            ->waitForText('pigion nakamoto')->pause(999)
            ->assertSeeIn('.select_month', '2021年08月')
            ->assertSee('pigion nakamoto')//assert fullname
            ->scrollIntoView('.emp_info')
            ->assertSee('22.5') // working_days
            ->assertSee('2.5') // working_out_of_days
            ->assertSee('2') //special_leave_days
            ->assertSee('1')// paid_off_days
            ->assertSee('2')// off_days
            ->assertSee('18.5')// remaining_paid_off_days
            ->assertSee('00:00:18')// working_time
            ->assertSee('00:00:01')// late_early
            ->assertSee('00:00:00')// common_ot
            ->assertSee('00:00:05')// hard_work_time_2
            ->assertSee('150:00:00')// midnight_cp_time
            ->assertSee('3000000')// basic_salary
            ->assertSee('2000000')// salary_for_performance
            ->assertSee('1')// position_cp
            ->assertSee('2')// heavy_truck_cp
            ->assertSee('0')// bd_cp
            ->assertSee('0')// other_cp
            ->assertSee('0')// ot_salary_cp
            ->assertSee('0')// hard_work_2_cp
            ->assertSee('150:00:00')// midnight_cp
            ->assertSee('1000000')// paid_off_adjustment
            ->assertSee('0')// ot_cp_adjustment
            ->assertSee('200')// last_month_adjustment
            ->assertSee('1000000')// adjusted_salary
            ->assertSee('500')// bounty
            ->assertSee('0')// attendance_deduction
            ->assertSee('0')// other_payment_paid_off
            ->assertSee('0')// ot_adjustment_cp
            ->assertSee('0')// reduced_amount
            ->assertSee('10')// taxable_amount
            ->assertSee('500')// transportation_cp
            ->assertSee('2000000')// total_amount_of_payment
            ->assertSee('300')// health_insurance
            ->assertSee('200')// nursing_care_insurance
            ->assertSee('500')// welfare_pension_insurance
            ->assertSee('1000000')// unemployment_insurance
            ->assertSee('2500000')// total_insurance_amount
            ->assertSee('0')// inhabitant_tax
            ->assertSee('0')// inhabitant_tax_deduction
            ->assertSee('0')// apartment_fee
            ->assertSee('0')// other_1
            ->assertSee('0')// other_2
            ->assertSee('0')// other_3
            ->assertSee('0')// incurred_previous_month
            ->assertSee('0')// advance_paid
            ->assertSee('0')// withholding
            ->assertSee('0')// adjustment_deduction
            ->assertSee('0')// year_end_adjustment
            ->assertSee('1500000')// total_dedution_amount
            ->assertSee('600000')// payable_overpaid_tax
            ->assertSee('0')// net_payment
            ->assertSee('3000000')// cash_salary
            ->assertSee('20000000');// tranfer_amount_１
    }

    function assertChangeMonth($browser)
    {
        $browser->waitUntilMissing('.loading')
            ->waitForText('pigion nakamoto')
            ->assertSeeIn('.select_month', '2021年07月')//assert Month is in the selector
            ->assertSee('pigion nakamoto')//assert fullname
            ->scrollIntoView('.emp_info')
            ->waitForText('16.5')->assertSee('16.5') // working_days
            ->assertSee('5.5') // working_out_of_days
            ->assertSee('5') //special_leave_days
            ->assertSee('1')// paid_off_days
            ->assertSee('2')// off_days
            ->assertSee('185')// remaining_paid_off_days
            ->assertSee('00:00:18')// working_time
            ->assertSee('00:00:01')// late_early
            ->assertSee('00:00:00')// common_ot
            ->assertSee('00:00:05')// hard_work_time_2
            ->assertSee('150:00:00')// midnight_cp_time
            ->assertSee('3000000')// basic_salary
            ->assertSee('2')// salary_for_performance
            ->assertSee('1')// position_cp
            ->assertSee('2')// heavy_truck_cp
            ->assertSee('0')// bd_cp
            ->assertSee('0')// other_cp
            ->assertSee('0')// ot_salary_cp
            ->assertSee('0')// hard_work_2_cp
            ->assertSee('150:00:00')// midnight_cp
            ->assertSee('1000000')// paid_off_adjustment
            ->assertSee('0')// ot_cp_adjustment
            ->assertSee('200')// last_month_adjustment
            ->assertSee('1000000')// adjusted_salary
            ->assertSee('500')// bounty
            ->assertSee('0')// attendance_deduction
            ->assertSee('0')// other_payment_paid_off
            ->assertSee('0')// ot_adjustment_cp
            ->assertSee('0')// reduced_amount
            ->assertSee('10')// taxable_amount
            ->assertSee('500')// transportation_cp
            ->assertSee('2000000')// total_amount_of_payment
            ->assertSee('300')// health_insurance
            ->assertSee('200')// nursing_care_insurance
            ->assertSee('500')// welfare_pension_insurance
            ->assertSee('1000000')// unemployment_insurance
            ->assertSee('2500000')// total_insurance_amount
            ->assertSee('0')// inhabitant_tax
            ->assertSee('0')// inhabitant_tax_deduction
            ->assertSee('0')// apartment_fee
            ->assertSee('0')// other_1
            ->assertSee('0')// other_2
            ->assertSee('0')// other_3
            ->assertSee('0')// incurred_previous_month
            ->assertSee('0')// advance_paid
            ->assertSee('0')// withholding
            ->assertSee('0')// adjustment_deduction
            ->assertSee('0')// year_end_adjustment
            ->assertSee('1500000')// total_dedution_amount
            ->assertSee('600000')// payable_overpaid_tax
            ->assertSee('0')// net_payment
            ->assertSee('3000000')// cash_salary
            ->assertSee('9000000');// tranfer_amount_１
    }

    //crew check payslip or the explanation of terms.
    function accessBySmartphone($browser)
    {
        $this->login($browser, 'CREW', 'Access payslip detail by Crew &dstatus=1');
        $browser->waitFor('.select_month', 5)->select('.select_month', '2021-07-01')
            ->waitUntilMissing('.loading')
            ->click('#helper')->waitFor('.helper_master')
            ->assertSee('各項目の解説が表示されます。')->pause(2000)
            ->waitUntilMissing('.loading')->press('.icon-toggle')->pause(2000)
            ->assertPathIs('/payslip/detail')
            ->assertSee('1')
            ->assertSee('888888')
            ->assertSee('pigion nakamoto');
        $browser->driver->executeScript('window.scrollTo(0,5000);');
    }
}
