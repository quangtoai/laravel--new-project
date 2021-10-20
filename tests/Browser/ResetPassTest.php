<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use function PHPUnit\Framework\assertSameSize;

class ResetPassTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testGeneral()
    {
        $this->browse(function ($browser) {
            $text = "Input employee code and submit to send recovery email fail";
            $browser->visit("login?dtext={$text}&dstatus=0")->waitFor('#veho_login')->press('.link_forgot_password');
            $this->validateEmpcodeByAccountRetirement($browser);
            $this->validateEmpcode($browser);
            $this->sendMail($browser);
            $this->loginByTempPassFail($browser);
            $this->loginByTempPass($browser);
            $this->changePasswordFail($browser);
            $this->changePassword($browser);
            $this->showNewInfo($browser);
        });
    }

    function validateEmpcodeByAccountRetirement($browser)
    {
        $browser->waitFor('#veho_recovery')->assertPathIs('/recovery')
            ->type('emp_code', '555555')->press('.btn_submit')->waitFor('.b-toast-danger')
            ->waitForText('ERR33')->assertSee('ERR33')->assertPathIsNot('/notification');
    }

    function validateEmpcode($browser)
    {
        $browser->waitFor('#veho_recovery')->assertPathIs('/recovery')
            ->type('emp_code', '8888887')->press('.btn_submit')
            ->waitFor('.b-toast-danger')->assertVisible('.b-toast-danger')->assertPathIsNot('/notification');
    }

    function sendMail($browser)
    {
        $browser->type('emp_code', '888888')->press('.btn_submit')
            ->waitFor('.page_notify', 10)->assertPathIs('/notification');
    }

    function loginByTempPassFail($browser)
    {
        $browser->press('.btn_submit')->waitFor('#veho_login')->assertPathIs('/login')
            ->type('emp_code', '888888')->type('password', 12342517125)->press('.btn_submit')
            ->waitFor('.b-toast-danger')->waitForText('ERR32')->assertSee('ERR32')->assertPathIsNot('/change-password');
    }

    function loginByTempPass($browser)
    {
        $user = User::where('emp_code', '888888')->first();

        $browser->type('emp_code', '888888')
            ->type('password', $user->temp_pass)->click('.btn_submit')
            ->waitFor('#veho_changepassword', 50)->assertPathIs('/change-password');
    }

    function changePasswordFail($browser)
    {
        // $browser->visit("/change-password?dtext=login Temp Pass Fail&dstatus=0");
        $browser->type('email', 'test123.qsoft@gmail.com')
            ->type('password', '12121')->press('.btn_submit')// password too short
            ->waitFor('.b-toast-danger')->assertSee('ERR04')->assertPathIsNot('/employee/show');
    }

    function changePassword($browser)
    {
        $browser->type('email', 'test123.qsoft@gmail.com')
            ->type('password', '12121212')->press('.btn_submit')
            ->waitFor('#veho_empshow')->assertPathIs('/employee/show');
    }

    function showNewInfo($browser)
    {
        $browser->assertValue('.input_email', 'test123.qsoft@gmail.com')
            ->press('.btn_show')->assertValue('.input_password', '12121212')
            ->waitFor('.btn_submit')->scrollIntoView('.btn_submit')
            ->click('.btn_submit')->waitFor('.payslip_detail')->assertPathIs('/payslip/detail');
            User::where('emp_code','888888')->update(['password' =>  Hash::make('123456789')]);
    }
}
