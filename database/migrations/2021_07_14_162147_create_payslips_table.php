<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayslipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payslips', function (Blueprint $table) {
            $table->increments('id');
            $table->index(['id']);
            $table->dropPrimary('id');
            $table->integer('emp_code');
            $table->date('month');
            $table->primary(['emp_code', 'month']);
            $table->string('department');
            $table->string('full_name')->nullable();
            $table->float('working_days')->default(0);
            $table->float('working_out_of_days')->default(0);
            $table->float('special_leave_days')->default(0);
            $table->float('paid_off_days')->default(0);
            $table->float('off_days')->default(0);
            $table->float('remaining_paid_off_days')->default(0);
            $table->time('working_time')->default(0);
            $table->time('late_early')->default(0);
            $table->time('common_ot')->default(0);
            $table->time('hard_work_time')->default(0);
            $table->time('hard_work_time_2')->default(0);
            $table->time('midnight_cp_time')->default(0);
            $table->double('basic_salary')->default(0);
            $table->double('salary_for_performance')->default(0);
            $table->double('position_cp')->default(0);
            $table->double('heavy_truck_cp')->default(0);
            $table->double('bd_cp')->default(0);
            $table->double('driver_cp')->default(0);
            $table->double('other_cp')->default(0);
            $table->double('ot_salary_cp')->default(0);
            $table->double('hard_work_2_cp')->default(0);
            $table->double('midnight_cp')->default(0);
            $table->double('paid_off_adjustment')->default(0);
            $table->double('ot_cp_adjustment')->default(0);
            $table->double('last_month_adjustment')->default(0);
            $table->double('adjusted_salary')->default(0);
            $table->double('bounty')->default(0);
            $table->double('attendance_deduction')->default(0);
            $table->double('other_payment_paid_off')->default(0);
            $table->double('ot_adjustment_cp')->default(0);
            $table->double('reduced_amount')->default(0);
            $table->double('taxable_amount')->default(0);
            $table->double('transportation_cp')->default(0);
            $table->double('total_amount_of_payment')->default(0);
            $table->double('health_insurance')->default(0);
            $table->double('nursing_care_insurance')->default(0);
            $table->double('welfare_pension_insurance')->default(0);
            $table->double('unemployment_insurance')->default(0);
            $table->double('total_insurance_amount')->default(0);
            $table->double('pit')->default(0);
            $table->double('inhabitant_tax')->default(0);
            $table->double('inhabitant_tax_deduction')->default(0);
            $table->double('apartment_fee')->default(0);
            $table->double('other_1')->default(0);
            $table->double('other_2')->default(0);
            $table->double('other_3')->default(0);
            $table->double('incurred_previous_month')->default(0);
            $table->double('advance_paid')->default(0);
            $table->double('withholding')->default(0);
            $table->double('adjustment_deduction')->default(0);
            $table->double('year_end_adjustment')->default(0);
            $table->double('total_dedution_amount')->default(0);
            $table->double('payable_overpaid_tax')->default(0);
            $table->double('net_payment')->default(0);
            $table->double('cash_salary')->default(0);
            $table->double('tranfer_amount_１')->default(0);
            $table->softDeletes();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payslips');
    }
}
