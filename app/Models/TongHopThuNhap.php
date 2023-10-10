<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TongHopThuNhap extends Model
{
    protected $table= 'tonghop_thunhap';
    protected $fillable = [
        'user_id',
        'macanbo',
        'fullname',
        'luong_ngach_bac',
        'luong_hop_dong',
        'phucap_chucvu',
        'quan_ly_phi',
        'phucap_congtac_dang',
        'luong_tang_them',
        'phucap_thamnien_vuotkhung',
        'phucap_khac',
        'tienthuong',
        'thunhap_tangthem',
        'tong_cackhoan_tinhthue',
        'truy_linh_ltt_qlp',
        'phucap_thamnien_nghe',
        'phucap_uudai_nghe',
        'tongcackhoan_khongtinhthue',
        'baohiem_thatnghiep_truvaoluong',
        'baohiem_xahoi_truvaoluong',
        'baohiem_yte_truvaoluong',
        'kinhphi_congdoan_truvaoluong',
        'tongtien_giamtru_nguoiphuthuoc',
        'giamtru_banthan',
        'tong_cackhoan_giamtru',
        'tong_thunhap_tinhthue',
        'thue_TNCN',
        'chiphiphatsinhkhac',
        'sendMail'
    ];

    public $timestamps = false;

}
