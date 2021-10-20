<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2021-06-04
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'settings';

//        const LABEL = 'label';
//        const KEY = 'key';
//        const VALUE = 'value';
//        const TYPE = 'type';
//
//    protected $fillable = [self::LABEL, self::KEY, self::VALUE, self::TYPE];

    protected $fillable = ['label', 'key', 'value', 'type'];


    protected $casts = [
        'data' => 'array'
    ];

    public static function get($key){
        return self::where('key', $key)->first();
    }
}
