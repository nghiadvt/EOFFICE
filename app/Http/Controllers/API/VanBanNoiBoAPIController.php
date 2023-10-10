<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VanbanXuLy;
use Illuminate\Http\Response;
use App\Repositories\UserRepository;
use App\Repositories\VanBanRepository;
use App\Repositories\ButPheRepository;
use App\Models\Ykien;

class VanBanNoiBoAPIController extends Controller
{
    public function __construct(
        VanBanRepository $vanBanRepository,
        UserRepository   $userRepository,
        ButPheRepository $butPheRepository
    )
    {
        $this->vanBanRepository =   $vanBanRepository;
        $this->userRepository   =   $userRepository;
        $this->butPheRepository =   $butPheRepository;
    }

    public function danh_sach_gui(Request $request) {
        $idUser = $this->vanBanRepository->getIdUserbyToken($request->bearerToken());

        $user = $this->userRepository->getUserbyId($idUser);

        // get data: lấy ds nội bộ đã gửi theo đơn vị (cùng đơn vị thì thấy được văn bản nội bộ đã gửi)
        $vanbans = VanbanXuLy::getDanhSachNoiBoGui($user->donvi_id, $request->trangthai? $request->trangthai : $request->status, [
            'tukhoa' => $request->tukhoa,
            'linhvuc' => $request->linhvuc,
            'loaivanban' => $request->loaivanban,
            'ngaybanhanhtu' => $request->ngaybanhanhtu,
            'ngaybanhanhden' => $request->ngaybanhanhden,
            'ngayguitu' => $request->ngayguitu,
            'ngayguiden' => $request->ngayguiden,
            'trangthai' => $request->trangthai,
            'noibanhanh'=>$request->noibanhanh
        ])
        ->paginate(20)
        ->appends($request->except('page'));
        if ( isset($vanbans) ) {
            foreach($vanbans as $vanban) { 
                // $vanban->vanban->file_dinhkem = url()->previous().'/vanban/dowload_file/'.$vanban->vanban->file_dinhkem;
                $vanban->vanban->path = url()->previous().'/vanban/dowload_file/';
                $vanban->vanban->file_dinhkem = explode(';', $vanban->vanban->file_dinhkem );
            }
        }

        return response()->json(
            [
                'message' => 'Danh sach van ban gui di',
                'status' => Response::HTTP_OK,
                'result' => compact('vanbans')
            ]
        );
    }
  
    public function chi_tiet_van_ban_gui_di(Request $request, $id) {
        $idUser = $this->vanBanRepository->getIdUserbyToken($request->bearerToken());
        
        // cập nhật văn bản là đã xem
        $this->vanBanRepository->updateVanBanLaDaXem($id, $idUser);

         // cập nhật các notification là đã xem
         $this->vanBanRepository->updateNotification($id, $idUser);
        
        $vanbanden = $this->vanBanRepository->getVanBanDen($id, $idUser); 
        if($vanbanden==null){
            return response()->json(
                [
                    'message' => 'Văn bản nội bộ không tồn tại',
                    'status' => Response::HTTP_OK,
                    'result' =>  []
                ]);
        }
        if ( isset($vanbanden) ) {
            // $vanbanden->file_dinhkem = url()->previous().'/files/vanban/'.$vanbanden->file_dinhkem;  
            $vanbanden->path = url()->previous().'/files/vanban/'; 
            $vanbanden->file_dinhkem = explode(';', $vanbanden->file_dinhkem) ;
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
        $vbxuly = $this->vanBanRepository->getValueDoKhan($vbxuly);
        // Xu ly butphes
        $this->butPheRepository->XyLyButphes($id, $vbxuly);

        // tab trao đổi văn bản
        $this->vanBanRepository->xuLyTraoDoiVanBan($id, $idUser);

        // get danh sách ý kiến
        $ykiens = Ykien::getList($id, $idUser)->get();

        return response()->json(
            [
                'message' => 'Chi tiết văn bản gửi đi',
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

    public function danh_sach_nhan(Request $request) {
        // get params
        $idUser = $this->vanBanRepository->getIdUserbyToken($request->bearerToken());

        // get data
        $vanbans = VanbanXuLy::getDanhSachNoiBoNhan($idUser, $request->trangthai? $request->trangthai : $request->status, [
            'tukhoa' => $request->tukhoa,
            'linhvuc' => $request->linhvuc,
            'loaivanban' => $request->loaivanban,
            'ngaybanhanhtu' => $request->ngaybanhanhtu,
            'ngaybanhanhden' => $request->ngaybanhanhden,
            'ngayguitu' => $request->ngayguitu,
            'ngayguiden' => $request->ngayguiden,
            'trangthai' => $request->trangthai,
            'noibanhanh'=>$request->noibanhanh
            
        ])
        ->paginate(20)
        ->appends($request->except('page'));  
        $vanbans = $this->vanBanRepository->getValueLoaiVanBan($vanbans);
        $this->vanBanRepository->getDoKhan($vanbans[0]);
        $this->vanBanRepository->updateFile_dinhkem($vanbans);

        return response()->json(
            [
                'message' => 'Danh sách văn bản nội bộ đã nhận',
                'status' => Response::HTTP_OK,
                'result' => compact('status', 'vanbans')
            ]
        );
    }
}
