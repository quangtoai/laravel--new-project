<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\BaseResource;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Api\AuthController;
class UserController extends BaseController
{
    protected $repository;
    protected $userRepository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Get(
     *   path="/api/user",
     *   tags={"User"},
     *   summary="List user",
     *   operationId="user_index",
     *   @OA\Response(
     *     response=200,
     *     description="response success",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       example={"code":200,"data":{{"id":1,"email":"test@gmail.com","username":"test","name":"abc","created_at":1604982690,"updated_at":1604982690},{"id":2,"email":"test1@gmail.com","username":"test1","name":"abcd","created_at":1604982690,"updated_at":1604982690},"pagination":{"display":1,"total_records":1,"per_page":15,"current_page":1,"total_pages":1}}}
     *     )
     *   ),
     *  @OA\Parameter(
     *     name="emp_code",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *     type="string",
     *     ),
     *     ),
     *  @OA\Parameter(
     *     name="emp_name",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *     type="string",
     *     ),
     *     ),
     *  @OA\Parameter(
     *     name="page",
     *     in="query",
     *     @OA\Schema(
     *     type="integer",
     *     ),
     *     ),
     *  @OA\Parameter(
     *     name="per_page",
     *     in="query",
     *     @OA\Schema(
     *     type="integer",
     *     ),
     *     ),
     *  @OA\Parameter(
     *     name="sortby",
     *     in="query",
     *     @OA\Schema(
     *     type="string",
     *     ),
     *     ),
     *  @OA\Parameter(
     *     name="sorttype",
     *     in="query",
     *     @OA\Schema(
     *     type="integer",
     *     ),
     *     ),
     *  @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Wrong account or password"}
     *     )
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Deny access",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":403,"message":"T??? ch???i quy???n truy c???p"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UserRequest $request)
    {
        $user = JWTAuth::user(); // l???y th??ng tin tk ????ng nh???p
        if($user->role!='MANAGER') //ki???m tra quy???n c???a tk ??ang nh???p n???u kh??c MANAGER th??
            return $this->show($user->emp_code); //g???i h??m show truy???n m?? emp_code c???a user d??ng nh???p
        $users = $this->repository->getPagination($request);// n???u user c?? quy???n manager th??  g???i getPagination v??o x??? l?? $request
        return $this->responseJson(200, BaseResource::collection($users));// tr??? v??? json m?? code 200 v?? danh s??ch user
    }

    /**
     * @OA\Get(
     *   path="/api/user/{emp_code}",
     *   tags={"User"},
     *   summary="User detail",
     *   operationId="user_show",
     *   @OA\Parameter(
     *     name="emp_code",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Submit request successfully",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *     example={"code":200,"data":{"result":{{"id":1,"email":"example@domain.com","proxy_email": "proxyemail@gmail.com","is_new_pw": 0,"retirement_at": "2021-06-05","role": "MANAGER","emp_code":null,"emp_name":null,"created_at":null,"updated_at":null}}}}
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Not login"}
     *     )
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Deny access",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":403,"message":"Access deny permission"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @param $emp_code
     * @return \Illuminate\Http\JsonResponse
     */

    public function show($emp_code) // truy???n emp code
    {
        try {
            $user = $this->repository->getUserByEmpCode($emp_code);//
            return $this->responseJson(CODE_SUCCESS,new BaseResource($user));// tr??? v??? json m?? v?? th??ng tin user
        } catch (\Exception $e) { //n???u kh???i code b??n tr??n l?? sai th??
            throw $e;// tr??? v??? l???i $e
        }
    }
    /**
     * @OA\Put(
     *   path="/api/user/{emp_code}",
     *   tags={"User"},
     *   summary="Update user",
     *   operationId="user_update",
     *   @OA\Parameter(
     *     name="emp_code",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *     type="string",
     *     ),
     *     ),
     *   @OA\RequestBody(
     *    @OA\MediaType(
     *    mediaType="application/json",
     *    example={"email":"string","current_password":"string","password":"string", "confirm_password": "string"},
     *     @OA\Schema(
     *           @OA\Property(
     *            property="email",
     *            format="string",
     *            ),
     *           @OA\Property(
     *            property="current_password",
     *            format="string",
     *            ),
     *           @OA\Property(
     *            property="password",
     *            format="string",
     *             ),
     *           @OA\Property(
     *            property="confirm_password",
     *            format="string",
     *           ),
     *         )
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *       example={"code":200,"data":{"result":{{"id":1,"email":"example@domain.com","username":"NCC1","phone":null,"created_at":1604910110,"updated_at":1604910680}}}}
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Ch??a ????ng nh???p"}
     *     )
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="T??? ch???i quy???n truy c???p",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":403,"message":"T??? ch???i quy???n truy c???p"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UserRequest $request, $emp_code)
    {
        $result = $this->repository->update($request->all(), $emp_code);// g???i repo -> update truy???n bi???n request  v?? emp_code
        if(!$result['message']){ // n???u k???t qu??? tr??? v??? kh??ng c?? message th??
            return $this->responseJson(200, new BaseResource($result));// tr??? v??? m?? th??nh c??ng v?? th??ng tin user
        } //ng?????c l???i
        return $this->responseJsonError(Response::HTTP_UNAUTHORIZED, $result['message']);// tr??? v??? error v?? th??ng b??o
    }

    public function store(UserRequest $request)
    {
        $user = $this->repository->create($request->all());//g???i repository->create truy???n t???t c??? bi???n($request)
        return $this->responseJson(CODE_SUCCESS, new BaseResource($user));//tr??? v??? m?? th??nh c??ng v?? th??ng tin user
    }

    /**
     * @OA\Delete(
     *   path="/api/user/{id}",
     *   tags={"User"},
     *   summary="Delete ..............",
     *   operationId="user_delete",
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Send request Success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":"Send request Success"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * */
    public function destroy($id) // truy???n id c??n x??a
    {
        $this->repository->delete($id); // g???i repo-> delete truy???n id
        return $this->responseJson(CODE_SUCCESS, null, trans('messages.mes.delete_success'));
    }
}
