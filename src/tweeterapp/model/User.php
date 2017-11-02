<?php
/**
 * Created by PhpStorm.
 * User: yann
 * Date: 16/10/17
 * Time: 11:06
 */

namespace tweeterapp\model;


class User extends \Illuminate\Database\Eloquent\Model
{

    protected $table      = 'user';
    protected $primaryKey = 'id';
    public    $timestamps = false;

    //protected $fullname,$username,$password,$level,$followers;

    public function tweets(){
        return $this->hasMany('tweeterapp\model\Tweet','author');
    }
}