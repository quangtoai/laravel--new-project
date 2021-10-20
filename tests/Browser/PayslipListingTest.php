<?php

namespace Tests\Browser;

use App\Models\Payslip;
use Facebook\WebDriver\WebDriverKeys;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PayslipListingTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testGeneral()
    {
        for($i=10;$i<100;$i++){
            Payslip::create(['emp_code'=>$i,'month'=>'2021-06-01','full_name'=>'full_name'.$i,'department'=>1]);
        }
        $this->browse(function ($browser) {
            $this->listPayslip($browser);
            $this->filterPayslip($browser);
            $this->paginationPayslip($browser);
        });
        Payslip::where('month','2021-06-01')->forceDelete();
    }

    function listPayslip($browser)
    {
        $this->login($browser,'MANAGER','Payslip listing');
       
        $browser->visit('/payslip?dtext=Test Payslip List&dstatus=1')->waitUntilMissing('.loading')
            ->select('.select_month', '2021-08-01')->assertSee('pigion')->assertSee('satoshi')
            // Test sort by employee_code
            ->waitUntilMissing('.loading')->press('.btn_sortcode')->waitUntilMissing('.loading')
            ->assertSeeIn('.sort_0', '888888')->assertSeeIn('.sort_1', '2')
            // Test sort by employee_name
            ->waitUntilMissing('.loading')->press('.btn_sortname')->waitUntilMissing('.loading')
            ->assertSeeIn('.sort_0', 'satoshi nakamoto')->assertSeeIn('.sort_1', 'pigion nakamoto');
    }

    public function filterPayslip($browser)
    {
        $browser->waitUntilMissing('.loading')->press('.btn_dropdown_filter')
            //search payslip by emp_code
            ->click('.checkbox_filtercode')->type('emp_code', '888888')
            ->press('.btn_apply')->waitUntilMissing('.loading')
            ->scrollIntoView('.table')->waitFor('.sort_0')->assertSeeIn('.table', '888888')->assertDontSeeIn('.table', '2')
            // search payslip by emp_name
            ->click('.checkbox_filtername')
            ->type('emp_code', '')->type('emp_name', 'pigion')->press('.btn_apply')->waitUntilMissing('.loading')
            ->scrollIntoView('.table')->waitFor('.sort_0')->assertSeeIn('.table', 'pigion')->assertDontSeeIn('.table', 'satoshi')
            //search payslip by emp_code and emp_name
            ->type('emp_code', '2')->type('emp_name', 'satoshi')->press('.btn_apply')->waitUntilMissing('.loading')
            ->scrollIntoView('.table')->waitFor('.sort_0')->assertSeeIn('.table', 'satoshi')->assertDontSeeIn('.table', 'pigion')
            //Leave the data search box blank
            ->type('emp_code', '')->type('emp_name', '')->press('.btn_apply')->waitUntilMissing('.loading')
            ->scrollIntoView('.table')->waitFor('.sort_0')->assertSeeIn('.table', 'satoshi')->assertSeeIn('.table', 'pigion')
            // search payslip not exist
            ->type('emp_code', '987641')->type('emp_name', '')->press('.btn_apply')->waitUntilMissing('.loading')
            ->scrollIntoView('.table')->assertDontSeeIn('.table', '987641')
            //salary slip search by emp_code and emp_name does not match data
            ->type('emp_code', '2')->type('emp_name', 'pigion')->press('.btn_apply')->waitUntilMissing('.loading')
            ->scrollIntoView('.table')->assertDontSeeIn('.table', '2')->assertDontSeeIn('.table', 'pigion')
            // Searching for pay slips entered wrong emp_name instead of emp_code
            ->type('emp_code', '')->type('emp_name', '888888')->press('.btn_apply')->waitUntilMissing('.loading')
            ->scrollIntoView('.table')->assertDontSeeIn('.table', '888888')
            ->type('emp_code', '')->type('emp_name', '') // clear filter
            ->press('.btn_dropdown_filter');// close dropdown filter;
    }

    public function paginationPayslip($browser)
    {
       
        
        $browser->select('.select_month', '2021-06-01')->waitUntilMissing('.loading')
            ->scrollIntoView('.pagination')
            // Go to next page
            ->click('.next')->waitUntilMissing('.loading')
            ->scrollIntoView('.pagination')
            ->assertSeeAnythingIn('.table_payslip')->assertSeeIn('.pagination .active', '2')
            // Go to previous page
            ->click('.prev')->waitUntilMissing('.loading')
            ->assertSeeAnythingIn('.table_payslip')->assertSeeIn('.pagination .active', '1')
            // ->scrollIntoView('.pagination')
            // // Go to last page
            ->click('.last')->waitUntilMissing('.loading')
            ->scrollIntoView('.pagination')
            ->assertSeeAnythingIn('.table_payslip')->assertSeeIn('.pagination .active', '5')
            // // Go to first page
            ->scrollIntoView('.pagination')
            ->click('.first')->waitUntilMissing('.loading')
            ->assertSeeAnythingIn('.table_payslip')->assertSeeIn('.pagination .active', '1');
            
    }
}
