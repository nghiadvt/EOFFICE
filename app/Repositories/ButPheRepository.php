<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Butphe;

class ButPheRepository
{
    public function XyLyButphes($id, $vbxuly) {
        if (isset($vbxuly)) {
            // get danh sách bút phê đã gửi
            $vbxuly->butphes = Butphe::getList($id)->get();

            // get danh sách users trong mỗi butphe
            $userIdsButphe = explode(';', trim(implode('', $vbxuly->butphes->pluck('receiver_ids')->toArray()), ';'));
            $usersButphe = User::getList()->whereIn('users.id', $userIdsButphe)->get()->keyBy('id');

            foreach($vbxuly->butphes as $key => $butphe) {
                $userNhans = [];

                foreach($butphe->receiver_ids_arr as $receiverId) {
                    if (isset($usersButphe[$receiverId])) {
                        $userNhans[$receiverId] = $usersButphe[$receiverId]->fullname;
                    }
                }
                
                $vbxuly->butphes[$key]->userNhans = $userNhans;
            }
        }
    }
}
