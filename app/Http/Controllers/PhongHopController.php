<?php

namespace App\Http\Controllers;

use App\Donvi;
use App\Models\PhongHop;
use App\Models\Lichtuan;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Jobs\SendMailDangKyLichTuan;
use App\Models\User;
use App\Models\Notification;
use App\Models\WeekOfYear;
use function GuzzleHttp\Psr7\copy_to_string;

class PhongHopController extends Controller
{

    public function PhongHop()
    {
        $status = 1;
        $phonghop = PhongHop::GetDanhSachPhongHop($status)->get();
        $phonghop = PhongHop::paginate(15);
        return view(config('app.interface').'phonghop.quan_ly_phong_hop', compact('phonghop'));
    }

    public function dang_ky_lich_tuan()
    {
        $phonghopcoquan = PhongHop::getDanhSachPhongHop()->where('status', 1)->get();
        $banGD = User::select('id', 'fullname','chucdanh')->where('donvi_id', 151)->orderBy('ordering','ASC')->get();

        return view(config('app.interface').'phonghop.dang_ky_lich_tuan', compact('phonghopcoquan', 'banGD'));
    }

    public function edit_dang_ky_lich_tuan($lichtuanId)
    {
        $banGD = User::select('id', 'fullname','chucdanh')->where('donvi_id', 151)->orderBy('ordering','ASC')->get();
        $lichtuan = Lichtuan::find($lichtuanId);
        if (!$lichtuan) {
            flash('Lịch tuần không tồn tại');
            return redirect(route('phonghop.danhsachdangkylichtuan'));
        }

        $loggedUser = (object)session('user');
        if (!$loggedUser->duyetlichtuan && $loggedUser->id != $lichtuan->created_by) {
            flash('Tài khoản này không có quyền sửa lịch tuần');
            return redirect(route('phonghop.danhsachdangkylichtuan'));
        }

        $phonghopcoquan = PhongHop::getDanhSachPhongHop()->where('status', 1)->get();
        return view(config('app.interface').'phonghop.edit_lich_tuan', compact('lichtuan', 'phonghopcoquan', 'banGD'));
    }

    public function ThemPhongHop(Request $request)
    {
        $phonghop = new PhongHop;
        $phonghop->tenphonghop = $request->tenphonghop;
        $phonghop->diadiem = $request->diadiem;
        $phonghop->succhua = $request->succhua;
        $phonghop->dientich = $request->dientich;
        $phonghop->thietbi = $request->thietbi;
        $phonghop->sothutu = $request->sothutu;
        $phonghop->status = 1;
        $phonghop->save();
        return back();
    }

    public function suaPhongHop($idPhongHop)
    {
        $phonghop = PhongHop::find($idPhongHop);
        if (!$phonghop) {
            flash('Phòng họp không tồn tại');
            return redirect(route('phonghop.danhsachphonghop'));
        }

        return view(config('app.interface').'phonghop.edit_phong_hop', compact('phonghop', 'idPhongHop'));
    }

    public function cap_nhat_phong_hop(Request $request)
    {
        $phonghop = PhongHop::GetDanhSachPhongHop(1)->get();
        $phonghop = PhongHop::paginate(15);
        PhongHop::where('id', $request->id)->update(array('tenphonghop' => $request->tenphonghop, 'diadiem' => $request->diadiem, 'succhua' => $request->succhua, 'dientich' => $request->dientich, 'thietbi' => $request->thietbi, 'sothutu' => $request->sothutu));
        return redirect(route('phonghop.danhsachphonghop'));
    }

    public function save_dang_ky_lich_tuan(Request $request)
    {
        $loggedUser = (object)session('user');

        $isCreateNew = true;
        if (isset($request->id)) {
            $dangky = Lichtuan::find($request->id);
            if (!$dangky) {
                flash('Lịch tuần không tồn tại');
                return redirect()->back();
            }

            if (!$loggedUser->duyetlichtuan && $loggedUser->id != $dangky->created_by) {
                flash('Tài khoản này không có quyền sửa lịch tuần');
                return redirect(route('phonghop.danhsachdangkylichtuan'));
            }

            $dangky->nguoisua_id = $loggedUser->id;
            $dangky->thoigiansua = date('Y-m-d H:i:s');

            $isCreateNew = false;
        } else {

            $dangky = new Lichtuan();
            $dangky->created_by = session('user')['id'];
        }
        $request->time = $request->time . " ".$request->time_gio;
        // save lịch tuần
        $dangky->nguoidangky = $request->nguoidangky;
        $dangky->donvi = $request->donvi;
        $dangky->sodienthoai = $request->sodienthoai;
        $dangky->email = $request->email;
        $dangky->noidung = $request->noidung;
        $dangky->type = $request->type;
        $dangky->time = date('Y-m-d H:i', strtotime($request->time));
        $dangky->chutri = isset($request->chutri) ? $request->chutri : null;
        $dangky->songuoithamgia = $request->songuoithamgia;
        $dangky->thanhphan = $request->thanhphan;
        $dangky->chutriId = (isset($request->chutriId) && $request->chutriId == 'khac') ? null : $request->chutriId;
        $dangky->phonghop_id = ($request->phonghop_id == 'other') ? null : $request->phonghop_id;
        $dangky->diadiem = isset($request->diadiem) ? $request->diadiem : null;


        if ($dangky->save()) {
            if ($isCreateNew) {
                // Insert notifications
                {
                    $arrInsertNotifications = []; // array store notification data
                    $userDuyetIds = User::getListDuyetDangKyLichTuan()->pluck('id')->toArray();

                    foreach ($userDuyetIds as $userId) {
                        // save notification data
                        $arrInsertNotifications[] = [
                            'creator_id' => session('user')['id'],
                            'receivor_id' => $userId,
                            'type' => Notification::$types['nhandangkylichtuan'],
                            'content' => 'Bạn nhận được một đăng ký lịch tuần',
                            'notificationable_id' => $dangky->id,
                            'notificationable_type' => Lichtuan::class,
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                    }

                    if ($arrInsertNotifications) {
                        Notification::insert($arrInsertNotifications);
                    }
                }

                // send mail
                $dataMail = (object)$request->all();

                if (isset($request->phonghop_id) && $request->phonghop_id != 'other') {
                    $phonghop = PhongHop::find($dataMail->phonghop_id);
                    $dataMail->tenphong = $phonghop->tenphonghop;
                } else {
                    $dataMail->tenphong = $request->diadiem;
                }

                $this->dispatch(new SendMailDangKyLichTuan($dataMail));

                flash('Đăng ký lịch tuần thành công');
            } else {
                flash('Sửa lịch tuần thành công');
            }
        } else {
            flash('Đăng ký lịch tuần thất bại');
        }

        return redirect(route('phonghop.danhsachdangkylichtuan'));
    }

    public function list_dang_ky_lich_tuan()
    {

        $date = Input::get('date', date('Y-m-d'));
        // get params
        $user = (object)session('user');
        $type = Input::get('type', '');
        $status = Input::get('status', '');

        $phpdate = new DateTime($date);
        $firstDateInWeek = clone $phpdate;
        $firstDateInWeek->modify('Monday this week');

        $lastDateInWeek = clone $phpdate;
        $lastDateInWeek->modify('Sunday');

        $weekInYear =$phpdate->format('W');

        $trungLich = Input::get('trung_lich', '');
        $exportWord = Input::get('export_word');
        $dataWeekOfYear = WeekOfYear::where('status', 1)->first();

        if ($type === '' || $type == Lichtuan::$type['lichtuandaihocdn']) {
            $dataDHDN = Lichtuan::getDanhSach([
                'user_id' => ($user->duyetlichtuan == 1) ? '' : $user->id,
                'type' => Lichtuan::$type['lichtuandaihocdn'],
                'status' => $status,
                'from_date' => $firstDateInWeek->format('Y-m-d'),
                'to_date' =>$lastDateInWeek->format('Y-m-d'),
                'exportWord' => $exportWord
            ])
                ->get()
                ->keyBy('id');

            // kiểm tra trùng lịch (phòng - ngày - giờ)
            {
                $dataCheck = [];
                foreach ($dataDHDN as $val) {
                    $keyCheck = $val->phonghop_id . '-' . date('Y-m-d H', strtotime($val->time));
                    if (!isset($dataCheck[$keyCheck])) {
                        $dataCheck[$keyCheck] = [];
                    }

                    $dataCheck[$keyCheck][] = $val->id;
                }

                foreach ($dataCheck as $val) {
                    if (sizeof($val) > 1) {
                        foreach ($val as $idLichTuan) {
                            $dataDHDN[$idLichTuan]->trung_lich = 1;
                        }
                    }
                }

                if ($trungLich) {
                    foreach ($dataDHDN as $key => $val) {
                        if (!$dataDHDN[$key]->trung_lich) {
                            unset($dataDHDN[$key]);
                        }
                    }
                }
            }
        }

        if ($type === '' || $type == Lichtuan::$type['lichtuancoquan']) {
            $dataCoquan = Lichtuan::getDanhSach([
                'user_id' => ($user->duyetlichtuan == 1) ? '' : $user->id,
                'type' => Lichtuan::$type['lichtuancoquan'],
                'status' => $status,
                'from_date' => $firstDateInWeek->format('Y-m-d'),
                'to_date' => $lastDateInWeek->format('Y-m-d'),
                'exportWord' => $exportWord
            ])
                ->get()
                ->keyBy('id');

            // kiểm tra trùng lịch (phòng - ngày - giờ)
            {
                $dataCheck = [];
                foreach ($dataCoquan as $val) {
                    $keyCheck = $val->phonghop_id . '-' . date('Y-m-d H', strtotime($val->time));
                    if (!isset($dataCheck[$keyCheck])) {
                        $dataCheck[$keyCheck] = [];
                    }

                    $dataCheck[$keyCheck][] = $val->id;
                }

                foreach ($dataCheck as $val) {
                    if (sizeof($val) > 1) {
                        foreach ($val as $idLichTuan) {
                            $dataCoquan[$idLichTuan]->trung_lich = 1;
                        }
                    }
                }

                if ($trungLich) {
                    foreach ($dataCoquan as $key => $val) {
                        if (!$dataCoquan[$key]->trung_lich) {
                            unset($dataCoquan[$key]);
                        }
                    }
                }
            }
        }

        if ($exportWord) {
            // group lại theo ngày
            $newDataCoquan = [];
            foreach ($dataCoquan as $val) {
                if (!isset($newDataCoquan[$val->ngay_export])) {
                    $newDataCoquan[$val->ngay_export] = [];
                }
                $newDataCoquan[$val->ngay_export][] = $val;
            }
            $dataCoquan = $newDataCoquan;

            $newDataDHDN = [];
            foreach ($dataDHDN as $val) {
                if (!isset($newDataDHDN[$val->ngay_export])) {
                    $newDataDHDN[$val->ngay_export] = [];
                }
                $newDataDHDN[$val->ngay_export][] = $val;
            }
            $dataDHDN = $newDataDHDN;

            return view(config('app.interface').'phonghop.danh_sach_dang_ky_lich_tuan_word', compact('dataDHDN', 'dataCoquan', 'weekInYear', 'firstDateInWeek', 'lastDateInWeek', 'type','dataWeekOfYear'));
        } else {
            return view(config('app.interface').'phonghop.danh_sach_dang_ky_lich_tuan', compact('dataDHDN', 'dataCoquan', 'weekInYear', 'dataWeekOfYear', 'firstDateInWeek', 'lastDateInWeek'));
        }
    }

    public function approve_dang_ky_lich_tuan()
    {
        // get params
        $id = Input::get('id');
        $status = Input::get('status');
        $lichtuan = Lichtuan::find($id);

        // duyệt đặt phòng
        $lichtuan->status = $status;
        if ($lichtuan->save()) {
            flash('Duyệt lịch tuần thành công');

            // Insert notifications
            Notification::insert([
                'creator_id' => session('user')['id'],
                'receivor_id' => $lichtuan->created_by,
                'type' => ($status == Lichtuan::$status['daduyet']) ? Notification::$types['dangkylichtuandaduocduyet'] : Notification::$types['dangkylichtuandabituchoi'],
                'content' => ($status == Lichtuan::$status['daduyet']) ? 'Đăng ký lịch tuần của bạn đã được duyệt' : 'Đăng ký lịch tuần của bạn đã bị từ chối',
                'notificationable_id' => $lichtuan->id,
                'notificationable_type' => Lichtuan::class,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            flash('Duyệt lịch tuần thất bại');
        }

        die(json_encode(['error' => 0]));
    }
    public function thuhoilichtuan(){
            // $lichtuanId->delete();
            // return redirect('dang_ky_lich_tuan');
            $id = Input::get('id');

            // VanbanXuLy::where('vanbanUser_id', $id)->delete();
            Lichtuan::where('id', $id)->delete();
    
            die(json_encode(['error' => 0]));
    }
}
