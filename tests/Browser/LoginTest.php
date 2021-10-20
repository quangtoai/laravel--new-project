<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testGeneral()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login?dtext=Test login&dstatus=1')->waitFor('#veho_login');
            $this->validate($browser);
            $this->loginByAccountRetirement($browser);
            $this->loginByManager($browser);
            $this->loginByCrew($browser);
            $this->loginByTempPassNewEmail($browser);
            $this->loginByTempPassProxyEmail($browser);
        });
    }

    public function validate($browser)
    {
        //wrong employee number or password
        $browser->type('emp_code', '12345')->type('password', '123456789')
            ->press('.btn_submit')->waitFor('.b-toast-danger')->assertSee('ERR32')
            // password <8 charactor
            ->press('.close')->type('emp_code', '123456')->type('password', '1234567')
            ->press('.btn_submit')->waitFor('.b-toast-danger')->assertSee('ERR04')
            // password is null
            ->press('.close')->type('emp_code', '123456')->type('password', '')
            ->press('.btn_submit')->waitFor('.b-toast-danger')->assertSee('ERR03')
            //emp_code is null
            ->press('.close')->type('emp_code', '')->type('password', '12345678')
            ->press('.btn_submit')->waitFor('.b-toast-danger')->assertSee('ERR02');
    }

    //check cabin crew retire over 30 days of login
    public function loginByAccountRetirement($browser)
    {
        $browser->type('emp_code', '555555')
            ->type('password', '123456789')->press('.btn_submit')
            ->waitForText('ERR33')->assertSee('ERR33')
            ->assertPathIsNot('/payslip/index');
    }

    public function loginByManager($browser)
    {
        $browser->visit('/admin?dtext=Test login&dstatus=1')->waitFor('#veho_login')
            ->type('emp_code', '123456')
            ->type('password', '123456789')->press('.btn_submit')
            ->waitUntilMissing('#veho_login')->assertPathIs('/payslip/index')
            ->press('#btn_logout')->waitFor('#veho_login');
    }

    public function loginByCrew($browser)
    {
        $browser->type('emp_code', '888888')
            ->type('password', '123456789')->press('.btn_submit')
            ->waitUntilMissing('#veho_login')->assertPathIs('/payslip/detail')
            ->press('#btn_logout')->waitFor('#veho_login');
    }

    public function loginByTempPassNewEmail($browser)
    {
        $browser->type('emp_code', '1234')
            ->type('password', '12341234')->press('.btn_submit')
            ->waitUntilMissing('#veho_login')->assertPathIs('/change-password')
            ->type('email', 'test123.qsoft@gmail.com')
            ->type('password', '123456789')->press('.btn_submit')
            ->waitFor('#veho_empshow')->assertPathIs('/employee/show');
//            ->press('#btn_logout')->waitFor('#veho_login');
    }

    public function loginByTempPassProxyEmail($browser)
    {
        $browser->visit('/login?dtext=Test login&dstatus=1')->waitFor('#veho_login');
        $browser->type('emp_code', '1234')
            ->type('password', '12341234')->press('.btn_submit')
            ->waitUntilMissing('#veho_login')->assertPathIs('/change-password')
            ->check('.check_input')->pause(2000)
            ->select('#proxy-contact-input', 'baotuyen555@gmail.com')
            ->type('password', '123456789')->scrollIntoView('.btn_submit')->press('.btn_submit')
            ->waitFor('#veho_empshow')->assertPathIs('/employee/show');
    }
}


