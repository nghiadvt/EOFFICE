<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donvi;
use App\Models\User;
use App\Models\BookDetail;
use App\Models\TongHopThuNhap;
use App\Jobs\SendMaiLuong;
use App\Models\ThanhToanLuongPhuCap;
use App\Models\LuongPhuCap;
use Illuminate\Support\Facades\Input;
use DB;
use DateTime;
use PHPMailer\PHPMailer\Exception;
use Session;


class UserController extends Controller
{
    public function danh_sach_tai_khoan()
    {
        // get data
        $users = User::select('users.*')->with('donvi');

        $keySearch = trim(Input::get('keySearch', ''));

        if ($keySearch != '') {
            $users = $users->leftJoin('donvis', 'donvis.id', '=', 'users.donvi_id')->where('users.actived', 1);
            $users = $users->where(function ($query) use ($keySearch) {
                $query->orwhere('users.fullname', 'like', '%' . $keySearch . '%')
                    ->orwhere('users.email', 'like', '%' . $keySearch . '%')
                    ->orwhere('donvis.name', 'like', '%' . $keySearch . '%')
                    ->orwhere('users.macanbo', 'like', '%' . $keySearch . '%')
                    ->orwhere('users.role', 'like', '%' . $keySearch . '%')
                    ;
            });
        }

        $users = $users->orderBy('users.id', 'DESC')
            ->paginate(30)
            ->appends(Input::except('page'));
        return view(config('app.interface').'users.danh_sach_tai_khoan', compact('users','keySearch'));
    }

    public function them_tai_khoan()
    {
        $donvis = Donvi::getList()->get();
        return view(config('app.interface').'users.them_tai_khoan', compact('donvis'));
    }

    public function save_tai_khoan()
    {
        $data = Input::all();
        if ($data['role'] == 3) {
            $dat['lanhdao'] = isset($data['lanhdao']) ? 1 : null;
        } else {
            $dat['lanhdao'] = null;
        }
        $dat['duyetlichtuan'] = isset($data['duyetlichtuan']) ? 1 : null;
        $dat['view_thongke'] = isset($data['view_thongke']) ? 1 : null;
        $dat['vanthudonvi'] = isset($data['vanthudonvi']) ? 1 : null;
        $dat['fullname'] =   $data['fullname'];
        $dat['macanbo'] =   $data['macanbo'];
        $dat['macanbo'] =   $data['macanbo'];
        $dat['donvi_id'] =   $data['donvi_id'];
        $dat['email'] =   $data['email'];
        $dat['chucdanh'] =   $data['chucdanh'];
        $dat['azure_id'] =   $data['azure_id'];
        $dat['role'] =   $data['role'];
        if (isset($data['id'])) {
            unset($dat['_token']);

            if (User::where('azure_id', $data['azure_id'])->where('id', '<>', $data['id'])->first()) {
                flash('Email đăng nhập ' . $data['azure_id'] . ' đã tồn tại');
                return redirect(route('danh_sach_tai_khoan'));
            }

            if (User::where('id', $data['id'])->update($dat)) {
                flash(' Sửa tài khoản thành công');
            } else {
                flash(' Sửa tài khoản thất bại');
            }
        } else {
            if (User::where('azure_id', $data['azure_id'])->first()) {
                flash('Email đăng nhập ' . $data['azure_id'] . ' đã tồn tại');
                return redirect(route('danh_sach_tai_khoan'));
            }
            $donvi_id = $data['donvi_id'];
            $user = User::create($dat);

            if ($user) {
                $dataToBookIdMap = [
                    'vanbanden' => 1,
                    'vanbandi' => 2,
                    'congviec' => 3,
                    'vanbannoibo' => 4,
                ];

                foreach ($dataToBookIdMap as $dataKey => $bookId) {
                    if (isset($data[$dataKey])) {
                        $coquan = BookDetail::where('donvi_id', $donvi_id)->where('book_id', $bookId)->first();
                        $coquan->user_id .= ';' . $user->id;
                        $coquan->save();
                    }
                }

                flash('Thêm tài khoản thành công');
            } else {
                flash('Thêm tài khoản thất bại');
            }
        }


        return redirect(route('danh_sach_tai_khoan'));
    }

    public function sua_tai_khoan($userId)
    {
        $user = User::find($userId);

        $donvis = Donvi::getList()->get();
        return view(config('app.interface').'users.sua_tai_khoan', compact('donvis', 'user'));
    }

    public function import_luong()
    {
        $created_at = new DateTime('now');
        $created_at->modify('-1 month');
        $date = $created_at->format('m/Y');

        $status = Input::get('status', 'luongvaphucap');
        if ($status == 'luongvaphucap') {
            $path = 'chi_tiet_luong_phu_cap';
            $count = LuongPhuCap::select('users.fullname', 'date', 'nguoinhap_id', 'created_at')
                ->join('users', 'users.id', '=', 'thanhtoan_luong_phucap.nguoinhap_id')
                ->groupBy('date')
                ->count();
            $result = LuongPhuCap::select('users.fullname', 'date', 'nguoinhap_id', 'created_at','thanhtoan_luong_phucap.sendMail')
                ->join('users', 'users.id', '=', 'thanhtoan_luong_phucap.nguoinhap_id')
                ->groupBy('date')
                ->orderBy('date', 'DESC')
                ->get();
            $numberUser = array();
            foreach ($result as $rs):
                $numberUser[$rs['date']] = LuongPhuCap::select('users.fullname', 'date', 'nguoinhap_id', 'created_at')
                    ->join('users', 'users.id', '=', 'thanhtoan_luong_phucap.nguoinhap_id')
                    ->where('thanhtoan_luong_phucap.date','=',$rs['date'])
                    ->groupBy('date')
                    ->count();
            endforeach;


        } else {
            $path = 'chi_tiet_tong_hop_thu_nhap';
            $count = TongHopThuNhap::select('users.fullname', 'date', 'nguoinhap_id', 'created_at')
                ->join('users', 'users.id', '=', 'tonghop_thunhap.nguoinhap_id')->groupBy('date')
                ->count();
            $result = TongHopThuNhap::select('users.fullname', 'date', 'nguoinhap_id', 'created_at','tonghop_thunhap.sendMail')
                ->join('users', 'users.id', '=', 'tonghop_thunhap.nguoinhap_id')
                ->groupBy('date')
                ->orderBy('date', 'DESC')
                ->get();
            $numberUser = array();
            foreach ($result as $rs):
                $numberUser[$rs['date']] =TongHopThuNhap::select('users.fullname', 'date', 'nguoinhap_id', 'created_at')
                    ->join('users', 'users.id', '=', 'tonghop_thunhap.nguoinhap_id')->groupBy('date')
                    ->where('tonghop_thunhap.date','=',$rs['date'])
                    ->groupBy('date')
                    ->count();
            endforeach;

        }

        return view(config('app.interface').'users.import_luong', compact('date', 'result', 'status', 'path','count','numberUser'));
    }

    public function chi_tiet_luong_phu_cap($date)
    {
        $lpc = LuongPhuCap::where('date', $date)->get();
        $date = date_format(new DateTime($date), 'm/Y');

        return view(config('app.interface').'users.chi_tiet_luong_phu_cap', compact('lpc', 'date'));
    }

    public function chi_tiet_tong_hop_thu_nhap($date)
    {
        $thtn = TongHopThuNhap::where('date', $date)->get();
        $date = date_format(new DateTime($date), 'm/Y');

        return view(config('app.interface').'users.chi_tiet_tong_hop_thu_nhap', compact('thtn', 'date'));
    }

    public function import_update_thu_thue(Request $request)
    {

        $date = isset($request->date) ? $request->date : date('m-Y', time());
        $file = array_get(Input::all(), 'file3');

        // SET UPLOAD PATH
        $destinationPath = 'uploads';
        // RENAME THE UPLOAD WITH RANDOM NUMBER
        $fileName = time() . '.' . 'xlsx';
        // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
        $upload_success = $file->move($destinationPath, $fileName);
        $countMaCanBoEmpty = 0;
        if ($upload_success) {
            // read file excell
            $objPHPExcel = \PHPExcel_IOFactory::load($destinationPath . '/' . $fileName);
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            // check data format
            if (!isset($allDataInSheet[4]) ||
                !isset($allDataInSheet[4]["A"]) ||
                !isset($allDataInSheet[4]["B"]) ||
                !isset($allDataInSheet[4]["C"]) ||
                !isset($allDataInSheet[4]["O"]) ||
                !isset($allDataInSheet[4]["R"]) ||
                !isset($allDataInSheet[4]["Y"]) ||
                !isset($allDataInSheet[4]["Z"]) ||

                !isset($allDataInSheet[5]["C"]) ||
                !isset($allDataInSheet[5]["D"]) ||
                !isset($allDataInSheet[5]["E"]) ||
                !isset($allDataInSheet[5]["F"]) ||
                !isset($allDataInSheet[5]["G"]) ||
                !isset($allDataInSheet[5]["H"]) ||
                !isset($allDataInSheet[5]["I"]) ||
                !isset($allDataInSheet[5]["J"]) ||
                !isset($allDataInSheet[5]["K"]) ||
                !isset($allDataInSheet[5]["L"]) ||
                !isset($allDataInSheet[5]["M"]) ||
                !isset($allDataInSheet[5]["N"]) ||
                !isset($allDataInSheet[5]["O"]) ||
                !isset($allDataInSheet[5]["P"]) ||
                !isset($allDataInSheet[5]["Q"]) ||
                !isset($allDataInSheet[5]["R"]) ||
                !isset($allDataInSheet[5]["S"]) ||
                !isset($allDataInSheet[5]["T"]) ||
                !isset($allDataInSheet[5]["U"]) ||
                !isset($allDataInSheet[5]["V"]) ||
                !isset($allDataInSheet[5]["W"]) ||
                !isset($allDataInSheet[5]["X"])

            ) {
                $error = 'File excel không đúng format!';
                return redirect()->back()->with('err',$error);
            }
            $arrayCount = count($allDataInSheet);
            for ($i = 7; $i <= $arrayCount; $i++) {
                $user = new \stdClass();
                $user->macanbo = trim($allDataInSheet[$i]["A"]);
                $user->fullname = trim($allDataInSheet[$i]["B"]);
                $user->luong_ngach_bac = trim($allDataInSheet[$i]["C"]);
                $user->luong_hop_dong = trim($allDataInSheet[$i]["D"]);
                $user->phucap_chucvu = trim($allDataInSheet[$i]["E"]);
                $user->quan_ly_phi = trim($allDataInSheet[$i]["F"]);
                $user->phucap_congtac_dang = trim($allDataInSheet[$i]["G"]);
                $user->luong_tang_them = trim($allDataInSheet[$i]["H"]);
                $user->phucap_thamnien_vuotkhung = trim($allDataInSheet[$i]["I"]);
                $user->phucap_khac = trim($allDataInSheet[$i]["J"]);
                $user->tienthuong = trim($allDataInSheet[$i]["K"]);
                $user->thunhap_tangthem = trim($allDataInSheet[$i]["L"]);
                $user->truy_linh_ltt_qlp = trim($allDataInSheet[$i]["M"]);
                $user->tong_cackhoan_tinhthue = trim($allDataInSheet[$i]["N"]);
                $user->phucap_thamnien_nghe = trim($allDataInSheet[$i]["O"]);
                $user->phucap_uudai_nghe = trim($allDataInSheet[$i]["P"]);
                $user->tongcackhoan_khongtinhthue = trim($allDataInSheet[$i]["Q"]);
                $user->baohiem_thatnghiep_truvaoluong = trim($allDataInSheet[$i]["R"]);
                $user->baohiem_xahoi_truvaoluong = trim($allDataInSheet[$i]["S"]);
                $user->baohiem_yte_truvaoluong = trim($allDataInSheet[$i]["T"]);
                $user->kinhphi_congdoan_truvaoluong = trim($allDataInSheet[$i]["U"]);
                $user->giamtru_banthan =trim($allDataInSheet[$i]["V"]);
                $user->tongtien_giamtru_nguoiphuthuoc = trim($allDataInSheet[$i]["W"]);
                $user->tong_cackhoan_giamtru = trim($allDataInSheet[$i]["X"]);
                $user->tong_thunhap_tinhthue = trim($allDataInSheet[$i]["Y"]);
                $user->thue_TNCN = trim($allDataInSheet[$i]["Z"]);
                $users[] = $user;
                $arrUserCodes[] = $user->macanbo;

                if ($user->macanbo == '') {
                    $countMaCanBoEmpty++;
                }

            }
            $total = sizeof($users) - $countMaCanBoEmpty;
            return view(config('app.interface').'users.ds_import_luong_tinh_thue', compact('total', 'users', 'countMaCanBoEmpty', 'date'));
        }
    }

    public function process_import_tong_hop_thu_nhap()
    {
        // get user import excel
        $user = session('user');
        $user = (object)$user;
        $nguoinhap_id = $user->id;

        // get params user
        $dataUser = array();
        $date = trim(Input::get('date'));
        $dataUser['macanbo'] = trim(Input::get('macanbo'));
        $dataUser['fullname'] = trim(Input::get('fullname'));
        $dataUser['luong_ngach_bac'] = str_replace(',', '',trim(Input::get('luong_ngach_bac')));
        $dataUser['luong_hop_dong'] = str_replace(',', '',trim(Input::get('luong_hop_dong')));
        $dataUser['phucap_chucvu'] = str_replace(',', '',trim(Input::get('phucap_chucvu')));
        $dataUser['quan_ly_phi'] = str_replace(',', '',trim(Input::get('quan_ly_phi')));
        $dataUser['phucap_congtac_dang'] = str_replace(',', '',trim(Input::get('phucap_congtac_dang')));
        $dataUser['luong_tang_them'] = str_replace(',', '',trim(Input::get('luong_tang_them')));
        $dataUser['phucap_thamnien_vuotkhung'] = str_replace(',', '',trim(Input::get('phucap_thamnien_vuotkhung')));
        $dataUser['phucap_khac'] = str_replace(',', '',trim(Input::get('phucap_khac')));
        $dataUser['tienthuong'] = str_replace(',', '',trim(Input::get('tienthuong')));
        $dataUser['thunhap_tangthem'] = str_replace(',', '',trim(Input::get('thunhap_tangthem')));
        $dataUser['truy_linh_ltt_qlp'] = str_replace(',', '',trim(Input::get('truy_linh_ltt_qlp')));
        $dataUser['tong_cackhoan_tinhthue'] = str_replace(',', '',trim(Input::get('tong_cackhoan_tinhthue')));
        $dataUser['phucap_thamnien_nghe'] = str_replace(',', '',trim(Input::get('phucap_thamnien_nghe')));
        $dataUser['phucap_uudai_nghe'] = str_replace(',', '',trim(Input::get('phucap_uudai_nghe')));
        $dataUser['tongcackhoan_khongtinhthue'] = str_replace(',', '',trim(Input::get('tongcackhoan_khongtinhthue')));
        $dataUser['baohiem_thatnghiep_truvaoluong'] = str_replace(',', '',trim(Input::get('baohiem_thatnghiep_truvaoluong')));
        $dataUser['baohiem_xahoi_truvaoluong'] = str_replace(',', '',trim(Input::get('baohiem_xahoi_truvaoluong')));
        $dataUser['baohiem_yte_truvaoluong'] = str_replace(',', '',trim(Input::get('baohiem_yte_truvaoluong')));
        $dataUser['kinhphi_congdoan_truvaoluong'] = str_replace(',', '',trim(Input::get('kinhphi_congdoan_truvaoluong')));
        $dataUser['giamtru_banthan'] = str_replace(',', '',trim(Input::get('giamtru_banthan')));
        $dataUser['tongtien_giamtru_nguoiphuthuoc'] = str_replace(',', '',trim(Input::get('tongtien_giamtru_nguoiphuthuoc')));
        $dataUser['tong_cackhoan_giamtru'] = str_replace(',', '',trim(Input::get('tong_cackhoan_giamtru')));
        $dataUser['chiphiphatsinhkhac'] = str_replace(',', '',trim(Input::get('chiphiphatsinhkhac')));
        $dataUser['tong_thunhap_tinhthue'] = str_replace(',', '',trim(Input::get('tong_thunhap_tinhthue')));
        $dataUser['thue_tncn'] = str_replace(',', '',trim(Input::get('thue_tncn')));


        $macanbo = $dataUser['macanbo'];
        // Convert date: 02/2019 => 02-2019
        $date_1 = str_replace('/', '/23/', $date);
        $date_2 = date_create($date_1);
        $date_3 = date_format($date_2, "m-Y");

        if ($macanbo != '' || $macanbo != null) {
            $check = DB::table('tonghop_thunhap')->where('macanbo', $macanbo)->where(DB::raw('DATE_FORMAT(date, "%m-%Y")'), $date_3)->count();
            // dd($check);die();
            $date_4 = date_format($date_2, "Y-m");

            if ($check > 0) {
                DB::table('tonghop_thunhap')
                    ->where('macanbo', $macanbo)
                    ->update(['luong_ngach_bac' => $dataUser['luong_ngach_bac'],
                        'luong_hop_dong' => $dataUser['luong_hop_dong'],
                        'phucap_chucvu' => $dataUser['phucap_chucvu'],
                        'quan_ly_phi' => $dataUser['quan_ly_phi'],
                        'phucap_congtac_dang' => $dataUser['phucap_congtac_dang'],
                        'luong_tang_them' => $dataUser['luong_tang_them'],
                        'phucap_thamnien_vuotkhung' => $dataUser['phucap_thamnien_vuotkhung'],
                        'phucap_khac' => $dataUser['phucap_khac'],
                        'tienthuong' => $dataUser['tienthuong'],
                        'thunhap_tangthem' => $dataUser['thunhap_tangthem'],
                        'truy_linh_ltt_qlp' => $dataUser['truy_linh_ltt_qlp'],
                        'tong_cackhoan_tinhthue' => $dataUser['tong_cackhoan_tinhthue'],
                        'phucap_thamnien_nghe' => $dataUser['phucap_thamnien_nghe'],
                        'phucap_uudai_nghe' => $dataUser['phucap_uudai_nghe'],
                        'tongcackhoan_khongtinhthue' => $dataUser['tongcackhoan_khongtinhthue'],
                        'baohiem_thatnghiep_truvaoluong' => $dataUser['baohiem_thatnghiep_truvaoluong'],
                        'baohiem_xahoi_truvaoluong' => $dataUser['baohiem_xahoi_truvaoluong'],
                        'baohiem_yte_truvaoluong' => $dataUser['baohiem_yte_truvaoluong'],
                        'kinhphi_congdoan_truvaoluong' => $dataUser['kinhphi_congdoan_truvaoluong'],
                        'giamtru_banthan' => $dataUser['giamtru_banthan'],
                        'tongtien_giamtru_nguoiphuthuoc' => $dataUser['tongtien_giamtru_nguoiphuthuoc'],
                        'tong_cackhoan_giamtru' => $dataUser['tong_cackhoan_giamtru'],
                        'chiphiphatsinhkhac' => $dataUser['chiphiphatsinhkhac'],
                        'tong_thunhap_tinhthue' => $dataUser['tong_thunhap_tinhthue'],
                        'thue_TNCN' => $dataUser['thue_tncn']
                    ]);

            } else {
                $thtn = new TongHopThuNhap();
                $thtn->macanbo = $dataUser['macanbo'];
                $thtn->fullname = $dataUser['fullname'];
                $thtn->luong_ngach_bac = $dataUser['luong_ngach_bac'];
                $thtn->luong_hop_dong = $dataUser['luong_hop_dong'];
                $thtn->phucap_chucvu = $dataUser['phucap_chucvu'];
                $thtn->quan_ly_phi = $dataUser['quan_ly_phi'];
                $thtn->phucap_congtac_dang = $dataUser['phucap_congtac_dang'];
                $thtn->luong_tang_them = $dataUser['luong_tang_them'];
                $thtn->phucap_thamnien_vuotkhung = $dataUser['phucap_thamnien_vuotkhung'];
                $thtn->phucap_khac = $dataUser['phucap_khac'];
                $thtn->tienthuong = $dataUser['tienthuong'];
                $thtn->thunhap_tangthem = $dataUser['thunhap_tangthem'];
                $thtn->truy_linh_ltt_qlp = $dataUser['truy_linh_ltt_qlp'];
                $thtn->tong_cackhoan_tinhthue = $dataUser['tong_cackhoan_tinhthue'];
                $thtn->phucap_thamnien_nghe = $dataUser['phucap_thamnien_nghe'];
                $thtn->phucap_uudai_nghe = $dataUser['phucap_uudai_nghe'];
                $thtn->tongcackhoan_khongtinhthue = $dataUser['tongcackhoan_khongtinhthue'];
                $thtn->baohiem_thatnghiep_truvaoluong = $dataUser['baohiem_thatnghiep_truvaoluong'];
                $thtn->baohiem_xahoi_truvaoluong = $dataUser['baohiem_xahoi_truvaoluong'];
                $thtn->baohiem_yte_truvaoluong = $dataUser['baohiem_yte_truvaoluong'];;
                $thtn->kinhphi_congdoan_truvaoluong = $dataUser['kinhphi_congdoan_truvaoluong'];
                $thtn->giamtru_banthan = $dataUser['giamtru_banthan'];
                $thtn->tongtien_giamtru_nguoiphuthuoc = $dataUser['tongtien_giamtru_nguoiphuthuoc'];
                $thtn->tong_cackhoan_giamtru = $dataUser['tong_cackhoan_giamtru'];
                $thtn->chiphiphatsinhkhac = $dataUser['chiphiphatsinhkhac'];
                $thtn->tong_thunhap_tinhthue = $dataUser['tong_thunhap_tinhthue'];
                $thtn->thue_TNCN = $dataUser['thue_tncn'];
                $thtn->date = $date_4 . '-01';
                $thtn->created_at = date('Y-m-d H:i:s');
                $thtn->nguoinhap_id = $nguoinhap_id;
                $thtn->save();
            }
        }

        // get params progressing
        $total = Input::get('total', 0);
        $index = Input::get('index', 0);
        $index++;
        // count percent
        $percent = (int)($index / $total * 100);
        return json_encode(array('error' => 0, 'next_index' => $index, 'percent' => $percent, 'total' => $total));
    }

    public function import_update_luong_phu_cap(Request $request)
    {
        $date = isset($request->date_4) ? $request->date_4 : date('m-Y', time());
        $file = array_get(Input::all(), 'file4');


        // SET UPLOAD PATH
        $destinationPath = 'uploads';
        // RENAME THE UPLOAD WITH RANDOM NUMBER
        $fileName = time() . '.' . 'xlsx';
        // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
        $upload_success = $file->move($destinationPath, $fileName);

        $countMaCanBoEmpty = 0;
        if ($upload_success) {
            // read file excell
            $objPHPExcel = \PHPExcel_IOFactory::load($destinationPath . '/' . $fileName);
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            // check data format
            if (!isset($allDataInSheet[4]) ||
                !isset($allDataInSheet[4]["A"]) ||
                !isset($allDataInSheet[4]["B"]) ||
                !isset($allDataInSheet[4]["C"]) ||
                !isset($allDataInSheet[4]["E"]) ||
                !isset($allDataInSheet[4]["F"]) ||
                !isset($allDataInSheet[4]["H"]) ||
                !isset($allDataInSheet[4]["J"]) ||
                !isset($allDataInSheet[4]["L"]) ||
                !isset($allDataInSheet[4]["N"]) ||
                !isset($allDataInSheet[4]["P"]) ||
                !isset($allDataInSheet[4]["R"]) ||
                !isset($allDataInSheet[4]["T"]) ||
                !isset($allDataInSheet[4]["V"]) ||
                !isset($allDataInSheet[4]["W"]) ||
                !isset($allDataInSheet[4]["AB"]) ||
                !isset($allDataInSheet[4]["AC"]) ||
                !isset($allDataInSheet[4]["AD"]) ||
                !isset($allDataInSheet[4]["AE"]) ||
                !isset($allDataInSheet[4]["AF"]) ||

                !isset($allDataInSheet[5]["C"]) ||
                !isset($allDataInSheet[5]["D"]) ||
                !isset($allDataInSheet[5]["F"]) ||
                !isset($allDataInSheet[5]["G"]) ||
                !isset($allDataInSheet[5]["H"]) ||
                !isset($allDataInSheet[5]["I"]) ||
                !isset($allDataInSheet[5]["J"]) ||
                !isset($allDataInSheet[5]["K"]) ||
                !isset($allDataInSheet[5]["L"]) ||
                !isset($allDataInSheet[5]["M"]) ||
                !isset($allDataInSheet[5]["N"]) ||
                !isset($allDataInSheet[5]["O"]) ||
                !isset($allDataInSheet[5]["P"]) ||
                !isset($allDataInSheet[5]["Q"]) ||
                !isset($allDataInSheet[5]["R"]) ||
                !isset($allDataInSheet[5]["S"]) ||
                !isset($allDataInSheet[5]["T"]) ||
                !isset($allDataInSheet[5]["U"]) ||
                !isset($allDataInSheet[5]["W"]) ||
                !isset($allDataInSheet[5]["X"]) ||
                !isset($allDataInSheet[5]["Y"]) ||
                !isset($allDataInSheet[5]["Z"]) ||
                !isset($allDataInSheet[5]["AA"])

            ) {
                $error = 'File excel không đúng format!';
                return redirect()->back()->with('err', $error);

            }

            $arrayCount = count($allDataInSheet);
            for ($i = 7; $i <= $arrayCount; $i++) {
                $user = new \stdClass();
                $user->macanbo = trim($allDataInSheet[$i]["A"]);
                $user->fullname = trim($allDataInSheet[$i]["B"]);
                $user->hs_luong_ngach_bac = $date1 = trim($allDataInSheet[$i]["C"]);
                $user->luong_ngach_bac =trim($allDataInSheet[$i]["D"]);
                $user->luong_hop_dong = trim($allDataInSheet[$i]["E"]);
                $user->hs_phucap_chucvu = trim($allDataInSheet[$i]["F"]);
                $user->phucap_chucvu = trim($allDataInSheet[$i]["G"]);
                $user->tyle_phucap_thamnien_vuotkhung = trim($allDataInSheet[$i]["H"]);
                $user->phucap_thamnien_vuotkhung = trim($allDataInSheet[$i]["I"]);
                $user->tyle_phucap_thamnien_nghe = trim($allDataInSheet[$i]["J"]);
                $user->phucap_thamnien_nghe = trim($allDataInSheet[$i]["K"]);
                $user->tyle_phucap_uudai_nghe = trim($allDataInSheet[$i]["L"]);
                $user->phucap_uudai_nghe = trim($allDataInSheet[$i]["M"]);
                $user->hs_phucap_khac = trim($allDataInSheet[$i]["N"]);
                $user->phucap_khac = trim($allDataInSheet[$i]["O"]);
                $user->hs_phucap_congtac_dang = trim($allDataInSheet[$i]["P"]);
                $user->phucap_congtac_dang = trim($allDataInSheet[$i]["Q"]);
                $user->hs_luong_tang_them = trim($allDataInSheet[$i]["R"]);
                $user->luong_tang_them = trim($allDataInSheet[$i]["S"]);
                $user->hs_quan_li_phi = trim($allDataInSheet[$i]["T"]);
                $user->quan_li_phi = trim($allDataInSheet[$i]["U"]);
                $user->tong_thu_nhap = trim($allDataInSheet[$i]["V"]);
                $user->khautru_BHXH = trim($allDataInSheet[$i]["W"]);
                $user->khautru_BHTN = trim($allDataInSheet[$i]["X"]);
                $user->khautru_BHYT = trim($allDataInSheet[$i]["Y"]);
                $user->khautru_KPCD = trim($allDataInSheet[$i]["Z"]);
                $user->tong_khau_tru = trim($allDataInSheet[$i]["AA"]);
                $user->thue_TNCN = trim($allDataInSheet[$i]["AB"]);
                $user->tru_tamung = trim($allDataInSheet[$i]["AC"]);
                $user->chiphiphatsinhkhac = trim($allDataInSheet[$i]["AD"]);
                $user->thuclinh = trim($allDataInSheet[$i]["AE"]);
                $user->so_taikhoan_canhan = trim($allDataInSheet[$i]["AF"]);
                $users[] = $user;
                $arrUserCodes[] = $user->macanbo;

                if ($user->macanbo == '') {
                    $countMaCanBoEmpty++;
                }

            }

            $total = sizeof($users) - $countMaCanBoEmpty;
            return view(config('app.interface').'users.ds_import_phu_cap_va_luong', compact('total', 'users', 'countMaCanBoEmpty', 'date'));
        }
    }


    public function process_import_luong_phu_cap()
    {
        //  get user import excel
        $user = session('user');
        $user = (object)$user;
        $nguoinhap_id = $user->id;

        // get params user
        $dataUser = array();
        $date = trim(Input::get('date'));
        $dataUser['macanbo'] = trim(Input::get('macanbo'));
        $dataUser['fullname'] = trim(Input::get('fullname'));
        $dataUser['hs_luong_ngach_bac'] = str_replace(',', '',trim(Input::get('hs_luong_ngach_bac')));
        $dataUser['luong_ngach_bac'] = str_replace(',', '',trim(Input::get('luong_ngach_bac')));
        $dataUser['luong_hop_dong'] = str_replace(',', '',trim(Input::get('luong_hop_dong')));
        $dataUser['hs_phucap_chucvu'] = str_replace(',', '',trim(Input::get('hs_phucap_chucvu')));
        $dataUser['phucap_chucvu'] = str_replace(',', '',trim(Input::get('phucap_chucvu')));
        $dataUser['tyle_phucap_thamnien_vuotkhung'] = str_replace(',', '',trim(Input::get('tyle_phucap_thamnien_vuotkhung')));
        $dataUser['phucap_thamnien_vuotkhung'] = str_replace(',', '',trim(Input::get('phucap_thamnien_vuotkhung')));
        $dataUser['tyle_phucap_thamnien_nghe'] = str_replace(',', '',trim(Input::get('tyle_phucap_thamnien_nghe')));
        $dataUser['phucap_thamnien_nghe'] = str_replace(',', '',trim(Input::get('phucap_thamnien_nghe')));
        $dataUser['tyle_phucap_uudai_nghe'] = str_replace(',', '',trim(Input::get('tyle_phucap_uudai_nghe')));
        $dataUser['phucap_uudai_nghe'] = str_replace(',', '',trim(Input::get('phucap_uudai_nghe')));
        $dataUser['hs_phucap_khac'] = str_replace(',', '',trim(Input::get('hs_phucap_khac')));
        $dataUser['phucap_khac'] = str_replace(',', '',trim(Input::get('phucap_khac')));
        $dataUser['hs_phucap_congtac_dang'] = str_replace(',', '',trim(Input::get('hs_phucap_congtac_dang')));
        $dataUser['phucap_congtac_dang'] = str_replace(',', '',trim(Input::get('phucap_congtac_dang')));
        $dataUser['hs_luong_tang_them'] = str_replace(',', '',trim(Input::get('hs_luong_tang_them')));
        $dataUser['luong_tang_them'] = str_replace(',', '',trim(Input::get('luong_tang_them')));
        $dataUser['hs_quan_li_phi'] = str_replace(',', '',trim(Input::get('hs_quan_li_phi')));
        $dataUser['quan_li_phi'] = str_replace(',', '',trim(Input::get('quan_li_phi')));
        $dataUser['tong_thu_nhap'] = str_replace(',', '',trim(Input::get('tong_thu_nhap')));
        $dataUser['khautru_bhxh'] = str_replace(',', '',trim(Input::get('khautru_bhxh')));
        $dataUser['khautru_bhtn'] = str_replace(',', '',trim(Input::get('khautru_bhtn')));
        $dataUser['khautru_bhyt'] = str_replace(',', '',trim(Input::get('khautru_bhyt')));
        $dataUser['khautru_kpcd'] = str_replace(',', '',trim(Input::get('khautru_kpcd')));
        $dataUser['tong_khau_tru'] = str_replace(',', '',trim(Input::get('tong_khau_tru')));
        $dataUser['thue_tncn'] = str_replace(',', '',trim(Input::get('thue_tncn')));
        $dataUser['tru_tamung'] = str_replace(',', '',trim(Input::get('tru_tamung')));
        $dataUser['chiphiphatsinhkhac'] = str_replace(',', '',trim(Input::get('chiphiphatsinhkhac')));
        $dataUser['thuclinh'] = str_replace(',', '',trim(Input::get('thuclinh')));trim(Input::get('thuclinh'));
        $dataUser['so_taikhoan_canhan'] = trim(Input::get('so_taikhoan_canhan'));


        $macanbo = $dataUser['macanbo'];
        // Convert date: 02/2019 => 02-2019
        $date_1 = str_replace('/', '/23/', $date);
        $date_2 = date_create($date_1);
        $date_3 = date_format($date_2, "m-Y");


        if ($macanbo != '' || $macanbo != null) {
            $check = DB::table('thanhtoan_luong_phucap')->where('macanbo', $macanbo)->where(DB::raw('DATE_FORMAT(date, "%m-%Y")'), $date_3)->get();
            $date_4 = date_format($date_2, "Y-m");

            if (count($check) > 0) {
                DB::table('thanhtoan_luong_phucap')
                    ->where('macanbo', $macanbo)
                    ->update(['hs_luong_ngach_bac' => $dataUser['hs_luong_ngach_bac'],
                        'luong_ngach_bac' => $dataUser['luong_ngach_bac'],
                        'luong_hop_dong' => $dataUser['luong_hop_dong'],
                        'hs_phucap_chucvu' => $dataUser['hs_phucap_chucvu'],
                        'phucap_chucvu' => $dataUser['phucap_chucvu'],
                        'tyle_phucap_thamnien_vuotkhung' => $dataUser['tyle_phucap_thamnien_vuotkhung'],
                        'phucap_thamnien_vuotkhung' => $dataUser['phucap_thamnien_vuotkhung'],
                        'tyle_phucap_thamnien_nghe' => $dataUser['tyle_phucap_thamnien_nghe'],
                        'phucap_thamnien_nghe' => $dataUser['phucap_thamnien_nghe'],
                        'tyle_phucap_uudai_nghe' => $dataUser['tyle_phucap_uudai_nghe'],
                        'phucap_uudai_nghe' => $dataUser['phucap_uudai_nghe'],
                        'hs_phucap_khac' => $dataUser['hs_phucap_khac'],
                        'phucap_khac' => $dataUser['phucap_khac'],
                        'hs_phucap_congtac_dang' => $dataUser['hs_phucap_congtac_dang'],
                        'phucap_congtac_dang' => $dataUser['phucap_congtac_dang'],
                        'hs_luong_tang_them' => $dataUser['hs_luong_tang_them'],
                        'luong_tang_them' => $dataUser['luong_tang_them'],
                        'hs_quan_li_phi' => $dataUser['hs_quan_li_phi'],
                        'quan_li_phi' => $dataUser['quan_li_phi'],
                        'tong_thu_nhap' => $dataUser['tong_thu_nhap'],
                        'khautru_BHXH' => $dataUser['khautru_bhxh'],
                        'khautru_BHTN' => $dataUser['khautru_bhtn'],
                        'khautru_BHYT' => $dataUser['khautru_bhyt'],
                        'khautru_KPCD' => $dataUser['khautru_kpcd'],
                        'tong_khau_tru' => $dataUser['tong_khau_tru'],
                        'thue_TNCN' => $dataUser['thue_tncn'],
                        'tru_tamung' => $dataUser['tru_tamung'],
                        'chiphiphatsinhkhac' => $dataUser['chiphiphatsinhkhac'],
                        'thuclinh' => $dataUser['thuclinh'],
                        'so_taikhoan_canhan' => $dataUser['so_taikhoan_canhan']
                    ]);

            } else {
                $lpc = new LuongPhuCap();
                $lpc->macanbo = $dataUser['macanbo'];
                $lpc->fullname = $dataUser['fullname'];
                $lpc->hs_luong_ngach_bac = $dataUser['hs_luong_ngach_bac'];
                $lpc->luong_ngach_bac = $dataUser['luong_ngach_bac'];
                $lpc->luong_hop_dong = $dataUser['luong_hop_dong'];
                $lpc->hs_phucap_chucvu = $dataUser['hs_phucap_chucvu'];
                $lpc->phucap_chucvu = $dataUser['phucap_chucvu'];
                $lpc->tyle_phucap_thamnien_vuotkhung = $dataUser['tyle_phucap_thamnien_vuotkhung'];
                $lpc->phucap_thamnien_vuotkhung = $dataUser['phucap_thamnien_vuotkhung'];
                $lpc->tyle_phucap_thamnien_nghe = $dataUser['tyle_phucap_thamnien_nghe'];
                $lpc->phucap_thamnien_nghe = $dataUser['phucap_thamnien_nghe'];
                $lpc->tyle_phucap_uudai_nghe = $dataUser['tyle_phucap_uudai_nghe'];
                $lpc->phucap_uudai_nghe = $dataUser['phucap_uudai_nghe'];
                $lpc->hs_phucap_khac = $dataUser['hs_phucap_khac'];
                $lpc->phucap_khac = $dataUser['phucap_khac'];
                $lpc->hs_phucap_congtac_dang = $dataUser['hs_phucap_congtac_dang'];
                $lpc->phucap_congtac_dang = $dataUser['phucap_congtac_dang'];
                $lpc->hs_luong_tang_them = $dataUser['hs_luong_tang_them'];
                $lpc->luong_tang_them = $dataUser['luong_tang_them'];
                $lpc->hs_quan_li_phi = $dataUser['hs_quan_li_phi'];
                $lpc->quan_li_phi = $dataUser['quan_li_phi'];
                $lpc->tong_thu_nhap = $dataUser['tong_thu_nhap'];
                $lpc->khautru_BHXH = $dataUser['khautru_bhxh'];
                $lpc->khautru_BHTN = $dataUser['khautru_bhtn'];
                $lpc->khautru_BHYT = $dataUser['khautru_bhyt'];
                $lpc->khautru_KPCD = $dataUser['khautru_kpcd'];
                $lpc->tong_khau_tru = $dataUser['tong_khau_tru'];
                $lpc->thue_TNCN = $dataUser['thue_tncn'];
                $lpc->tru_tamung = $dataUser['tru_tamung'];
                $lpc->chiphiphatsinhkhac = $dataUser['chiphiphatsinhkhac'];;
                $lpc->thuclinh = $dataUser['thuclinh'];;
                $lpc->so_taikhoan_canhan = $dataUser['so_taikhoan_canhan'];
                $lpc->date = $date_4 . '-01';
                $lpc->created_at = date('Y-m-d H:i:s');
                $lpc->nguoinhap_id = $nguoinhap_id;

                $lpc->save();
            }
        }

        // get params progressing
        $total = Input::get('total', 0);
        $index = Input::get('index', 0);
        $index++;
        // count percent
        $percent = (int)($index / $total * 100);
        return json_encode(array('error' => 0, 'next_index' => $index, 'percent' => $percent, 'total' => $total));
    }

    public function xem_luong_thue()
    {
        $user = Session::get('user');
        $user = (object)$user;
        $macanbo = $user->macanbo;
        $date1 = Input::get('date', date('d/Y'));
        $check = Input::get('check') ? Input::get('check') : 'luongphucap';
        $date = date('Y-m-d', strtotime(str_replace('/', '-', '01/' . $date1)));

        if ($check === 'tonghopthunhap'):
            $users = TongHopThuNhap::where(DB::raw("DATE_FORMAT(tonghop_thunhap.date,'%Y-%m-%d')"), '=', $date)
                ->where('tonghop_thunhap.macanbo', '=', $macanbo)->first();
        elseif ($check === 'luongphucap'):
            $users = ThanhToanLuongPhuCap::where(DB::raw("DATE_FORMAT(thanhtoan_luong_phucap.date,'%Y-%m-%d')"), '=', $date)
                ->where('thanhtoan_luong_phucap.macanbo', '=', $macanbo)->first();
        endif;


        return view(config('app.interface').'users.tra_cuu_luong_thue', compact('macanbo', 'date', 'check', 'users', 'date1'));
    }

    public function gui_mail_luong(Request $request)
    {
        // get ds user trong bảng
        $status = $request->status;
        $date = $request->date;
        $arr_fail = [];
        $arr_succ = [];

        if ($status === 'tonghopthunhap'):
            $luongs = TongHopThuNhap::where(DB::raw("DATE_FORMAT(tonghop_thunhap.date,'%Y-%m-%d')"), '=', $date)->get();
            TongHopThuNhap::where(DB::raw("DATE_FORMAT(tonghop_thunhap.date,'%Y-%m-%d')"), '=', $date)->update(array('sendMail' => 1));
            foreach ($luongs as $luong):
                try {
                    $data = User::select('fullname', 'email')->where('users.macanbo', '=', $luong->macanbo)->where('users.actived', '=', 1)->first();

                    if (!$data) {
                        array_push($arr_fail, [
                            'ma' => $luong->macanbo,
                            'ten' => $luong->fullname
                        ]);
                        continue;
                    }
                    array_push($arr_succ, [
                        'ma' => $luong->macanbo,
                        'ten' => $luong->fullname
                    ]);
                    $luong->email_send = $data->email ? $data->email : '';
                    $luong->type = 'tonghopthunhap';
                    $luong->title = 'Thông báo Tổng hợp thu nhập thuế tháng '.formatMY($request->date);

                    $e = new SendMaiLuong($luong->toArray());
                    $e->onQueue('tienluong');
                    $this->dispatch($e);


                } catch (Exception $exception) {

                }
            endforeach;
        elseif ($status === 'luongvaphucap'):
            $luongs = ThanhToanLuongPhuCap::where(DB::raw("DATE_FORMAT(thanhtoan_luong_phucap.date,'%Y-%m-%d')"), '=', $date)->get();
            ThanhToanLuongPhuCap::where(DB::raw("DATE_FORMAT(thanhtoan_luong_phucap.date,'%Y-%m-%d')"), '=', $date)->update(array('sendMail' => 1));

            foreach ($luongs as $luong):
                try {
                    $data = User::select('fullname', 'email')->where('users.macanbo', '=', $luong->macanbo)->where('users.actived', '=', 1)->first();
                    if (!$data) {
                        array_push($arr_fail, [
                            'ma' => $luong->macanbo,
                            'ten' => $luong->fullname
                        ]);
                        continue;
                    }
                    array_push($arr_succ, [
                        'ma' => $luong->macanbo,
                        'ten' => $luong->fullname
                    ]);
                    $luong->email_send = $data->email ? $data->email : '';
                    $luong->type = 'luongvaphucap';
                    $luong->title = 'Thông báo Lương và phụ cấp tháng '.formatMY($request->date) ;
                    $d = new SendMaiLuong($luong->toArray());
                    $d->onQueue('tienluong');
                    $this->dispatch($d);

                } catch (Exception $exception) {

                }
            endforeach;
        endif;
        die(json_encode(['error' => 0, 'success' => $arr_succ, 'fail' => $arr_fail]));


    }
    public function xoa_tai_khoan(Request $request){
        User::whereIn('id', $request->ids)->delete();

        flash('Xóa tài khoản thành công');

        return response()->json(['error' => 0]);
    }
}
