<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2021-06-04
 */

namespace App\Http\Resources;

class SettingResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
