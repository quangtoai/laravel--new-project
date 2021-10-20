<?php

namespace Tests\Browser;

use App\Models\User;
use Facebook\WebDriver\WebDriverKeys;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserListTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testGeneral()
    {
        for($i=10;$i<100;$i++){
            User::create(['emp_code'=>$i,'first_name'=>'fname'.$i,'last_name'=>'autotest','password'=>1]);
        }
        $this->browse(function ($browser) {
            $this->accessByCrew($browser);
            $this->accessByManager($browser);
            $this->filterUser($browser);
            $this->paginationUser($browser);
        });
        User::where('last_name','autotest')->forceDelete();
    }
    public function accessByCrew($browser)
    {
        $dtext='?dtext=Access List by Crew &dstatus=1';
        $this->login($browser,'CREW');
        $browser->visit("/employee/index{$dtext}")
        ->assertSee('888888')->assertPathIs('/employee/index');
    }
    public function accessByManager($browser)
    {
        $dtext='?dtext=Access List by Manager &dstatus=1';
        $this->login($browser);
        $browser->visit("/employee/index{$dtext}")->maximize()
        // test list sort
        ->waitUntilMissing ('.loading')->press('#btn_sort_retirement')
        ->waitUntilMissing ('.loading')->assertSeeIn('#row_555555','🏴󠁧󠁢󠁳󠁣󠁴󠁿')//sort retirement

        ->waitUntilMissing ('.loading')->press('#btn_sortcode')//sort emp_code
        ->waitUntilMissing ('.loading')->assertSee('888888')

        ->waitUntilMissing ('.loading')->press('#btn_sortname')//sort emp_name
        ->waitUntilMissing ('.loading')->press('#btn_sort_authority')//sort role
        ->waitUntilMissing ('.loading')
        ->assertPathIs('/employee/index');
    }
    public function filterUser($browser)
    {
        $dtext='?dtext=Test Filter List &dstatus=1';
        $browser->visit("/employee/index{$dtext}")->maximize()
        ->waitUntilMissing ('.loading')
        ->press('.btn_dropdown_filter')
        ->check('.checkbox_empcode')
        ->check('.checkbox_empname')

        // success with emp_code and emp_name
        ->type('@input_emp_code','123456')->type('@input_emp_name','Admin')
        ->press('.btn_apply')->waitUntilMissing ('.loading',10)
        ->assertSee('123456')->assertSee('Admin')
        ->press('.btn_clear')->waitUntilMissing('.loading')

        // success with emp_code and emp_name null
        ->type('@input_emp_code','555555')->press('.btn_apply')->waitUntilMissing ('.loading',10)
        ->assertSee('555555') ->assertSee('satoshi nakamoto')
        ->press('.btn_clear')->waitUntilMissing('.loading')

        // success with emp_name and emp_code null
        ->type('@input_emp_name','pigion')->press('.btn_apply')->waitUntilMissing ('.loading')
        ->assertSee('pigion nakamoto')->assertSee('888888')
        ->press('.btn_clear')->waitUntilMissing('.loading',10)

        // earch fail with emp_code null and emp_name null
        ->type('@input_emp_code','')->type('@input_emp_name','')->press('.btn_apply')->waitUntilMissing ('.loading')
        ->assertVisible('.sort_0')->assertVisible('.sort_3')->assertVisible('.sort_4')

        // search fail with emp_code and emp_name null
        ->type('@input_emp_code','123124245411515')->press('.btn_apply')->waitUntilMissing ('.loading',10)
        ->assertDontSee('#row_888888')
        ->press('.btn_clear')->waitUntilMissing('.loading')

        // search fail with emp_name and emp_code null
        ->type('@input_emp_name','@abc')->press('.btn_apply')->waitUntilMissing ('.loading',10)
        ->assertDontSee('#row_888888')
        ->press('.btn_clear')->waitUntilMissing('.loading')

        // search fail with emp_code and emp_name
        ->type('@input_emp_code','123124245411515')->type('@input_emp_name','!^^!')
        ->press('.btn_apply')->waitUntilMissing ('.loading',10)
        ->assertDontSee('#row_888888')
        ->press('.btn_clear')->waitUntilMissing('.loading')


        //search fail invalide info
        ->type('@input_emp_code','<script>alert("this is bad script")</script>')->type('@input_emp_name','122')
        ->press('.btn_apply')->waitUntilMissing ('.loading')
        ->assertDontSee('<script>alert("this is bad script")</script>')
        ->press('.btn_clear')->waitUntilMissing('.loading')

        ->press('.btn_dropdown_filter')
        ->assertPathIs('/employee/index');
    }
    public function filterUserRetire($browser)
    {
        $dtext='?dtext=Test Filter List &dstatus=1';
        $browser->visit("/employee/index{$dtext}")->maximize()
            ->waitUntilMissing ('.loading')
            ->press('.btn_dropdown_filter')
            ->check('.checkbox_empcode')

            // success with emp_code and emp_name null
            ->type('@input_emp_code','555555')->press('.btn_apply')->waitUntilMissing ('.loading',10)
            ->assertSee('555555') ->assertSee('satoshi nakamoto')
            ->press('.btn_clear')->waitUntilMissing('.loading');
    }


    public function paginationUser($browser)
    {
        $dtext='?dtext=Test Pagination &dstatus=1';
        $browser->visit("/employee/index{$dtext}")->maximize()
        ->waitUntilMissing ('.loading')
        ->scrollIntoView('.pagination')
            // Go to next page
            ->click('.next')->waitUntilMissing('.loading')
            ->scrollIntoView('.pagination')
            ->assertSeeIn('.pagination .active', '2')
            // Go to previous page
            ->click('.prev')->waitUntilMissing('.loading')
            ->assertSeeIn('.pagination .active', '1')
            // ->scrollIntoView('.pagination')
            // // Go to last page
            ->click('.last')->waitUntilMissing('.loading')
            ->scrollIntoView('.pagination')
            ->assertSeeIn('.pagination .active', '5')
            // // Go to first page
            ->scrollIntoView('.pagination')
            ->click('.first')->waitUntilMissing('.loading')
            ->assertSeeIn('.pagination .active', '1');
    }
}
