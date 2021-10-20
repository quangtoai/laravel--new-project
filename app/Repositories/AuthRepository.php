<?php

namespace Repository;

use App\Http\Controllers;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RemindRequest;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Mail\RemindPasswordEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ChangePasswordRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AuthRepository  implements AuthRepositoryInterface
{
    protected $shopRepository;

    public function __construct()
  {
    }

    /**
     *
     * Handle action login of user.
     *
     * @param LoginRequest $request
     * @param null $guard
     * @return array
     */
    public function doLogin(LoginRequest $request, $guard = null): array
    {
        $input = $request->only('emp_code', 'password');// đặt biến lấy giá trị code và pass trong request
        $attempt = JWTAuth::attempt($input); //tìm kiếm code và pass trong database nếu đúng thì trả về array user sai thì trả về false
        $mes='';
        if ($attempt) {// nếu attempt thì
            $user = User::where('emp_code', $request->emp_code)->firstOrFail();// lấy user dk code = $resquet->emp_code trả về bản ghi đầu tiên được tìm thấy trong bảng dữ liệu
            if($user->is_new_pw) // nếu user có new_pw thì
                $user->update(array('is_new_pw' => 0)); // update =0
        } else { //ngược lại nếu $attempt trả về false(ko có pw đúng với request) th
            $user = User::where('emp_code', $request->emp_code)->where('temp_pass', $input['password'])->first();//  lấy user  có emp_code =$request->emp_code và temp_pass =$requets ->pass
            if ($user){ // nếu có $user thì
                $user->update(array('is_new_pw' => 1)); // update new_pw =1
                $attempt = 'temporary_password'; // trả về mã $attempt = temporary_password
            }
        }
        if($attempt && $this->checkRetirement($user)){ // nếu user tồn tại và kiểm tra ngày nghỉ hưu đúng trên =30 ngày thì báo tk ko tồn tại
            $attempt=false;
            $mes='server.account_deactivated';
        }
        if(!$attempt && $mes=='') $mes='server.emp_code_or_password_incorrect'; // nếu $attempt sai thì trả về thông báo

        return [
            'attempt' => $attempt,
            'user' => $user,
            'mes'=> $mes
        ];

    }
    function checkRetirement($user){ // kiểm tra người dùng đã nghỉ hưu có đủ điều kiện đăng nhập hay không.
        $dateOff = $user->retirement_at; // lấy mốc thời gian bắt đầu nghỉ hưu.
        if(!$dateOff)  return false; // nếu chưa nghỉ hưu thì trả về false nếu không thì chạy lệnh dưới
        $dateToday = Carbon::now()->toDateString(); // lấy thời gian hiện tại trả về dạng 2018-10-18
        $first_date = strtotime($dateOff); // chuyển sang giây tính từ ngày 1/1/năm đến ngày tháng hiện tại
        $second_date = strtotime($dateToday);// chuyển sang giây tính từ ngày 1/1 năm đến ngày tháng hiện tại
        $dateDiff = abs($first_date - $second_date);// dùng abs để lấy hiệu giữa hai ngày(giây)
        $day = floor($dateDiff / (60 * 60 * 24));// làm tròn lấy kết quả chia cho số giây trong 1 ngày(60 * 60 * 24)
        if ($day >= 30) {// nếu số ngày lớn hơn bằng 30 ngày thì
            return true; // trả về true
        }
        return false; //nếu chưa nghỉ hưu thì trả về false

    }

    /**
     * @param array $params
     * @return bool|void
     */
    public function register(array $params)
    {
        $user = User::create($params);
//        $this->grantRoleNewUser($user);

        return $user;
    }
    public function changeTempPass(array $attr, $emp_code)
    {
        $user = User::where('emp_code', $emp_code)->first(); // lấy thông tin người dùng càn thao tac
        $mes=""; // tạo biến lưu thông thông báo
        if (!$user )// nếu không có user thì
            $mes='server.emp_code_not_exist'; // thông báo sai emp code
        elseif(!$user->is_new_pw) // ngược lại nếu is_new_pass sai
            $mes='server.temp_pass_not_active'; // thông báo temp.pass không hợp lệ
        elseif ($attr['temp_pass'] != $user->temp_pass) //ngược lại nếu temp_pass db không bằng temppass người dùng nhập
            $mes='server.temp_pass_not_match'; // gửi thông báo sai
        if($mes) // nếu có $mes thì
            return ['message'=>$mes];//trả về $mes

        $user->password=$attr['password']; // gán password cho password(db)
        if(isset($attr['email'])) // kiểm tra nếu có email thì
            $user->email=$attr['email']; // gán email =  cho email(db)
        if(isset($attr['proxy_email']))  // nếu kiểm tra nếu có proxy_email
            $user->proxy_email=$attr['proxy_email'];// thì gán == proxy_email(db)
        $user->is_new_pw=0; // gán is_new_pw =0
        if ($user->save()) { // nếu lưu thành công thì
            return $user; // trả về thông tin user
        }

    }
//    protected function grantRoleNewUser(User &$user)
//    {
//        $roleOwnerDefault = array_key_first(config('laratrust_seeder.roles_structure', []));
//        $shopOwner = Role::where('name', $roleOwnerDefault)->first();
//        $user->attachRole($shopOwner);

//    }

    public function remindPassword(RemindRequest $request)
    {
            $user = User::where('emp_code', $request->emp_code)->first();// lấy thông tin người dùng trong db điều kiện emp_code == $request->emp_code
            if(!$user){ // nếu không có user thì
                $this->mes='server.emp_code_not_exist';// gửi thông báo emp_code không tồn tại
                return false; // trả về sai
            }
            elseif($this->checkRetirement($user)){ // nếu true >=30 ngày ( user đúng là nghỉ quá 30 ngày thì kiểm tra xem người dùng có đủ điều kiện đổi pass hay không)
                $this->mes='server.account_deactivated'; // trả về thông báo  tk ko đủ điều kiện đổi pass
                return false; // trả lại false
            } //nếu như tất cả các điều kiện trên là sai thì
            $randPass = Str::random(9); // tạo random pass độ dài bằng 9
            $user->update([ // gọi phương thức update
                // 'temp_pass' => Hash::make($randPass)
                'temp_pass' => $randPass // update vào cột temp_pass
            ]);
            $email = $user->email ? $user->email : $user->proxy_email;// lấy thông tin email của người dùng
            $detail = [ // tạo biến (array) lấy thông tin người dùng để gửi về mail
                'email' => $email,
                'password' => $randPass,
                'emp_code' => $user->emp_code
            ];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ // nếu như email không hợp lệ (hàm kiểm tra e mail có hợp lệ không)
                $this->mes='server.email_invalid';//  gửi thông báo email không hơp lệ
                return false; // trả về false
            }// nếu email họp lệ thì
            Mail::to($email, $user->last_name)->send(new RemindPasswordEmail($detail));// tiến hành gửi mail
            return $user;// trả về thông tin user

    }
}
