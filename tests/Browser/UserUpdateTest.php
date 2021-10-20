<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserUpdateTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testGeneral()
    {
        $this->browse(function ($browser) {
            $this->accessByCrew($browser);
            $this->accessByManager($browser);
        });
    }

    public function accessByCrew($browser)
    {
        $dtext = '?dtext=Update Employee&status=1';
        $this->login($browser, 'CREW');
        $email = 'emailchangebyCREW@gmail.com';
        // $browser->visit("/employee/edit/888888{$dtext}")->waitFor('#veho_empupdate')->pause(5000);
        $browser->waitFor('.sidebar-nav')->clickLink('社員データ')->waitFor('#veho_emplist')->waitFor('.btn_row')->pause(500)
            ->press('.btn_row')->waitFor('#veho_empupdate');
        $this->validateCrew($browser);
        $browser->type('email', $email)
            ->type('current_password', '123456789')
            ->type('new_password', '123456789')
            ->type('confirm_new_password', '123456789')
            ->scrollIntoView('.btn_submit')
            ->click('.btn_submit')->waitFor('.sort_0')
            ->assertPathIs('/employee/index')->assertSee($email);
    }

    public function accessByManager($browser)
    {
        User::where('emp_code', '666888')->update(['retirement_at' => null]);
        $dtext = '?dtext=Test update employee by manager &status=1';
        $this->login($browser, 'MANAGER');
        $email = 'emailchangebyMANAGER@gmail.com';
        // $browser->visit("/employee/edit/888888{$dtext}")->waitFor('#veho_empupdate');
        $browser->pause(1000)->clickLink('社員データ')->waitFor('#veho_emplist')->waitFor('.btn_row')
            ->press('.btn_row')->waitFor('#veho_empupdate')->pause(500);
        $this->validateManager($browser);
        $browser->type('email', 'abc@gmail.com')
            ->scrollIntoView('#select_role')
            ->select('#select_role', 'MANAGER')
            ->check('.check_box')//tick checkbox
            ->type('retirement', '8/25/2021')
            ->click('.btn_submit')->waitFor('#veho_emplist')
            ->assertPathIs('/employee/index');
        User::where('emp_code', '666888')->update(['retirement_at' => null]);
    }

    public function validateCrew($browser)
    {
        //email null
        $browser->waitFor('.email')->pause(500)
            //current password incorrect
            ->scrollIntoView('.general')->type('current_password', 'wrong_pass')
            ->type('new_password', 'newpassword')->type('confirm_new_password', 'newpassword')
            ->scrollIntoView('.btn_submit')
            ->press('.btn_submit')->waitFor('.b-toast-danger')
            ->waitForText('ERR27')->assertSee('ERR27')
            ->type('email', '')
            ->scrollIntoView('.btn_submit')->click('.btn_submit')
            ->waitFor('.b-toast-danger')->assertSee('ERR11')
            //email wrong
            ->scrollIntoView('.first_name')->type('email', 'wrong_email')
            ->scrollIntoView('.btn_submit')->click('.btn_submit')
            ->waitFor('.b-toast-danger')->assertSee('ERR12')
            //confirm password not match
            ->scrollIntoView('.general')->type('current_password', '123456789')
            ->type('new_password', '12345678')->type('confirm_new_password', '12341234')
            ->scrollIntoView('.btn_submit')
            ->click('.btn_submit')->waitFor('.b-toast-danger')
            ->assertSee('ERR08');
    }

    public function validateManager($browser)
    {
        //wrong email
        $browser->type('email', 'wrong_email')
            ->scrollIntoView('.btn_submit')
            ->press('.btn_submit')->waitFor('.b-toast-danger')
            ->assertSee('ERR12')
            //email null
            ->clear('email')
            ->scrollIntoView('.btn_submit')
            ->press('.btn_submit')->waitFor('.b-toast-danger')
            ->assertSee('ERR11');
    }
    //smartphone edit emp
    public function accessByCrewEditEmployee($browser)
    {
        $dtext = '?dtext=Update Employee&status=1';
        $this->login($browser, 'CREW');
        $email = 'emailchangebyCREW@gmail.com';
        $browser->pause(2000)->press('.navbar-brand')->waitFor('.sidebar-nav')
            ->clickLink('社員データ')->press('.navbar-brand')->waitFor('#veho_emplist')->waitFor('.btn_row')->pause(500)
            ->press('.btn_row')->waitFor('#veho_empupdate')->pause(555)
            ->type('email', $email)
            ->type('current_password', '123456789')
            ->type('new_password', '123456789')
            ->type('confirm_new_password', '123456789');
        $browser->scrollIntoView('.btn_submit')
            ->click('.btn_submit')->waitFor('.sort_0')
            ->assertPathIs('/employee/index')->assertSee($email)
            ->click('.navbar-toggler')->pause(2000)->press('#btn_logout')->waitFor('#veho_login');
    }
}

