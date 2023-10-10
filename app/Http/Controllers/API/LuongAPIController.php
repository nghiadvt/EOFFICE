<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\LuongRepository;
use App\Repositories\UserRepository;
use App\Repositories\VanBanRepository;
use Illuminate\Http\Response;

class LuongAPIController extends Controller
{
    public function __construct(
        UserRepository $userRepository,
        LuongRepository $luongRepository,
        VanBanRepository $vanBanRepository
    )
    {
        $this->userRepository   = $userRepository;
        $this->luongRepository  = $luongRepository;
        $this->vanBanRepository = $vanBanRepository;
    }

    public function xemLuongThue(Request $request) {
        $idUser     = $this->vanBanRepository->getIdUserbyToken($request->bearerToken());

        $user       = (object) $this->userRepository->getUserbyId($idUser);
        $fullname   = $user->fullname;
        $macanbo = $user->macanbo;
       
        $luong = $this->luongRepository->getluongByMaCanBoAndDate($macanbo, date('Y-m'));
        $this->luongRepository->changeNumberFormatValue($luong);

        return response()->json(
            [
                'message' => 'Danh sách lương và phụ cấp',
                'status' => Response::HTTP_OK,
                'result' => compact('macanbo', 'fullname', 'luong')
            ]
        );
    }

    public function searchLuongAndThue(Request $request) {
        $idUser     = $this->vanBanRepository->getIdUserbyToken($request->bearerToken());

        $user       = (object) $this->userRepository->getUserbyId($idUser);
        $fullname   = $user->fullname;
        $macanbo    = $user->macanbo;
        $check      = $request->check;
        $date       = date('Y-m', strtotime(str_replace('/', '-', '01/' . $request->date)));

        if ($check === 'tonghopthunhap'):
            $luong = $this->luongRepository->getThueByMaCanBoAndDate($macanbo, $date);

            return response()->json(
                [
                    'message' => 'Danh sách tổng hợp thu thập thuế',
                    'status' => Response::HTTP_OK,
                    'result' => compact('macanbo', 'fullname', 'luong')
                ]
            );
        elseif ($check === 'luongphucap'): 
            $luong = $this->luongRepository->getluongByMaCanBoAndDate($macanbo, $date);
            $this->luongRepository->changeNumberFormatValue($luong);
            
            return response()->json(
                [
                    'message' => 'Danh sách lương và phụ cấp',
                    'status' => Response::HTTP_OK,
                    'result' => compact('macanbo', 'fullname', 'luong')
                ]
            );
        endif;
    }
}
