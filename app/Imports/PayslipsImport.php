<?php

namespace App\Imports;

use App\Models\Payslip;
use Maatwebsite\Excel\Concerns\ToModel;

class PayslipsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Payslip([
            'emp_code' => $row[0],
            'month' => $row[1],
            'department' => $row[2]
        ]);
    }
}
