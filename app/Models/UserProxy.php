<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2021-07-12
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProxy extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'userproxys';

    protected $fillable = [];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'data' => 'array'
    ];

}
