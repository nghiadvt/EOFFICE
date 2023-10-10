<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Carbon\Carbon;

class LoginAPIController extends Controller
{
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(Request $request) {
            $email = $request->email; 
            if ( ($this->userRepository->checkEmail($email)) == false) {
                return response()->json(
                    [
                        'message' => 'Không có email trong hệ thống',
                        'status' => Response::HTTP_ACCEPTED,
                        'result' => ''
                    ]
                ); 
            }
            $infoUser = $this->userRepository->getUser($email)->first();
            $user = $this->userRepository->getUser($email)->select('id', 'username', 'password')->first();
            $access_token = $this->userRepository->createToken($user);

            return response()->json(
                [
                    'message' => 'Login Successful',
                    'status' => Response::HTTP_OK,
                    'result' => compact('access_token', 'infoUser')
                ]
            ); 
    }

    public function logout(Request $request) {
        $this->userRepository->removeAccessToken($request->bearerToken());

        return response()->json(
            [
                'message' => 'Logged out',
                'status' => Response::HTTP_ACCEPTED,
                'result' => []
            ]
        );
    }

    public function home(Request $request) {
        return response()->json(
            [
                'message' => 'Trang chủ',
                'status' => Response::HTTP_OK,
                'result' => []
            ]
        );
    }
}
