<?php


namespace App\Http\Controllers;

use App\Models\Lichtuan;
use Illuminate\Support\Facades\Input;
use DateTime;
use App\Models\WeekOfYear;

class ApiController extends Controller
{
    public function GetLichTuan()
    {
        $date = Input::get('date', date('Y-m-d'));
        $firstDateInWeek = date("Y-m-d", strtotime('sunday last week', strtotime($date)));
        $lastDateInWeek = date("Y-m-d", strtotime('saturday this week', strtotime($date)));
        $data = Lichtuan::getDanhSach([
            'status' => 1,
            'from_date' => $firstDateInWeek,
            'to_date' => $lastDateInWeek
        ])->get()->keyBy('id');

        $result = [];
        foreach ($data as $item) {
            array_push($result, [
                'Id' => $item->id,
                'Date' => $item->time,
                'Content' => $item->noidung,
                'Components' => $item->thanhphan,
                'Address' => $item->diadiem,
                'MainChain' => $item->chutri,
                'ObjectType' => $item->type
            ]);
        }

        return response(json_encode($result), 200)
            ->header('Content-Type', 'json/application');
    }

    public function getLichNgayByUser()
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

        $weekInYear = $phpdate->format('W');

        $trungLich = Input::get('trung_lich', '');
        $exportWord = Input::get('export_word');
        $dataWeekOfYear = WeekOfYear::where('status', 1)->first();

        if ($type === '' || $type == Lichtuan::$type['lichtuandaihocdn']) {
            $dataDHDN = Lichtuan::getDanhSach([
                'user_id' => ($user->duyetlichtuan == 1) ? '' : $user->id,
                'type' => Lichtuan::$type['lichtuandaihocdn'],
                'status' => $status,
                'time' => $phpdate->format('Y-m-d'),
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

                foreach ($dataDHDN as $val) {
                    $val->time = new DateTime($val->time);
                }
            }
        }
        
        if ($type === '' || $type == Lichtuan::$type['lichtuancoquan']) {
            $dataCoquan = Lichtuan::getDanhSach([
                'user_id' => ($user->duyetlichtuan == 1) ? '' : $user->id,
                'type' => Lichtuan::$type['lichtuancoquan'],
                'status' => $status,
                'time' => $phpdate->format('Y-m-d'),
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

                foreach ($dataCoquan as $val) {
                    $val->time = new DateTime($val->time);
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

            return view(config('app.interface') . 'templates._weekschedule_content', compact('dataDHDN', 'dataCoquan', 'weekInYear', 'firstDateInWeek', 'lastDateInWeek', 'type', 'dataWeekOfYear'));
        } else {
            return view(config('app.interface') . 'templates._weekschedule_content', compact('dataDHDN', 'dataCoquan', 'weekInYear', 'dataWeekOfYear', 'firstDateInWeek', 'lastDateInWeek'));
        }
    }
}
