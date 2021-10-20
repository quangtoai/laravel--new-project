<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use Tests\Browser\ResetPassTest;
use Tests\Browser\LoginTest;
use Tests\Browser\PayslipImportTest;
use Tests\Browser\PayslipDetailTest;
use Tests\Browser\UserListTest;
use Tests\Browser\UserUpdateTest;


class SystemTest extends DuskTestCase
{
    public function testGeneral()
    {

        $this->browse(function ($browser) {
            $login = new LoginTest();
            $resetPass = new ResetPassTest();
            $paysLipImport = new PayslipImportTest();
            $paySlipDetail = new PayslipDetailTest();
            $userList = new UserListTest();
            $userUpdate = new UserUpdateTest();

            // 1. CREW(temporary) register your e-mail address
            $browser->visit('/login?dtext=Test login&dstatus=1')->waitFor('#veho_login');
            $login->loginByTempPassNewEmail($browser);

            // 2. CREW(temporary) register by proxy e-mail address
            $login->loginByTempPassProxyEmail($browser);

            // 3. CREW(temporary). recovery password
            $browser->visit("/recovery?dtext= Test Reset Password &dstatus=1");
            $resetPass->sendMail($browser);
            $browser->visit("/login?dtext= login TempPass &dstatus=1");
            $resetPass->loginByTempPass($browser);
            $resetPass->changePassword($browser);
            $resetPass->showNewInfo($browser);

            // 4.Import last month's payslip data with csv import
            $this->login($browser);
            $browser->visit('/import-csv/index?dtext= csv import &dstatus=1');
            $paysLipImport->resultInPage($browser);

            // 5.View last month's pay slips with a filter and check the glossary
            $paySlipDetail->accessByManager($browser);
            $paySlipDetail->accessByCrewChangeMonth($browser);
            $paySlipDetail->assertChangeMonth($browser);

            // 7. Display the employee list with a filter.
            $this->login($browser);
            $browser->visit("/employee/index?dtext=employee list filter&dstatus=1")->maximize();
            $userList->filterUser($browser);

            //8. Display the employee list with a filter.
            $userUpdate->accessByManager($browser);

            //9. Filter and browse the employee list and retire one employee data
            $userList->filterUserRetire($browser);

            // 10.Browse the salary statement for last month and check the explanation of terms.
            $paySlipDetail->accessByCrew($browser);
            $paySlipDetail->crewAccessShowHelper($browser);

            // 12. CREW. Display your employee data information.
            $userList->accessByCrew($browser);

            //13. CREW. Edit  your employee data information.
            $userUpdate->accessByCrew($browser);

            //14. CREW (retired). Log in.
            $browser->visit('/login?dtext=CREW (retired) Login.&dstatus=1');
            $login->loginByAccountRetirement($browser);

            //15. CREW (retired). Reissue my password,
            $browser->visit("/recovery?dtext= Test Reset PW Account Retirement &dstatus=1");
            $resetPass->validateEmpcodeByAccountRetirement($browser);


        });
    }
    public function testUiMobile()
    {
        $this->browse(function ($browser) {
            $login = new LoginTest();
            $resetPass = new ResetPassTest();
            $paysLipImport = new PayslipImportTest();
            $paySlipDetail = new PayslipDetailTest();
            $userList = new UserListTest();
            $userUpdate = new UserUpdateTest();
            //16. CREW(smartphone). register your e-mail address
            $browser->resize(460, 768);
            $browser->visit('/login?dtext=CREW (retired) Login.&dstatus=1');
            $login->loginByTempPassNewEmail($browser);

            //17. CREW(smartphone). register by proxy e-mail address
            $login->loginByTempPassProxyEmail($browser);

            //18. CREW(smartphone). recovery password.
            $browser->visit("/recovery?dtext= Test Reset Password &dstatus=1");
            $resetPass->sendMail($browser);
            $browser->visit("/login?dtext= login TempPass &dstatus=1");
            $resetPass->loginByTempPass($browser);
            $resetPass->changePassword($browser);
            $resetPass->showNewInfo($browser);

            //19. CREW(smartphone). Browse the salary statement for last month and check the explanation of terms.
            $paySlipDetail->accessBySmartphone($browser);
            //20. print pdf=>manual
            //21. CREW(smartphone). Display your employee data information.
            $userList->accessByCrew($browser);

            //22. CREW(smartphone). Edit your employee data information.
            $userUpdate->accessByCrewEditEmployee($browser);
        });
    }
}


