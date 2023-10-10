<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\VanBanRepository;
use App\Repositories\UserRepository;
use App\Repositories\ButPheRepository;
use App\Models\VanbanXuLy;
use Illuminate\Http\Response;
use App\Models\Ykien;
use App\Models\Donvi;
use App\Models\BookDetail;
use App\Http\Controllers\CongviecController;
use App\Models\Vanban;

class VanBanAPIController extends Controller
{
    public function __construct(
        VanBanRepository $vanBanRepository,
        UserRepository   $userRepository,
        ButPheRepository $butPheRepository
    )
    {
        $this->vanBanRepository = $vanBanRepository;
        $this->userRepository   = $userRepository;
        $this->butPheRepository = $butPheRepository;
    }

    public function danh_sach_van_ban_den(Request $request) {
        // get params
        $idUser = $this->vanBanRepository->getIdUserbyToken($request->bearerToken());

        // get data
        $vanbans = VanbanXuLy::getDanhSachDen($idUser, $request->trangthai? $request->trangthai : $request->status, [
            'tukhoa' => $request->tukhoa,
            'linhvuc' => $request->linhvuc,
            'loaivanban' => $request->loaivanban,
            'ngaybanhanhtu' => $request->ngaybanhanhtu,
            'ngaybanhanhden' => $request->ngaybanhanhden,
            'ngayguitu' => $request->ngayguitu,
            'ngayguiden' => $request->ngayguiden,
            'trangthai' => $request->trangthai,
            'page'
        ])
        ->paginate(20)
        ->appends($request->except('page'));
        $this->vanBanRepository->updateFile_dinhkem($vanbans);

        return response()->json(
            [
                'message' => 'Danh sách văn bản gửi đến',
                'status' => Response::HTTP_OK,
                'result' =>  compact('vanbans')
            ]
        );
    }

    public function danh_sach_van_ban_di(Request $request) {
        // get params
        $idUser = $this->vanBanRepository->getIdUserbyToken($request->bearerToken());

        // get data
        $vanbans = Vanban::getDanhSachDi($idUser, [
            'tukhoa' => $request->tukhoa,
            'linhvuc' => $request->linhvuc,
            'loaivanban' => $request->loaivanban,
            'ngaybanhanhtu' => $request->ngaybanhanhtu,
            'ngaybanhanhden' => $request->ngaybanhanhden,
            'ngayguitu' => $request->ngayguitu,
            'ngayguiden' => $request->ngayguiden,
            'donviSoan' => $request->donviSoan,
            'donvi_nhan_vbdi' => $request->donvi_nhan_vbdi,

        ])
        ->paginate(20)
        ->appends($request->except('page'));
        $vanbans = $this->vanBanRepository->getValueLinhVuc($vanbans);
        $vanbans  = $this->vanBanRepository->getValueLoaiVanBan($vanbans);
        $this->vanBanRepository->getDoKhan($vanbans);
        $vanbans[0]->path = url()->previous().'/vanban/dowload_file/';

        return response()->json(
            [
                'message' => 'Danh sách văn bản gửi đi',
                'status' => Response::HTTP_OK,
                'result' =>  compact('vanbans')
            ]
        );
    }

    public function detailVanBanDen(Request $request, $id) {
        // get params
        $idUser = $this->vanBanRepository->getIdUserbyToken($request->bearerToken());

        // cập nhật văn bản là đã xem
        $this->vanBanRepository->updateVanBanLaDaXem($id, $idUser);

        // cập nhật các notification là đã xem
        $this->vanBanRepository->updateNotification($id, $idUser);

        $vanbanden = $this->vanBanRepository->getVanBanDen($id, $idUser);
        if (isset($vanbanden)) {
            // $vanbanden->file_dinhkem = url()->previous().'/files/vanban/'.$vanbanden->file_dinhkem;  
            $vanbanden->path = url()->previous() . '/files/vanban/';
            $vanbanden->file_dinhkem = explode(";", $vanbanden->file_dinhkem);
        } else {
            return response()->json(
                [
                    'message' => 'Văn bản đến không tồn tại',
                    'status' => Response::HTTP_OK,
                    'result' =>  []
                ]
            );
        }

        // get danh sách user chủ trì
        $userChuTriIds = $this->userRepository->getIdUserFromStringUsernhan($vanbanden);
        $userChuTris = $this->userRepository->getDanhSachUser($userChuTriIds);

        // get danh sách user phối hợp
        $userPhoihopIds = $this->userRepository->getIdUserFromStringUserphoihop($vanbanden);
        $userPhoihops = $this->userRepository->getDanhSachUser($userPhoihopIds);

        // get danh sách đơn vị phối hợp
        $donviPhoihopIds = $this->userRepository->getIdUserFromStringDonviphoihop($vanbanden);
        $donviPhoihops = $this->userRepository->getDanhSachDonVi($donviPhoihopIds);

        $vbxuly = $this->vanBanRepository->vanBanXuLy($id, $idUser, $vanbanden);

        // Xu ly butphes
        $this->butPheRepository->XyLyButphes($id, $vbxuly);

        // tab trao đổi văn bản
        $this->vanBanRepository->xuLyTraoDoiVanBan($id, $idUser);

        // get danh sách ý kiến
        $ykiens = Ykien::getList($id, session('user')['id'])->get();

        return response()->json(
            [
                'message' => 'Chi tiết văn bản gửi đến',
                'status' => Response::HTTP_OK,
                'result' => compact(
                    'vbxuly',
                    'vanbanden',
                    'userChuTris',
                    'donviPhoihops',
                    'userPhoihops',
                    'ykiens'
                )
            ]
        );
    }

    public function detailVanBanDi(Request $request, $vanbanId) {
        // get văn bản
        $vanban = Vanban::getVanBanDi($vanbanId)->first();

        if (!$vanban) {
            return response()->json(
                [
                    'message' => 'Văn bản đi không tồn tại',
                    'status' => Response::HTTP_OK,
                    'result' =>  []
                ]
            );
        }
        $vanbans = $this->vanBanRepository->getValueLinhVuc($vanban);
        $vanbans = $this->vanBanRepository->getValueLoaiVanBan($vanban);
        $this->vanBanRepository->getDoKhan($vanban);

        $vanban->file_vbdis = $this->vanBanRepository->updateFile_vbdis($vanban->file_vbdis);
        $vanban->path = url()->previous() . '/files/vanban/';
        return response()->json(
            [
                'message' => 'Chi tiết văn bản gửi đi',
                'status' => Response::HTTP_OK,
                'result' =>  compact('vanban')
            ]
        );
    }
}
