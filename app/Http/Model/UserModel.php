<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;


}