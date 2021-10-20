<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2021-06-04
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use App\Repositories\Contracts\SettingRepositoryInterface;
use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    /**
     * var Repository
     */
    protected $repository;

    public function __construct(SettingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    
    public function index()
    {
        $data = $this->repository->paginate();
        return $this->responseJson(CODE_SUCCESS, BaseResource::collection($data));
    }


    public function show($id)
    {
        try {
            $setting = $this->repository->find($id);
            return $this->responseJson(CODE_SUCCESS, new BaseResource($setting));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    
    public function store(SettingRequest $request)
    {
        $setting = $this->repository->create($request->all());
        return $this->responseJson(CODE_SUCCESS, new BaseResource($setting));
    }

    public function update(SettingRequest $request, $id)
    {
        $attributes = $request->except([]);
        $data = $this->repository->update($attributes, $id);
        return $this->responseJson(CODE_SUCCESS, new BaseResource($data));
    }
    
    public function destroy($id)
    {
        $result = $this->repository->delete($id);
        if($result){
            return $this->responseJson(CODE_SUCCESS, null, trans('messages.mes.delete_success'));
        }
        return $this->responseJsonError(CODE_DELETE_FAILED, null, trans('messages.mes.delete_error'));
    }
}



