<?php
/**
 * Created by PhpStorm.
 * User: autoDump
 * Year: 2021-07-20
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserProxyRequest;
use App\Repositories\Contracts\UserProxyRepositoryInterface;
use App\Http\Resources\BaseResource;
use App\Http\Resources\UserProxyResource;
use Illuminate\Http\Request;

class UserProxyController extends Controller
{

     /**
     * var Repository
     */
    protected $repository;

    public function __construct(UserProxyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Get(
     *   path="/api/userproxy",
     *   tags={"UserProxy"},
     *   summary="List userproxy",
     *   operationId="userproxy_index",
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{{"id": 1,"name": "..........."}}}
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="page",
     *     in="query",
     *     @OA\Schema(
     *      type="integer",
     *     ),
     *   ),
     *   @OA\Parameter(
     *     name="per_page",
     *     in="query",
     *     @OA\Schema(
     *      type="integer",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Login false",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Username or password invalid"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UserProxyRequest $request)
    {
        $data = $this->repository->paginate($request->per_page);// lấy thông tin và phân trang
        return $this->responseJson(200, BaseResource::collection($data));
    }

    public function store(UserProxyRequest $request)
    {
        try {
            $data = $this->repository->create($request->all());
            return $this->responseJson(200, new UserProxyResource($data));
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        try {
            $department = $this->repository->find($id);
            return $this->responseJson(200, new BaseResource($department));
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function update(UserProxyRequest $request, $id)
    {
        $attributes = $request->except([]);
        $data = $this->repository->update($attributes, $id);
        return $this->responseJson(200, new BaseResource($data));
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return $this->responseJson(200, null, trans('messages.mes.delete_success'));
    }
}
