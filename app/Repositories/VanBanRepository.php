<?php

namespace App\Repositories;

use App\Loaivanban as AppLoaivanban;
use App\Models\Linhvucs;
use App\Models\Loaivanban;
use App\Models\VanbanXuLy;
use App\Models\Notification;
use App\Models\User;
use App\Models\Vanban;

class VanBanRepository
{
    public function loaivanbans()
    {
        return Loaivanban::all();
    }

    public function getIdUserbyToken($token) {
        $payload = explode('.',$token)[1];
        $ba64= base64_decode($payload);
        
        return json_decode($ba64)->sub;
    }

    public function updateNotification($id, $idUser) {
        $vbxlIds = VanbanXuLy::where('vanbanUser_id', $id)->pluck('id')->toArray();
        $test = Notification::where('receivor_id', $idUser)
                ->whereIn('notificationable_id', $vbxlIds)
                ->where('notificationable_type', 'App\\Models\\VanbanXuLy')
                ->whereNull('read_at')
                ->update(['read_at' => date('Y-m-d H:i')]);
    }

    public function updateVanBanLaDaXem($id, $idUser) {
        // get vanbanxuly
        $checkvanbanXL = VanbanXuLy::where('vanbanUser_id', $id)->where('id_nhan', $idUser)->first();

        // cập nhật văn bản là đã xem
        if($checkvanbanXL && !$checkvanbanXL->ngayxem) {
            VanbanXuLy::where('vanbanUser_id', $id)->where('id_nhan', $idUser)->update(array('vanban_xulys.ngayxem' => date('Y-m-d H:i:s')));
        }
    }

    public function getVanBanDen($id, $idUser) {

        return VanbanXuLy::select('vanbans.*', 'vanban_xulys.status as trangthai', 'vanban_xulys.id as idVBUser', 'donvis.name as donviChuTriName', 'vanban_xulys.minhchung', 'vanban_xulys.file_minhchung')
        ->where('vanban_xulys.vanbanUser_id', $id)
        ->where('vanban_xulys.id_nhan', $idUser)
        ->leftJoin('vanbans', 'vanban_xulys.vanbanUser_id', '=', 'vanbans.id')
        ->leftJoin('donvis', 'donvis.id', '=', 'vanbans.donvi_id')
        ->first();
    }

    public function vanBanXuLy($id, $idUser, $vanbanden) {
        $vanbanxulys = VanbanXuLy::select('tbUserGui.fullname', 'tbUserNhan.fullname as userNhan', 'vanban_xulys.*', 'vanbans.ngaygui', 'vanbans.id as IdVanBan', 'vanbans.user_id as IdUser', 'donvis.name as tenDonVi')
            ->where('vanban_xulys.vanbanUser_id', $id)
            ->where('vanban_xulys.parent_id', '<>', 0)
            ->leftJoin('vanbans', 'vanban_xulys.vanbanUser_id', '=', 'vanbans.id')
            ->leftJoin('users as tbUserGui', 'tbUserGui.id', '=', 'vanbans.user_id')
            ->leftJoin('users as tbUserNhan', 'tbUserNhan.id', '=', 'vanban_xulys.id_nhan')
            ->leftJoin('donvis', 'donvis.id', '=', 'tbUserNhan.donvi_id')
            ->get();

        $parentId = VanbanXuLy::select('id_nhan','user_tao','id')->where('vanban_xulys.vanbanUser_id',$id)->orderBy('id', 'ASC')->first();
        $parent = VanbanXuLy::select('vanban_xulys.id')
            ->where('vanban_xulys.vanbanUser_id', $id)
            ->where('vanban_xulys.parent_id', 0)->first();
        $vanBanXuLy = VanbanXuLy::select('vanban_xulys.*', 'users.fullname')
            ->where('vanbanUser_id', $id)
            ->where('id_nhan', $idUser)
            ->leftJoin('users', 'users.id', '=', 'vanban_xulys.user_tao')
            ->first();

        if ($vanbanden != null || $vanBanXuLy != null) {
            $vanBanXuLy->title  = $vanbanden->title;
            $vanbanden->loaivanban_id = Loaivanban::where('id', $vanbanden->loaivanban_id)->get()->toArray()[0]['name'];
            foreach(VanBan::$dokhans as $key => $value) {
                if ($vanbanden->urgency == $key){
                    $vanbanden->urgency = $value;
                }
            }
            $parent_id          = $vanBanXuLy->parent_id == 0 ? $vanBanXuLy->id : $vanBanXuLy->parent_id;
            $vb_child = [];
            childVanBan($parent->id, $vb_child);

            return VanbanXuLy::getVanBanXuLy($vanBanXuLy->id)->first();
        } 

        return null;
    }

    public function xuLyTraoDoiVanBan($id, $idUser) {
        $now = date('Y-m-d H:i:s');

        // get danh sách user nhận là những user đã có trong luồng luân chuyển (để chọn người nhận khi gửi ý kiến)
        $userIdsTrongLuong = VanbanXuLy::select('id_nhan')->where('vanbanUser_id', $id)->pluck('id_nhan')->toArray();
        $userReceivers = User::whereIn('id', $userIdsTrongLuong)->where('id', '<>', $idUser)->orderBy('fullname', 'ASC')->get();

        // cập nhật đã xem các trao đổi nhận được
        $user = User::where('id', $idUser)->whereHas('ykiens', function($q) {
            $q->whereNull('user_ykien.read_at');
        })->first();
            
        if ($user) {
            foreach($user->ykiens as $ykien) {
                $ykien->pivot->read_at = $now;
                $ykien->pivot->save();
            }
        }
    }

    public function updateFile_dinhkem($vanbans) {
        foreach($vanbans as $value) {
            // $value->vanban->file_dinhkem = url()->previous().'/files/vanban/'.$value->vanban->file_dinhkem;
            $value->vanban->path = url()->previous().'/files/vanban/';
            $value->vanban->file_dinhkem = explode(";", $value->vanban->file_dinhkem);
        }
    }

    public function updateFile_vbdis($vanban) {
        $a = array();

        foreach(explode(';',$vanban) as $item) {
            $a[] = $item;
        }

        return $a;
    }

    public function getValueDoKhan($vanban) {
        if(isset($vanban[0])) {
            foreach(VanBan::$dokhans as $key => $value) {
                if ($vanban[0]->vanban->urgency == $key){
                    $vanban[0]->vanban->urgency = $value;
                }
            } 
            $vanban[0]->vanban->loaivanban_id = Loaivanban::where('id', $vanban[0]->vanban->loaivanban_id)->get()->toArray()[0]['name'];
        } else {
            if(isset($vanban)) {
                foreach(VanBan::$dokhans as $key => $value) {
                    if ($vanban->vanban->urgency == $key){
                        $vanban->vanban->urgency = $value;
                    }
                } 
                $vanban->vanban->loaivanban_id = Loaivanban::where('id', $vanban->vanban->loaivanban_id)->get()->toArray()[0]['name'];
            }
        }
        
        return $vanban;
    }

    public function getDoKhan($vanban) {
        foreach(VanBan::$dokhans as $key => $value) {
            if(isset($vanban[0])) {
                if(isset($vanban[0]->urgency)) {
                    if ($vanban[0]->urgency == $key){
                        $vanban[0]->urgency = $value;
                    }
                } else {
                    if ($vanban[0]->vanban->urgency == $key){
                        $vanban[0]->vanban->urgency = $value;
                    }
                }
            } else {
                if(isset($vanban->urgency)) {
                    if ($vanban->urgency == $key){
                        $vanban->urgency = $value;
                    }
                } else {
                    if ($vanban->vanban->urgency == $key){
                        $vanban->vanban->urgency = $value;
                    }
                }
            }
        }
    }

    public function getValueLoaiVanBan($vanban) {
        if (isset($vanban[0])) {
            if (isset($vanban[0]->loaivanban_id)) {
                $vanban[0]->loaivanban_id = Loaivanban::where('id', $vanban[0]->loaivanban_id)->get()->toArray()[0]['name'];
            } else {
                $vanban[0]->vanban->loaivanban_id = Loaivanban::where('id', $vanban[0]->vanban->loaivanban_id)->get()->toArray()[0]['name'];
            }
        } else {
            if (isset($vanban->loaivanban_id)) {
                $vanban->loaivanban_id = Loaivanban::where('id', $vanban->loaivanban_id)->get()->toArray()[0]['name'];
            } else {
                $vanban[0]->vanban->loaivanban_id = Loaivanban::where('id', $vanban[0]->vanban->loaivanban_id)->get()->toArray()[0]['name'];
            }
        }

        return $vanban;
    }

    public function getValueLinhVuc($vanban) {
        if (isset($vanban[0])) {
            $loaiLinhVuc = Linhvucs::where('id', $vanban[0]->linhvuc_id)->get()->toArray();
            $vanban[0]->linhvuc_id = $loaiLinhVuc == null ? 'Chưa cập nhật lĩnh vực' : $loaiLinhVuc[0]['name'];
        } else {
            $loaiLinhVuc = Linhvucs::where('id', $vanban->linhvuc_id)->get()->toArray();
            $vanban->linhvuc_id = $loaiLinhVuc == null ? 'Chưa cập nhật lĩnh vực' : $loaiLinhVuc['name'];
        }
        
        return $vanban;
    }
}
