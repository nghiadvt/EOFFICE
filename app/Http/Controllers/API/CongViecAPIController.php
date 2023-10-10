<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CongViec;
use App\Repositories\VanBanRepository;
use App\Repositories\CongViecRepository;
use Illuminate\Http\Response;
use App\Models\CongViecChiTiet;
use App\Repositories\UserRepository;

class CongViecAPIController extends Controller
{
    public function __construct(
        VanBanRepository $vanBanRepository,
        CongViecRepository $congViecRepository,
        UserRepository $userRepository
    )
    {
        $this->vanBanRepository     = $vanBanRepository;
        $this->congViecRepository   = $congViecRepository;
        $this->userRepository       = $userRepository;
    }
    
    public function getDanhSachCongViec(Request $request) {
        $idUser = $this->vanBanRepository->getIdUserbyToken($request->bearerToken());

        // get danh sách công việc của văn bản
        $congviecs = CongViec::getDanhSach($idUser, [
            'vanban_id' => $request->vanbanId,
            'vanban_donvi_id' => $request->vanbanDonviId,
            'type' => $request->type,
            'search' => $request->search,
            'date' => $request->date? date('Y-m-d', strtotime($request->date)) : '',
            'status' => $request->status
        ])
        ->paginate(200)
        ->appends($request->except('page'));
        $this->congViecRepository->changeStatusIfEqual1And2($congviecs);
        
        return response()->json(
            [
                'message' => 'Danh sach công việc',
                'status' => Response::HTTP_OK,
                'result' => compact('congviecs')
            ]
        );
    }
    
    public function chiTietCongViec(Request $request, $id) {
        $files = $this->congViecRepository->getInfoFile($id)->first();
        $messages = $this->congViecRepository->messagesCongViec($id)->get();
        $congViecUsers = $this->congViecRepository->getCongViecUsers(10);
        $congViecBaoCao = $this->congViecRepository->congViecBaoCaoUsers($congViecUsers);
        
        return response()->json(
            [
                'message' => 'Chi tiết công việc',
                'status' => Response::HTTP_OK,
                'result' => compact('files', 'messages', 'congViecUsers', 'congViecBaoCao')
            ]
        );
    }
}
