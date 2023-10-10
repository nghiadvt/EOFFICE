<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Linhvucs;
use Carbon\Carbon;
use App\Models\Donvi;
use Lcobucci\JWT\Parser;
use DB;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function checkUser($username, $password) {
        $user = User::where('username',$username)->first();
        
        if (empty($user)) {
            return false;
        } else {
            if(Hash::check($password , $user->password)) {
                return true;
            }
            
            return false;
        }
    }

    public function checkEmail($email) {
        $user = User::where('username',$email)->first();
        if (count($user) == 0) {
            return false;
        }

        return true;
    }

    public function checkExpires_At($token) {
        $payload = explode('.',$token)[1];
        $ba64= base64_decode($payload);
        $jti = json_decode($ba64)->jti;

        $item = DB::table('oauth_access_tokens')->where('id', $jti)->get();
        
        if ( strtotime(Carbon::now()->format('Y-m-d H:i:s')) < strtotime($item[0]->expires_at)) {
            return true;
        } else {
            return false;
        }
    }

    public function createToken($user)
    {
        $tokenResult = $user->createToken('token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addHour(5);
        $token->save();
        
        return $tokenResult->accessToken;
    }

    public function getUser($email) {
        return User::where('username', $email);
    }

    public function getUserbyId($id) {
        return User::where('id', $id)->first();
    }

    public function getIdUserFromString($string) {
        return explode(';', trim($string, ';'));
    }

    //Fix Bug chi tiet van ban gui di khi string null
    public function getIdUserFromStringUsernhan($string) {
        if ( $string == null) {
            return null;
        }

        return explode(';', trim($string->usernhan, ';'));
    }

    public function getIdUserFromStringUserphoihop($string) {
        if ( $string == null) {
            return null;
        }

        return explode(';', trim($string->userphoihop_ids, ';'));
    }
    public function getIdUserFromStringDonviphoihop($string) {
        if ( $string == null) {
            return null;
        }

        return explode(';', trim($string->donviphoihop_ids, ';'));
    }

    //Fix Bug chi tiet van ban gui di khi string null

    public function getDanhSachUser($danhsach) {
        if ( $danhsach == null) {
            return null;
        }

        return User::getList()->whereIn('id', $danhsach)->get();
    }

    public function getDanhSachDonVi($danhsach) {
        if ( $danhsach == null) {
            return null;
        }

        return Donvi::getList()->whereIn('id', $danhsach)->get();
    }

    public function removeAccessToken($accessToken) {
        $id = (new Parser())->parse($accessToken)->getHeader('jti');
        
        DB::table('oauth_access_tokens')
            ->where('id', $id)
            ->update([
            'revoked' => true
        ]);
    }
}
