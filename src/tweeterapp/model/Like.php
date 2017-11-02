<?php
/**
 * Created by PhpStorm.
 * User: yann
 * Date: 16/10/17
 * Time: 11:06
 */

namespace tweeterapp\model;


class Like extends \Illuminate\Database\Eloquent\Model
{

    protected $table      = 'like';
    protected $primaryKey = 'id';
    public    $timestamps = false;


}