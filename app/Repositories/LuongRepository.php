<?php

namespace App\Repositories;

use App\Models\TongHopThuNhap;
use App\Models\ThanhToanLuongPhuCap;
use DB;


class LuongRepository
{
    public function getluongByMaCanBoAndDate($macanbo, $date) {
        $luong = ThanhToanLuongPhuCap::where(DB::raw("DATE_FORMAT(thanhtoan_luong_phucap.date,'%Y-%m')"), '=', $date)
        ->where('thanhtoan_luong_phucap.macanbo', '=', $macanbo)->first();

        return $luong;
    }

    public function getThueByMaCanBoAndDate($macanbo, $date) {
        $thue = TongHopThuNhap::where(DB::raw("DATE_FORMAT(tonghop_thunhap.date,'%Y-%m')"), '=', $date)
                ->where('tonghop_thunhap.macanbo', '=', $macanbo)->first();

        return $thue;
    }

    public function changeNumberFormatValue($value) {
        if ($value != null) {
            $value->hs_luong_ngach_bac      = (string) $value->hs_luong_ngach_bac;
            $value->hs_phucap_chucvu        = (string) $value->hs_luong_ngach_bac;
            $value->hs_phucap_khac          = (string) $value->hs_phucap_khac;
            $value->hs_phucap_congtac_dang  = (string) $value->hs_phucap_congtac_dang;
            $value->hs_quan_li_phi          = (string) $value->hs_quan_li_phi;
            $value->hs_phucap_chucvu        = (string) $value->hs_luong_ngach_bac;
            $value->hs_phucap_chucvu        = (string) $value->hs_luong_ngach_bac;
            $value->hs_phucap_chucvu        = (string) $value->hs_luong_ngach_bac;
        }
    }
}
