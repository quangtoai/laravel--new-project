<?php
/**
 * Created by PhpStorm.
 * User: autoDump
 * Year: 2021-07-14
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PayslipRequest;
use App\Repositories\Contracts\PayslipRepositoryInterface;
use App\Http\Resources\BaseResource;
use App\Http\Resources\PayslipResource;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Imports\PayslipsImport;
use App\Models\Payslip;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use stdClass;

class PayslipController extends Controller
{

     /**
     * var Repository
     */
    protected $repository;

    public function __construct(PayslipRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Get(
     *   path="/api/payslip",
     *   tags={"Payslip"},
     *   summary="List payslip",
     *   operationId="payslip_index",
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{
     * {"id": 1,"emp_code": "123456","department":"Tokyo","full_name":"abc","working_days":22},
     * {"id": 2,"emp_code": "123457","department":"Tokyo","full_name":"abcd","working_days":22},
     * }}
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="page",
     *     in="query",
     *     @OA\Schema(
     *     type="integer",
     *     ),
     *     ),
     *   @OA\Parameter(
     *     name="per_page",
     *     in="query",
     *     @OA\Schema(
     *     type="integer",
     *     ),
     *     ),
     *   @OA\Parameter(
     *     name="month",
     *     in="query",
     *     @OA\Schema(
     *     type="string",
     *     ),
     *     ),
     *   @OA\Parameter(
     *     name="emp_code",
     *     in="query",
     *     @OA\Schema(
     *     type="string",
     *     ),
     *     ),
     *   @OA\Parameter(
     *     name="emp_name",
     *     in="query",
     *     @OA\Schema(
     *     type="string",
     *     ),
     *     ),
     *   @OA\Parameter(
     *     name="sortby",
     *     in="query",
     *     @OA\Schema(
     *     type="string",
     *     ),
     *     ),
     *   @OA\Parameter(
     *     name="sorttype",
     *     in="query",
     *     @OA\Schema(
     *     type="integer",
     *     ),
     *     ),
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
    public function index(PayslipRequest $request)
    {
        $objs = $this->repository->getPagination($request);// gọi repository-> gọi->getPagination truyền biến $request
        $result=BaseResource::collection($objs);
        $result['month']=$request->has('month') ? $request->month : date('Y-m-01');// nếu như kết quả trả về có month ==request month thì $request->month  nếu không thì để date dạng Y-m-01'
        return $this->responseJson(200, $result); // trả về kết quả mã 200 và thông tin bảng lương
    }

    /**
     * @OA\Post(
     *   path="/api/payslip",
     *   tags={"Payslip"},
     *   summary="Import payslip",
     *   operationId="payslip_create",
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *            @OA\Property(
     *              property="file",
     *              format="file",
     *              type="file",
     *            ),
     *            @OA\Property(
     *              property="month",
     *              format="string",
     *              type="date",
     *            ),
     *              required={"file","month"}
     *         )
     *      )
     * ),
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"message":"Import successfuly"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(PayslipRequest $request)
    {
        $validator = Validator::make($request->all(),[
            // 'file' => 'required|max:5120|mimes:csv,txt'
            'file' => 'required|max:5120'
        ]);
        if($validator->fails()){
            return $this->responseJson(422 , $validator->errors());
        }else {
            $result=$this->repository->importCsv($request);
            if($result['mes']) // nếu có mes
                return $this->responseJson(500 , $result,$result['mes']);// trả về json mã lỗi 500 và thông báo
            return $this->responseJson(200 , $result); // thực hiện trả về json mã thành côn 200 và kết quả
        }
    }
    /**
     * @OA\Get(
     *   path="/api/payslip/detail",
     *   tags={"Payslip"},
     *   summary="Detail Payslip",
     *   operationId="payslip_show",
     *   @OA\Parameter(
     *     name="emp_code",
     *      in="query",
     *     required=false,
     *     @OA\Schema(
     *     type="string",
     *     ),
     *     ),
     *   @OA\Parameter(
     *     name="month",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *     type="string",
     *     ),
     *     ),
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"id": 1,"emp_code":"123456","month":"2021-1","department":"Tokyo"}}
     *     )
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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(PayslipRequest $request)
    {
        try {
            $obj = $this->repository->getOne($request);
            if(!$obj)
                return $this->responseJson(200, new stdClass());
            return $this->responseJson(200, new BaseResource($obj));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @OA\Get(
     *   path="/api/payslip/month/",
     *   tags={"Payslip"},
     *   summary="month list",
     *   operationId="month_show",
     *   @OA\Parameter(
     *     name="is_full",
     *      in="query",
     *     required=false,
     *     @OA\Schema(
     *     type="number",
     *     ),
     *     ),
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *     )
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
    public function month(PayslipRequest $request)
    {
        try {
            $obj = $this->repository->month($request->is_full);
            return $this->responseJson(200, new BaseResource($obj));
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
