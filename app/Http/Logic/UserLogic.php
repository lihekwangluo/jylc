<?php

namespace App\Http\Logic;

use App\Http\Model\UserModel;

class UserLogic{


    public function checkUserMobileExist($mobile){
        $user = UserModel::where('mobile', $mobile)->first();
        return $user?true:false;
    }
}