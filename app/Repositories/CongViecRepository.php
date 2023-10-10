<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Linhvucs;
use Carbon\Carbon;
use App\Models\Donvi;
use App\Models\CongViecFile;
use App\Models\CongViecMessage;
use App\Models\CongViecChiTiet;
use App\Models\CongViec_BaoCao;

class CongViecRepository
{
    public function getInfoFile($idCongViec) {
        return CongviecFile::where('congviec_id', $idCongViec);
    }

    public function messagesCongViec($idCongViec) {
        return CongViecMessage::where('congviec_id', $idCongViec);
    }

    public function getCongViecUsers($idCongViec) {
        $chiTietCongViec = CongViecChiTiet::where('congviec_id', $idCongViec)->get();
        foreach ($chiTietCongViec as $chitiet) {
            $chitiet->congviec_id = $chitiet->congviec->tencongviec;
        }

        return $chiTietCongViec;
    }

    public function congViecBaoCaoUsers ($congViecUser) {
        $array = array();
    
        foreach($congViecUser as $value) {
            $array[] = $value->id;
        }

        return CongViec_BaoCao::whereIn('congviec_user_id', $array)->get();
    }

    public function changeStatusIfEqual1And2($values) {
        foreach ($values as $value) {
            switch ($value->trangthai) {
                case 'Đang thực hiện':
                    $value->trangthai = 0;   
                    break;
                case 'Đã hoàn thành':
                    $value->trangthai = 1;   
                    break;
                case 'Tạm dừng':
                    $value->trangthai = 2;   
                    break;
                case 'Hủy bỏ': 
                    $value->trangthai = 3;
                    break;
                case 'Chưa thực hiện':
                    $value->trangthai = 0;   
                    break;
            }
            $value->trangthai = (int)($value->trangthai);
        }
    }
}
