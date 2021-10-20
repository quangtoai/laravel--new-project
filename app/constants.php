<?php

define('DEFAULT_ZERO_PAD',  5);
define('DEFAULT_STR_ZERO',  '0');

define('CODE_SUCCESS', 200);
define('CODE_CREATE_FAILED', 201);
define('CODE_DELETE_FAILED', 202);
define('CODE_MULTI_STATUS', 207);
define('CODE_NO_ACCESS', 403);
define('CODE_NOT_FOUND', 404);
define('CODE_ERROR_SERVER', 500);
define('CODE_UNAUTHORIZED', 401);

define('IMAGE', 'upload/image');

define('CSV_PAYSLIP_DATA', [
     // '所属' => 'department',
     'emp_code'=> '社員番号',
     'full_name' => '氏名',
     'working_days' => '出勤日数',
     'working_out_of_days' => '休出日数',
     'special_leave_days' => '特休日数',
     'paid_off_days' => '有休日数',
     'off_days' => '欠勤日数',
     'remaining_paid_off_days'=> '有休残',
     'working_time'=> '出勤時間',
     'late_early'=> '遅早時間',
     'common_ot'=> '普通残業時間',
     'hard_work_time'=> '公出時間',
     'hard_work_time_2'=> '休出時間',
     'midnight_cp_time'=> '深夜手当時間', //36
     'other_overtime' => 'その他残業', // ko co trong database
     'basic_salary'=> '基 本 給',
     'salary_for_performance'=> '職 能 給',
     'position_cp'=> '役職手当',
     'heavy_truck_cp' => '大型手当',
     'bd_cp'=> '同乗手当',
     'driver_cp'=> 'ドライバー手当',
     'other_cp' => 'その他手当',
     'paid_off_adjustment'=> '有給欠勤調整分',
     'ot_cp_adjustment'=> '超過勤務手当調整額',
     'last_month_adjustment'=> '前月調整',
     'adjusted_salary'=> '調整給',
     'bounty' => '報奨金',
     'attendance_deduction'=> '勤怠控除',
     'other_payment_paid_off'=> 'その他支給（有給）',
     'ot_adjustment_cp'=> '時間外調整手当',
     'hard_work_2_cp'=> '休日出勤手当',
     'midnight_cp'=> '深夜手当',
     'ot_salary_cp' =>'時間外労働手当' ,
     'reduced_amount'=> '減額金',
     'taxable_amount'=> '課税支給額',
     'transportation_cp'=> '通勤手当',
     'total_amount_of_payment'=> '総支給金額',
     'health_insurance'=> '健康保険料', // khác trường database
     'nursing_care_insurance'=> '介護保険料', // khác trường database
     'welfare_pension_insurance'=> '厚生年金保険',// khác trường database
     'unemployment_insurance'=> '雇用保険料',// khác trường database
     'total_insurance_amount'=> '社保合計額',
     'pit' => '所 得 税',
     'inhabitant_tax'=> '住 民 税',
     'inhabitant_tax_deduction'=> '住民税（控除）',
     'apartment_fee'=> '寮費',
     'other_1'=> 'その他１',
     'other_2'=> 'その他２',
     'other_3'=> 'その他３',
     'incurred_previous_month'=> '前月別途振込',// khác trường database
     'advance_paid'=> '立替金',
     'withholding'=> '預かり金',
     'adjustment_deduction'=> '調整（控除)',
     'year_end_adjustment'=> '年末調整',
     'total_dedution_amount'=> '控除合計額',
     'payable_overpaid_tax' => '過不足税額',
     'net_payment'=> '差引支給額',
     'cash_salary' => '現金支給額',
     'tranfer_amount_１' => '銀行１振込額',
]);

define("TEMP_PASS",'123456789');


