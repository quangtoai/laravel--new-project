<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RemindRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\UserResource;
use App\Mail\RemindPasswordEmail;
use App\Models\User;
use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Repository\AuthRepository;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class AuthController extends BaseController
{
    protected $authRepository;
    protected $userRepository;

    public function __construct(AuthRepositoryInterface $authRepository, UserRepositoryInterface $userRepository)
    {
        $this->authRepository = $authRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @OA\Post(
     *   path="/api/auth/login",
     *   tags={"Auth"},
     *   summary="Login",
     *   operationId="user_login",
     *   @OA\Parameter(
     *     name="emp_code",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *    @OA\Parameter(
     *     name="password",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Submit request successfully",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"access_token":"Bearer ...",
     *     "profile":{"id":1,
     *     "emp_name":null,
     *     "email":"example@gmail.com",
     *     "phone":null,
     *     "company":null,
     *     "is_new_pw":null,
     *     "created_at":null
     *     }}}
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Login failed",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Wrong account or password"}
     *     )
     *   ),
     *   security={},
     * )
     * Display a listing of the resource.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $result = $this->authRepository->doLogin($request);// gọi repository  gọi doLogin xử lí thông tin đăng nhập
            if ($result['attempt']) { // nếu kết quả trả về có attempt
                $user = $result['user']; // thì gán thông tin user cho $user
                $token =$result['attempt']!='temporary_password' ? "Bearer " .$result['attempt']: $result['attempt']; // nếu attempt khác temporary_password' thì để Bearer.attempt ngược lại thì để attempt
                return $this->responseJson(Response::HTTP_OK, [ // trả về kiểu json với attempt và $user
                    'access_token' => $token,
                    'profile' => new UserResource($user)
                ]);
            }
            return $this->responseJsonError(Response::HTTP_UNAUTHORIZED, $result['mes'] );// ngược lại trả về thông báo lỗi dạng json
    }

    /**
     * @OA\Post(
     *   path="/api/auth/register",
     *   tags={"Auth"},
     *   summary="Register",
     *   operationId="user_register",
     *   @OA\Parameter(
     *     name="emp_code",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Parameter(
     *     name="first_name",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Parameter(
     *     name="last_name",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Parameter(
     *     name="email",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Parameter(
     *     name="password",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Parameter(
     *     name="password_confirmation",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"access_token":"","profile":{"id":1,
     *     "emp_name":null,
     *     "emp_code":null,
     *     "email":"example@gmail.com",
     *     "address":null,
     *     "created_at":1570031021}}}
     *     )
     *   ),
     *   security={},
     * )
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function register(RegisterRequest $request)
    {
        DB::beginTransaction(); // Bắt đầu các hành động trên CSDL
        try { // nếu khối code trong try sai thì chuyển sang chạy catch
            /* @see AuthRepository::register() */
            $user = $this->authRepository->register($request->all());// chuyển dữ liệu đến class auth repository gọi resgister

            $token = JWTAuth::fromUser($user);// gán mã token và thông tin user cho $token
            DB::commit(); ////Commit dữ liệu khi hoàn thành kiểm tra
            return $this->responseJson(200, [ // trả về mã json và thông tin token + profile người dùng đăng kí
                'access_token' => "Bearer " . $token,
                'profile' => new UserResource($user)
            ]);
        } catch (\Exception $e) { // nếu đoạn code ở trên sai
            DB::rollBack(); // //Gặp lỗi nào đó mới rollback
            throw $e; // trả về lỗi $e
        }
    }

    /**
     * @OA\Post(
     *   path="/api/remind-passwords",
     *   tags={"Auth"},
     *   summary="Reset password",
     *   operationId="user_remind",
     *   @OA\Parameter(
     *     name="emp_code",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Submit request successfully",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":"Submit request successfully"}
     *     )
     *   ),
     *   security={},
     * )
     * @param RemindRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function remindPassword(RemindRequest $request)
    {
        $data = $this->authRepository->remindPassword($request);
        if ($data) { // nếu $data == true
            return $this->responseJson(200, 'Submit request successfully');// trả về json mã 200 và thông  báo thành công
        } else //ngược lại nếu trả là sai thì
            return $this->responseJsonError(403, $this->authRepository->mes); // trả về json err và thong báo mes
    }

    /**
     * @OA\Post(
     *   path="/api/auth/refresh",
     *   tags={"Auth"},
     *   summary="User register",
     *   operationId="user_reset_token",
     *   @OA\Response(
     *
     *     response=200,
     *     description="Submit request successfully",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"access_token":"...."}}
     *     )
     *   ),
     *   security={},
     * )
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function refresh()
    {
        return $this->responseJson(200, ['access_token' => auth()->refresh()]);
    }

    /**
     * @OA\Get(
     *   path="/api/profile",
     *   tags={"Auth"},
     *   summary="Get Profile",
     *   operationId="user_profile",
     *   @OA\Response(
     *     response=200,
     *     description="Submit request successfully",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"id": 1, "emp_name":"null","email":"exam@gmail.com","emp_code":"null","":""}}
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Login failed",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Wrong account or password"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfile()
    {
        $user = $this->userRepository->getImageidbyUser(auth()->user()->id);
        return $this->responseJson(200, $user);
    }
      /**
     * @OA\Put(
     *   path="/api/change_pass/{emp_code}",
     *   tags={"Auth"},
     *   summary="Change temporaty password",
     *   operationId="auth_change_pass",
     *   @OA\Parameter(
     *       name="emp_code",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *     type="string",
     *     ),
     *     ),
     *  @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          example={"email":"string","proxy_email":"string", "password": "12345678", "temp_pass": "123456789"},
     *       @OA\Schema(
     *           required={"password","temp_pass"},
     *       @OA\Property(
       *         property="email",
       *         format="string",
       *          ),
     *           @OA\Property(
       *        property="proxy_email",
       *         format="string",
       *          ),
     *           @OA\Property(
       *        property="password",
       *        format="string",),
       *
     *           @OA\Property(
       *        property="temp_pass",
       *        format="string",
       *        ),
     *         )
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="request sent successfully",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"id": 1,"email":  ".............","proxy_email":  ".............","password":  ".............",}}
     *     ),
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Deny access",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":403,"message":"Deny access"}
     *     ),
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(UserRequest $request,$emp_code)
    {
        $result = $this->authRepository->changeTempPass($request->all(), $emp_code);
        if(!$result['message']){ // nếu $result không có message thì
            $loginRequest= new LoginRequest(); // gọi resquet
            $loginRequest->merge(['emp_code'=>$emp_code, 'password'=>$request->password]);// kiểm tra param truyền vài đăng nhập
            return $this->login($loginRequest);// gọi login đăng nhập
        }
        return $this->responseJsonError(Response::HTTP_UNAUTHORIZED, $result['message']);// nếu sai báo err và trả về mess
    }
}

