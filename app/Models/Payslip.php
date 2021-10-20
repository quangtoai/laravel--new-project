<?php
/**
 * Created by PhpStorm.
 * User: autoDump
 * Year: 2021-07-14
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payslip extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'payslips';

    protected $fillable = ['emp_code',
    'month',
    'department',
    'full_name',
    'working_days',
    'working_out_of_days',
    'special_leave_days',
    'paid_off_days',
    'off_days',
    'remaining_paid_off_days',
    'working_time',
    'late_early',
    'common_ot',
    'hard_work_time',
    'hard_work_time_2',
    'midnight_cp_time',
    'basic_salary',
    'salary_for_performance',
    'position_cp',
    'heavy_truck_cp',
    'bd_cp',
    'driver_cp',
    'other_cp',
    'ot_salary_cp',
    'hard_work_2_cp',
    'midnight_cp',
    'paid_off_adjustment',
    'ot_cp_adjustment',
    'last_month_adjustment',
    'adjusted_salary',
    'bounty',
    'attendance_deduction',
    'other_payment_paid_off',
    'ot_adjustment_cp',
    'reduced_amount',
    'taxable_amount',
    'transportation_cp',
    'total_amount_of_payment',
    'health_insurance',
    'nursing_care_insurance',
    'welfare_pension_insurance',
    'unemployment_insurance',
    'total_insurance_amount',
    'pit',
    'inhabitant_tax',
    'inhabitant_tax_deduction',
    'apartment_fee',
    'other_1',
    'other_2',
    'other_3',
    'incurred_previous_month',
    'advance_paid',
    'withholding',
    'adjustment_deduction',
    'year-end_adjustment',
    'total_dedution_amount',
    'payable_overpaid_tax',
    'net_payment',
    'cash_salary',
    'tranfer_amount_１',
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'data' => 'array'
    ];

}
