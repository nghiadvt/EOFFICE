<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Butphe;
use App\Models\Vanban;
use App\Models\VanbanXuLy;

class SeachRepository
{
    public function seachVanBan($tukhoa , $type, $status, $idUser, $page, $user) {
        
        switch ($type) {
            case "":
                $results = VanbanXuLy::getVBdenVBNoiBoVBForSeach($idUser, $user->donvi_id, [
                    'tukhoa' => $tukhoa,
                    'status' => $status,
                ])
                ->paginate(20)
                ->appends($page);

                $vanBanDi= Vanban::getDanhSachDiForSeach($idUser, [
                    'tukhoa' => $tukhoa,
                    'status' => $status
                ])
                ->paginate(20)
                ->appends($page);

                $results = $results->push($vanBanDi);
                return $results;
                break;
            case  0:
                return  Vanban::getDanhSachDiForSeach($idUser, [
                    'tukhoa' => $tukhoa,
                    'status' => $status
                ])
                ->paginate(20)
                ->appends($page);
                break;
            case 1:
                return VanbanXuLy::getDanhSachDenForSearch($idUser, [
                    'tukhoa' => $tukhoa,
                    'status' => $status,
                ])
                ->paginate(20)
                ->appends($page);
                break;
            case 2:
                return VanbanXuLy::getDanhSachNoiBoGuiForSearch($user->donvi_id,[
                    'tukhoa' => $tukhoa,
                    'status' => $status,
                ])
                ->paginate(20)
                ->appends($page);
                break;
            case 3: 
                return VanbanXuLy::getDanhSachNoiBoNhanForSearch($idUser, [
                    'tukhoa' => $tukhoa,
                    'status' => $status,
                ])
                ->paginate(20)
                ->appends($page);
                break;
        }
    }
    
}
