<?php


namespace App\Repositories;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Repository\BaseRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    public function model()
    {
        return User::class;
    }

    public function getAll($id)
    {
        return User::with('roles')->find($id);
    }
    public function getOne()
    {
        return User::with('roles')->get();
    }
    public function getPagination(UserRequest $request)
    {
        $sortby=$request->has('sortby') ? $request->sortby : 'id'; // $sortby == $request->sortby nếu kiểm tra trong resquest có sortby nếu không $sortby == id
        $sorttype=$request->has('sorttype') && $request->sorttype ? 'desc' : 'asc';// $sorttype ==desc nếu kiểm tra sorttype cso trong request và có $request->sorttype nếu không $sorttype ==asc

        $query = User::query();// tìm kiếm tất cả user
        if ($request->has('emp_code'))// nếu kiểm tra trong $request có chưa tham số emp_code thì
            $query->where('emp_code', 'LIKE', '%' . $request->emp_code . '%');// lấy tất cả user điều kiện cột emp_code trung với số $request->emp_code
        if ($request->has('emp_name')) {// nếu kiểm tra trong request có emp_name thì
            $query->where(function ($query) use ($request) { //lấy tất cả user điểu kiện truyền function với 2 biến $query và $request thực hiện
                $query->where('first_name', 'LIKE', '%' . $request->emp_name . '%')// tất cả user điều  kiện first_name bằng 1 trong các chữ cái  $request->emp_name
                    ->orWhere('last_name', 'LIKE', '%' . $request->emp_name . '%'); // và điều kiện tất cả user điều kiện first_name bằng 1 trong các chữ cái  $request->first_name
            });
        }
        $result=$query->orderBy($sortby,$sorttype)->paginate($request->per_page);// nếu như không có emp_code và emp_name thì sắp xếp  kết quả trả về theo $sortby,$sorttype và theo per_page
        return $result; // trả về $result
    }
    public function getUserByEmpCode($emp_code)
    {
        return User::where([['emp_code', $emp_code]])->first();// trả về User với điều kiện emp_code ==$emp_code
    }

    public function update(array $request, $emp_code)
    {
        $auth = JWTAuth::user(); // lấy thông tin user đang đăng nhập
        $this->applyScope();
        $model = $this->model->where([['emp_code', $emp_code]])->first();// lấy thông tin user điều kiện emp_code bằng $emp_code
        $mes=""; // đặt biến chứa thông báo
        if(!$model)// nếu như emp_code không trùng với $request->emp_code thì
            $mes='Employee code is not found'; // thông báo empcode không tìm thấy
        if(isset($request['password']) && $request['password']){ //nếu kiểm tra trong $request có password thì thực hiện
            if( !$request['current_password']|| !$request['confirm_password'] ) // nếu  không có current_password hoặc confirm_password thì
                $mes='server.current_pass_confirm_pass_not_null'; // trả về thông báo current_pass_confirm_pass_ không được bỏ trống
            elseif($request['password']  !=$request['confirm_password']) //ngược lại nếu password khác confirm_password thì
                $mes=='server.confirm_pass_not_match';// trả về thông báo confirm_pass không trùng khớp
            elseif(!Hash::check($request['current_password'],$model->password))// ngược lại nếu current_password không bằng $model->password thì
                $mes='server.current_pass_incorrect'; // thông báo current_pass không đúng
            else //ngược lại
                $model->password=$request['password'];// gán password cho = $request['password']
        }
        if($mes){ // nếu $mes có thì
            return ['message'=>$mes]; // trả về 'message'=>$mes
        }
        if(isset($request['email']))// nếu kiểm tra có $request['email' thì
            $model->email=$request['email']; // gán $model = $request['email']
        if($auth->role=='MANAGER'){ // nếu user đang nhập có quyền là MANAGER thì
            if(isset($request['role']))// nếu kiểm tra $request['role'] thì
                $model->role=$request['role'];// gán role == $request['role']
                // var_dump($request['retirement_at']);
            if(isset($request['retirement_at'])) // nếu kiểm tra thấy $request['retirement_at'] thì
                $model->retirement_at=$request['retirement_at'];// gán retirement_at bằng $request['retirement_at']
            // if($request['retirement_at']===null)
        }else{// nếu không phải MANAGER thì
            if($auth->emp_code!=$emp_code){//kiểm tra nếu emp_code của user đăng nhập không bằng $emp_code thì
                return $model; // trả về thông tin model
            }
        } //ngược lại thì
        $model->save();// thực hiện lưu vào db
        return $model; //trả về model
    }
}
