<?php
/**
 * Created by PhpStorm.
 * User: yann
 * Date: 16/10/17
 * Time: 11:06
 */

namespace tweeterapp\model;


class Tweet extends \Illuminate\Database\Eloquent\Model
{

    protected $table      = 'tweet';
    protected $primaryKey = 'id';
    public    $timestamps = true;

    public function user()
    {

        return $this->belongsTo('tweeterapp\model\User', 'author');

        /* 'Ville'    : le nom de la classe du model lié */
        /* 'ville_id' : la clé étrangère dans la table courante */

    }
}