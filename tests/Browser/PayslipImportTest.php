<?php

namespace Tests\Browser;

use App\Models\Payslip;
use App\Models\User;
use Facebook\WebDriver\WebDriverKeys;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PayslipImportTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testGeneral()
    {
        $this->browse(function ($browser) {
            $this->validateImport($browser);
            $this->showErrorImport($browser);
            $this->resultInPage($browser);
        });
    }
    public function validateImport($browser)
    {
        $this->login($browser);
        $browser->visit('/import-csv/index?dtext=Validate Import File &dstatus=1');
        // test validate error file extension
        $browser->attach('file_csv','./tests/csv/error_ext.html')->click('.import_csv')->waitFor('.b-toast-danger')->assertVisible('.b-toast-danger')->waitUntilMissing ('.loading');
        // test validate error file size
        $browser->attach('file_csv','./tests/csv/error_size.csv')->click('.import_csv')->waitFor('.b-toast-danger')->assertVisible('.b-toast-danger')->waitUntilMissing ('.loading');
    }
    public function showErrorImport($browser){
        // import second times
        $browser->attach('file_csv','./tests/csv/test.csv')->click('.import_csv')->waitFor('.api_report',10)
                ->assertSeeAnythingIn('.api_report');
        $browser->attach('file_csv','./tests/csv/fail.csv')->waitUntilMissing ('.loading')
        ->click('.import_csv')->waitFor('.b-toast-danger',10)->assertVisible('.b-toast-danger');
    }
    public function resultInPage($browser){
        $browser->attach('file_csv','./tests/csv/test.csv')->click('.import_csv')->pause(5000);
        $browser->clickLink('給与明細書')->waitUntilMissing ('.loading')->press('.btn_dropdown_filter')
        ->click('.checkbox_filtercode')->type('emp_code','999999')->press('.btn_apply')->waitUntilMissing ('.loading')->assertSee('999999');
        Payslip::where('emp_code','999999')->forceDelete();
        User::where('emp_code','999999')->forceDelete();
    }

}
