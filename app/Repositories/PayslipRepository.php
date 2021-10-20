<?php
/**
 * Created by PhpStorm.
 * User: autoDump
 * Year: 2021-07-14
 */

namespace Repository;

use App\Http\Requests\PayslipRequest;
use App\Models\Payslip;
use App\Repositories\Contracts\PayslipRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Date;

class PayslipRepository extends BaseRepository implements PayslipRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param payslip $model
       */

    public function model()
    {
        return payslip::class;
    }
    public function findByid($id){
        $result = Payslip::where('id',$id)->first();
        return $result;
    }
    public function getPagination(PayslipRequest $request){ // kiểm tra request với biến $request
        $user = JWTAuth::user();//lấy thông tin người dùng từ tài khoản dăng nhập
        if($user->role!='MANAGER')//nếu người dùng không phải là quyền manager
            $request->emp_code=$user->emp_code;// thì gán mã nhân viên nhập vào với mã nhân viên đăng nhập (hiển thị bảng lưởng của nhân viên đăng nhập)
        $sortby=$request->has('sortby') ? $request->sortby : 'id';// nếu như người dùng nhập ô sortby thì để $request->sortby nếu không nhập thì để theo id
        $sorttype=$request->has('sorttype') && $request->sorttype ? 'desc' : 'asc'; // nếu người dùng nhập ô sorttype hoặc có sorttype trong request thì để sắp xếp theo lớn đến bé hoặc ngược lại

        $query = Payslip::query(); // đặt biến truy vấn bảng lương
        $month=$request->has(   'month') ? $request->month : date('Y-m-01');//$month = nếu như request có month thì để $request->month nếu không thì để date('Y-m-01')
        $query->where('month', '=', $month);// hiển thị truy vấn bảng lương với điều kiện cột month bằng với request month

        if ($request->has('emp_code'))// nếu như request mà có emp_code thì
            $query->where('emp_code', 'LIKE', '%' . $request->emp_code . '%');//truy vấn bảng lương điều kiện cột emp_code bằng like '%' . $request->emp_code . '%'
        if ($request->has('emp_name')) {
            $query->where('full_name', 'LIKE', '%' . $request->emp_name . '%');//truy vấn theo tên điều kiện cột emp_name  bằng $request->name

        }
        $result=$query->orderBy($sortby,$sorttype)->paginate($request->per_page);//tạo biến lưu truy vấn theo orderby $sortby,$sorttype
        return $result;
    }
    public function getOne(PayslipRequest $request){
        $user = JWTAuth::user(); // lấy giá trị user login
        // $emp_code=$request->emp_code;
        // if($user->role=="CREW"){
        //     $emp_code  = $user->emp_code;
        // }
        $emp_code = $user->role=="CREW" || !$request->emp_code ? $user->emp_code : $request->emp_code;// tạo biến $emp_code = nếu tk login có quyền crew hoặc request ô emp_code bỏ trống thì để emp_code của tk dăng nhập ngược lại thì để $request->emp_code
        return Payslip::where('emp_code' , $emp_code)->where('month',$request->month)->first();// trả về payslip điều kiện emp_code = resquest emp_code và điều kiện month =request->month
    }
    public function month($isFull=false){
        $year=date("Y"); // trả về năm(2021)
        $current_month=intval(date("m"));// chuyển đổi tháng sang giá trị của số nguyên
        $result=[]; // đặt biến kết quả là một mảng
        if($isFull){ // biến isFull đưuọ truyền vào
            for($i=1;$i<=$current_month;$i++){ // thực hiện vong lặp đk i=<$current_month
                $m=$i<10 ? '0'.$i :$i; // gán giá trị m == 0.$i(vd:0.1,0.2) nếu vòng lặp kết thúc dưới 10 ngược lại thì để nguyên giá trị $i(vd:10,11,12)
                $date=$year.'-'.$m.'-01'; // tạo biến $date gán giá trị năm.tháng ngày vào vd(2021-$m-01)
                $result[$date]=date("Y年m月", strtotime($date)); //gán biến $date vào mảng result  và trả về Y年m月(trả về Y năm m tháng) và phân tích chuỗi date thành số
            }
            $result[$year.'-'.$m.'-28']= $year." 年末調整"; //gán $result[$year.'-'.$m.'-28'] bằng  năm .年末調整
        }else{ // mguoc lại mà không có biến $isFull thì
            $user = JWTAuth::user(); // gọi user  của tài khoản login
            $model=Payslip::groupBy('month')->orderBy('month', 'desc'); // nhóm lại các nhóm và sắp xếp thao giá trị tháng tang dần
            if($user->role=='CREW') // nếu user là quyền nhân viên
                $model->where('emp_code',$user->emp_code); // gọi model có điều kiện emp_code của bảng payslip bằng emp_code của thông tin tài khoản đnag nhập
            $months = $model->pluck('month')->toArray();// trả về một mảng payslip tháng tăng dần
            $curent_month=Date('Y-m-01'); //gán biến $curent_month =(date trả về giá trị năm tháng ngày)
            if(!in_array($curent_month,$months)) // nếu $curent_month không phải là giá trị  của mảng $months  thì
                array_unshift($months , $curent_month); // chèn giá trị $curent_month vào mảng $months
            foreach($months as $month){  // lặp vòng lặp mảng $months
                $day=date("d", strtotime($month)) ;// đặt biến date trả về ngày và phân tích chuỗi văn bản tiêngs anh thành một dâu thời gian
                $result[$month]=$day=='01' ? date("Y年m月", strtotime($month)) : $year.'年末調整 ';// trả về kết quả nếu date = 01 thì trả về date có định dạng Y年m月 và chuyển đổi$month thành dấu thời gian ngược lại đặt biến $năm .年末調整
            }
        }
        return [
            'list_month' => $result, //tra về kết quả danh sách tháng
            'current_month' => date('Y-m-01'),// trả về kết quả tháng hiện tại
        ];
    }
    function importCsv(PayslipRequest $request){
        $row = 0; //hàng =0
        $dataFull=[];// dư liệu đầu đủ
        $numberSucces=0;// số đúng
        $numberFail=0;// số sai
        $errors=[];//lỗi
        $mes=''; // thông báo
        if (($handle = fopen(request()->file('file'), "r")) !== FALSE) { // nếu như mở được file tải lên(r: chỉ đọc đặt con trỏ ở đầu dòng)) nếu thành công
            while (($data = fgetcsv($handle)) !== FALSE) { // đồng thời chuyển file $handle(exel) thành file csv nếu thành công
                $row++;// row =1
                if($row<5) continue; // nếu dòng nhỏ hơn 5 thi bỏ qua lớn hơn 5 thì chuyển thành csv tuwfw dòng 5 trở đi
                $dataFull[]=$data; // sau khi chuyển sang csv thì gán csv cho  mảng  $dataFull[]
            }
            fclose($handle);// nếu không mở dcc thì xóa file tải lên
        }

        $c=-1; //tạo biến $c
        $emps=$dataFull[0]; // đặt biến lấy giá trị key đầu tiên
        if($dataFull[2][0] !='出勤日数'){ // nếu file csv dòng thứ 2 key[0] không bằng 出勤日数 thì
            $mes='server.csv_file_invalid';// xuất ra thông báo lỗi
        }
        if(!$mes){ // nếu không có thông báo lỗi $mes bên trên thì thực hiện
            $payslip_key = array_keys(CSV_PAYSLIP_DATA);// trả về tập hợp các mảng (CSV_PAYSLIP_DATA)
            foreach($emps as $emp_code){ // gán mảng dữ liệu vào biến $empcode
                $c++;
                if(!$emp_code) continue; // foreach  cho đến khi có emp_code(mảng dữ liệu payslip)
                if(!is_numeric($emp_code)){// kiểm tra xem nếu không phải chuỗi số thì thực hiện
                    if(!strpos('務員',$emp_code)); // nếu không có 務員 trong $emp_code(csv)
                        $deparment=$emp_code; // gán giá trị $deparment =$emp_code(file csv)
                    continue;// thực hiện lại
                }
                if(Payslip::where('emp_code','=',$emp_code)->where('month',$request->month)->count() > 0){// nếu payslip có emp_code bằng $emp_code và request ->month = month có số bản ghi lớn hơn 0 thì
                    $errors[]=$emp_code."'s payslip is exist!";//thông báo phiếu lương đã tồn tại
                    $numberFail++;
                    continue;
                }
                $param=[]; // tạo biến param chứa mảng
                foreach($payslip_key as $r=>$f){ // gán payslip_key as key($r) => value($f)
                    if($dataFull[$r][$c] !== "") // nếu file csv tải lên có key và giá trị $c không trống
                        $param[$f] = $dataFull[$r][$c]; // thì gán pram với key và  $c
                }
                $param['month'] = $request->month; //gán param tháng bằng $request->month
                $param['department'] = $deparment; //gán param tháng bằng $request->month
                $this->create_employee($param);// gọi hàm create thêm mới $param
                if($this->create($param)){ //nếu có create param thì
                    $numberSucces++; // thông báo thành công
                }else{
                    $numberFail++;
                }
            }
        }
        return [
            'numberSuccess'=>$numberSucces,
            'numberFail'=>$numberFail,
            'errors'=>$errors,
            'mes'=>$mes

        ];

    }
    function create_employee($param){
        if(User::where('emp_code','=',$param['emp_code'])->count() == 0){
            $fullName = explode('　',$param['full_name']);
            if(!isset($fullName[1]))
                $fullName = explode('  ',$param['full_name']);
            if(!isset($fullName[1]))
                $fullName = explode('   ',$param['full_name']);
            if(!isset($fullName[1]))
                $fullName = explode(' ',$param['full_name']);
            $paramUser=[
                'emp_code' => $param['emp_code'],
                'first_name' => isset($fullName[0]) ? $fullName[0] : '',
                'last_name' => isset($fullName[1]) ? $fullName[1] : '',
                'temp_pass' => TEMP_PASS,
                'password' => 'default',
                'is_new_pass' => 1,
                'role' => "CREW"
            ];
            User::create($paramUser);
        }
    }
}
