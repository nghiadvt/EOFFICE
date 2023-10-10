<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SeachRepository;
use App\Repositories\UserRepository;
use App\Repositories\VanBanRepository;
use Illuminate\Http\Response;

class SeachAPIController extends Controller
{
    public function __construct(
        SeachRepository $seachRepository,
        VanBanRepository $vanBanRepository,
        UserRepository $userRepository
    )
    {
        $this->seachRepository  = $seachRepository;
        $this->vanBanRepository = $vanBanRepository;
        $this->userRepository   = $userRepository;
    }

    public function seachVanBan(Request $request) {
        $idUser = $this->vanBanRepository->getIdUserbyToken($request->bearerToken());

        $user   = $this->userRepository->getUserbyId($idUser);

        $result = $this->seachRepository->seachVanBan($request->tukhoa, $request->type, $request->status, $idUser, $request->except('page'), $user);

        return response()->json(
            [
                'message' => 'Tìm kiếm văn bản',
                'status' => Response::HTTP_OK,
                'result' =>  compact('result')
            ]
        );
    }
}
