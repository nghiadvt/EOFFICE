<?php

namespace App\Http\Controllers;

use App\Models\Donvi;
use App\Models\TrackWorkProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class progressManageController extends Controller
{
    function danhsachTienDoCV(Request $request){
        $loggedUser = (object)session('user');
        $donvi_id = $request->donvi_id;
        $tiendo = $request->tiendo;
        $exportWord = $request->export_word;
        $exportExcel = $request->export_excel;
        $start_time = date('Y-m-01');
        $selected_nam = date('Y');

        $selected_quy = select_Quy_Nam();
        if ($request->quy){
            $selected_quy = $request->quy;
        }
        $loai = 'thang';
        if ($request->chon_loai == 'quy'){
            $loai = 'quy';
        }
        if ($request->nam){
            $selected_nam = $request->nam;
        }
        if ($request->start_time){
            $day = '01-' .$request->start_time;
            $start_time = formatYMD($day);
        }
        $quy = $selected_nam . $selected_quy;
        $query = TrackWorkProgress::query();
        if ($loggedUser->donvi_id != 136){
            $donvi_id = $loggedUser->donvi_id;
            $query->where('donvichutri', $loggedUser->donvi_id);
        }
        if ($donvi_id){
            $query->where('donvichutri', $donvi_id);
        }
        if ($tiendo != ''){
            $query->where('status', $tiendo);
        }
        if ($exportWord || $exportExcel){
            if ($loggedUser->donvi_id == 136){
                $query->where('loai_bo', 0);
            }
        }
        $donvichutris = $query->select('trackworkprogress.donvichutri', 'donvis.name')
            ->join('donvis', 'donvis.id', '=', 'trackworkprogress.donvichutri')
            ->when($loai == 'thang', function ($query) use ($start_time) {
                return $query->where('trackworkprogress.thang', '<=', $start_time);
            })
            ->when($loai == 'quy', function ($query) use ($quy) {
                return $query->where('trackworkprogress.quy', '<=', $quy);
            })
            ->where('delete', null)
            ->where('donvis.parent_id', 1)
            ->groupBy('donvichutri')
            ->orderBy('donvis.order', 'ASC')
            ->paginate(15)
            ->appends(Input::except('page'));

        $datas = [];
        foreach ($donvichutris as $donvichutri){
            $querys = TrackWorkProgress::query();
            $queryss = TrackWorkProgress::query();
            if ($donvi_id){
                $querys->where('donvichutri', $donvi_id);
            }
            if ($tiendo != ''){
                $querys->where('status', $tiendo);
            }
            if ($exportWord || $exportExcel){
                if ($loggedUser->donvi_id == 136){
                    $querys->where('loai_bo', 0);
                }
            }
            if ($loggedUser->donvi_id != 136){
                $donvi_id = $loggedUser->donvi_id;
                $querys->where('donvichutri', $loggedUser->donvi_id);
            }
            if ($loggedUser->donvi_id != 136){
                $donvi_id = $loggedUser->donvi_id;
                $queryss->where('donvichutri', $loggedUser->donvi_id);
            }
            $data = $querys->where('donvichutri', $donvichutri->donvichutri)
                ->where('delete', null)
                ->when($loai == 'thang', function ($querys) use ($start_time) {
                    return $querys->where('trackworkprogress.thang', '<=', $start_time);
                })
                ->when($loai == 'quy', function ($querys) use ($quy) {
                    return $querys->where('trackworkprogress.quy', '<=', $quy);
                })
                ->limit(100)->offset(0)->get();
            $count_done = 0;
            if ($tiendo == '' || $tiendo == 2){
                $count_done = $queryss->where('donvichutri', $donvichutri->donvichutri)
                    ->where('delete', null)
                    ->when($loai == 'thang', function ($queryss) use ($start_time) {
                        return $queryss->where('trackworkprogress.thang', '<', $start_time)->where('trackworkprogress.status', '=', 2);
                    })
                    ->when($loai == 'quy', function ($queryss) use ($quy) {
                        return $queryss->where('trackworkprogress.quy', '<', $quy)->where('trackworkprogress.status', '=', 2);
                    })->count();
            }
            $donvichutri['count_done'] = $count_done;
            $donvichutri['count_all'] = count($data);
            $donvichutri['array'] = $data;
            $datas[] = $donvichutri;
        }
        $donvis = Donvi::where('donvis.actived',1)
            ->where('donvis.id', '!=', 151)
            ->where('donvis.parent_id', '=', 1)
            ->orderBy('order', 'ASC')
            ->get(['donvis.id', 'donvis.name']);
        if ($exportWord){
            return view(config('app.interface').'quanlytiendo.quan_ly_tien_do_word', compact('datas' ,'donvichutris', 'donvis', 'donvi_id', 'start_time', 'tiendo', 'selected_quy', 'selected_nam', 'loai'));
        }elseif($exportExcel){
            return view(config('app.interface').'quanlytiendo.quan_ly_tien_do_excel', compact('datas' ,'donvichutris', 'donvis', 'donvi_id', 'start_time', 'tiendo', 'selected_quy', 'selected_nam', 'loai'));
        }else{
            return view(config('app.interface').'quanlytiendo.bang_theo_doi_cong_viec', compact('datas' ,'donvichutris', 'donvis', 'donvi_id', 'start_time', 'tiendo', 'selected_quy', 'selected_nam', 'loai'));
        }
    }

    function import_update_bang_theo_doi_tien_do_cong_viec(Request $request){
        $loggedUser = (object)session('user');
        $date = '01-' . $request->date;
        $date_2 = formatYMD($date);
        $quy = $request->import_nam . $request->import_quy;
        $donviId = $request->import_donvi;
        $file = array_get(Input::all(), 'file');
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
            if (!isset($allDataInSheet[3]) ||
                !isset($allDataInSheet[3]["A"]) ||
                !isset($allDataInSheet[3]["B"]) ||
                !isset($allDataInSheet[3]["C"]) ||
                !isset($allDataInSheet[3]["D"])

            ) {
                $error = 'File excel không đúng format!';
                return redirect()->back()->with('err',$error);

            }
            $arrayCount = count($allDataInSheet);
            for ($i = 4; $i <= $arrayCount; $i++) {
                $trangthai = $this->classifyEvaluateDK($allDataInSheet[$i]["C"]);
                $progress = new \stdClass();
                if (trim($allDataInSheet[$i]["A"])){
                    $progress->content = trim($allDataInSheet[$i]["A"]);
                    $progress->note = trim($allDataInSheet[$i]["B"]);
                    $progress->status = $trangthai;
                    $progress->minhchung = trim($allDataInSheet[$i]["D"]);
                    $progress->donvichutri = $donviId ? $donviId : $loggedUser->donvi_id;
                    $progress->thang = $date_2;
                    $progress->loai = $request->import_loai;
                    $progress->quy = $quy;
                    $progress->user_nhap = $loggedUser->id;
                    $trackworkprogress[] = $progress;
                    $arrUserCodes[] = $progress->content;
                }

                if ($progress->content == '') {
                    $countMaCanBoEmpty++;
                }

            }
            $total = sizeof($trackworkprogress) - $countMaCanBoEmpty;
            return view(config('app.interface').'quanlytiendo.ds_import_bang_theo_doi_tien_do', compact('total', 'trackworkprogress', 'countMaCanBoEmpty'));
        }
    }

    function classifyEvaluateDK($val)
    {
        $stripUnicode = stripUnicode($val);
        if ($stripUnicode == stripUnicode('Hoàn thành')) return 2;
        elseif ($stripUnicode == stripUnicode('Đang')) return 1;
        elseif ($stripUnicode == stripUnicode('Chưa')) return 0;
        else return 3;
    }

    function process_import_ds_tiendo(){
        $user = session('user');
        $user = (object)$user;

        // get params progress
        $dataProgress = array();
        $dataProgress['donvichutri'] = trim(Input::get('donvichutri'));
        $dataProgress['content'] = trim(Input::get('content'));
        $dataProgress['note'] = trim(Input::get('note'));
        $dataProgress['status'] = trim(Input::get('status'));
        $dataProgress['minhchung'] = trim(Input::get('minhchung'));
        $dataProgress['thang'] = trim(Input::get('thang'));
        $dataProgress['quy'] = trim(Input::get('quy'));
        $dataProgress['loai'] = trim(Input::get('loai'));
        $dataProgress['user_nhap'] = trim(Input::get('user_nhap'));

        $twp = new TrackWorkProgress();
        $twp->donvichutri = $dataProgress['donvichutri'];
        $twp->content = $dataProgress['content'];
        $twp->note = $dataProgress['note'];
        $twp->status = $dataProgress['status'];
        $twp->minhchung = $dataProgress['minhchung'];
        if ($dataProgress['loai'] == 'quy'){
            $twp->quy = $dataProgress['quy'];
        }else{
            $twp->thang = $dataProgress['thang'];
        }
        $twp->user_nhap = $dataProgress['user_nhap'];
        $twp->save();

        // get params progressing
        $total = Input::get('total', 0);
        $index = Input::get('index', 0);
        $index++;
        // count percent
        $percent = (int)($index / $total * 100);
        return json_encode(array('error' => 0, 'next_index' => $index, 'percent' => $percent, 'total' => $total));
    }

    function edit_quan_ly_tien_do($tientoId){

        $tiendo = TrackWorkProgress::find($tientoId);
        $donvi_id = $tiendo->donvichutri;
        $donvis = Donvi::where('donvis.actived',1)
            ->where('donvis.id', '!=', 151)
            ->where('donvis.parent_id', '=', 1)
            ->orderBy('order', 'ASC')
            ->get(['donvis.id', 'donvis.name']);

        return view(config('app.interface').'quanlytiendo.edit_tien_do', compact('tiendo', 'donvis', 'donvi_id'));
    }

    function save_cap_nhat_tien_do(Request $request){
        $loggedUser = (object)session('user');
        $tiendo = TrackWorkProgress::find($request->id);
        if (!$tiendo) {
            flash('Tiến độ công việc không tồn tại');
            return redirect()->back();
        }
        if ($loggedUser->id != $tiendo->user_nhap){
            flash('Bạn Không có quyền chỉnh sửa tiến độ công việc này');
            return redirect()->back();
        }
        $request->donvichutri ? $tiendo->donvichutri = $request->donvichutri : '';
        $tiendo->content = $request->noidung;
        $tiendo->note = $request->note;
        $tiendo->minhchung = $request->minhchung;
        $tiendo->save();
        flash('Chỉnh sửa tiến độ công việc thành công');
        return redirect(route('quanlytiendo.danhsach'));
    }

    function xoa_tien_do(){
        $loggedUser = (object)session('user');
        $id = Input::get('id');
        $tiendo = TrackWorkProgress::find($id);
        if (!$tiendo) {
            die(json_encode(['error' => 1, 'message' => 'Tiến độ công việc không tồn tại']));
        }
        if ($loggedUser->id != $tiendo->user_nhap){
            die(json_encode(['error' => 1, 'message' => 'Bạn Không có quyền xóa tiến độ công việc này']));
        }
        $tiendo->delete = date('Y-m-d H:i:s');
        $tiendo->save();
        die(json_encode(['error' => 0]));
    }

    function loai_bo_tien_do(){
        $loggedUser = (object)session('user');
        $id = Input::get('id');
        $status = Input::get('status');
        $tiendo = TrackWorkProgress::find($id);
        if (!$tiendo) {
            die(json_encode(['error' => 1, 'message' => 'Tiến độ công việc không tồn tại']));
        }
        if ($loggedUser->id != 112){
            die(json_encode(['error' => 1, 'message' => 'Bạn Không có quyền loại bỏ tiến độ công việc này']));
        }
        $tiendo->loai_bo = $status == 0 ? 1 : 0;
        $tiendo->save();
        die(json_encode(['error' => 0]));
    }

    function cap_nhat_trang_thai(){
        $loggedUser = (object)session('user');
        $id = Input::get('id');
        $status = Input::get('status');
        $minhchung = Input::get('minhchung');
        $tiendo = TrackWorkProgress::find($id);
        if (!$tiendo){
            die(json_encode(['error' => 1, 'message' => 'Tiến độ công việc không tồn tại']));
        }
        if ($loggedUser->id != $tiendo->user_nhap){
            die(json_encode(['error' => 1, 'message' => 'Bạn Không có quyền thay đổi trạng thái tiến độ công việc này']));
        }

        $tiendo->status = $status;
        $tiendo->minhchung = $minhchung;
        $tiendo->save();
        die(json_encode(['error' => 0]));
    }

    function them_moi_tien_do_cong_viec(){
        $donvis = Donvi::where('donvis.actived',1)
            ->where('donvis.id', '!=', 151)
            ->where('donvis.parent_id', '=', 1)
            ->orderBy('order', 'ASC')
            ->get(['donvis.id', 'donvis.name']);

        return view(config('app.interface').'quanlytiendo.them_moi_tien_do', compact('donvis'));
    }

    function luu_them_moi_tien_do_cong_viec(Request $request){
           $messages = [
            'noidung.required' => 'Hãy nhập nội dung',
            'note.required' => 'Hãy nhập căn cứ',
            'tiendo.required' => 'Hãy chọn tiến độ',
            'minhchung.required' => 'Hãy nhập minh chứng',
            'date.required' => 'Hãy chọn tháng',
        ];
        $this->validate($request, [
            'noidung' => 'required',
            'note' => 'required',
            'tiendo' => 'required',
            'minhchung' => 'required',
            'date' => 'required',
        ],$messages);

        $loggedUser = (object)session('user');
        $date = '01-' . $request->date;
        $date_2 = formatYMD($date);
        $thoihan = formatYMD($request->thoihan);
        $quy = $request->quy;
        $nam = $request->nam;
        $tiendo = new TrackWorkProgress();
        $tiendo->donvichutri = $request->donvichutri ? $request->donvichutri : $loggedUser->donvi_id;
        $tiendo->content = $request->noidung;
        $tiendo->note = $request->note;
        $tiendo->status = $request->tiendo;
        $tiendo->minhchung = $request->minhchung;
        $tiendo->thoi_han = $thoihan;
        $tiendo->user_nhap = $loggedUser->id;
        if ($request->loai == 'quy'){
            $tiendo->quy = $nam.$quy;
        }else{
            $tiendo->thang = $date_2;
        }
        $tiendo->save();
        flash('Thêm mới tiến độ công việc thành công');
        return redirect(route('quanlytiendo.danhsach'));
    }

    function thongke_tiendo(Request $request){
        $loggedUser = (object)session('user');
        $donvi_id = $request->donvi_id;
        $tiendo = $request->tiendo;
        $exportWord = $request->export_word;
        $start_time = date('Y-m-01');
        $selected_nam = date('Y');
        $selected_quy = select_Quy_Nam();
        $loai = 'thang';

        if ($request->quy){
            $selected_quy = $request->quy;
        }
        if ($request->chon_loai == 'quy'){
            $loai = 'quy';
        }
        if ($request->nam){
            $selected_nam = $request->nam;
        }
        if ($request->start_time){
            $day = '01-' .$request->start_time;
            $start_time = formatYMD($day);
        }
        $quy = $selected_nam . $selected_quy;
        $query = TrackWorkProgress::query();
        if ($donvi_id){
            $query->where('donvichutri', $donvi_id);
        }

        if ($loai == 'thang'){
            $datas = $query->select(
            'trackworkprogress.donvichutri',
                    'donvis.name',
                    DB::raw('
                        COUNT(CASE WHEN trackworkprogress.`status` = 0 AND trackworkprogress.`thang` <= "'.$start_time.'"  THEN 1 END) chualam
                    '),
                    DB::raw('
                        COUNT(CASE WHEN trackworkprogress.`status` = 1 AND trackworkprogress.`thang` <= "'.$start_time.'"  THEN 1 END) danglam
                    '),
                    DB::raw('
                        COUNT(CASE WHEN trackworkprogress.`status` = 2 AND trackworkprogress.`thang` = "'.$start_time.'"  THEN 1 END) hoanthanh
                    '),
                    DB::raw('
                        COUNT(CASE WHEN trackworkprogress.`status` = 3 AND trackworkprogress.`thang` <= "'.$start_time.'" THEN 1 END) tamhoan
                    ')
                )
                ->join('donvis', 'donvis.id', '=', 'trackworkprogress.donvichutri')
                ->where('delete', null)
                ->where('donvis.parent_id', 1)
                ->groupBy('donvichutri')
                ->orderBy('donvis.order', 'ASC')
                ->paginate(15)
                ->appends(Input::except('page'));
        }else{
            $datas = $query->select(
                'trackworkprogress.donvichutri',
                'donvis.name',
                DB::raw('
                        COUNT(CASE WHEN trackworkprogress.`status` = 0 AND trackworkprogress.`quy` <= "'.$quy.'"  THEN 1 END) chualam
                    '),
                DB::raw('
                        COUNT(CASE WHEN trackworkprogress.`status` = 1 AND trackworkprogress.`quy` <= "'.$quy.'"  THEN 1 END) danglam
                    '),
                DB::raw('
                        COUNT(CASE WHEN trackworkprogress.`status` = 2 AND trackworkprogress.`quy` = "'.$quy.'"  THEN 1 END) hoanthanh
                    '),
                DB::raw('
                        COUNT(CASE WHEN trackworkprogress.`status` = 3 AND trackworkprogress.`quy` <= "'.$quy.'" THEN 1 END) tamhoan
                    ')
            )
                ->join('donvis', 'donvis.id', '=', 'trackworkprogress.donvichutri')
                ->where('delete', null)
                ->where('donvis.parent_id', 1)
                ->groupBy('donvichutri')
                ->orderBy('donvis.order', 'ASC')
                ->paginate(30)
                ->appends(Input::except('page'));
        }
        $donvis = Donvi::where('donvis.actived',1)
            ->where('donvis.id', '!=', 151)
            ->where('donvis.parent_id', '=', 1)
            ->orderBy('order', 'ASC')
            ->get(['donvis.id', 'donvis.name']);

        if ($exportWord){
            return view(config('app.interface').'quanlytiendo.thong_ke_tien_do_word', compact('tiendo', 'loai', 'selected_nam', 'start_time', 'selected_quy', 'donvis', 'donvi_id', 'datas'));
        }else{
            return view(config('app.interface').'quanlytiendo.thong_ke_tien_do', compact('tiendo', 'loai', 'selected_nam', 'start_time', 'selected_quy', 'donvis', 'donvi_id', 'datas'));
        }
    }
}
