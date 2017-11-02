<?php
/**
 * Created by PhpStorm.
 * User: yann
 * Date: 16/10/17
 * Time: 11:06
 */

namespace tweeterapp\model;


class Follow extends \Illuminate\Database\Eloquent\Model {

    protected $table      = 'follow';  /* le nom de la table */
    protected $primaryKey = 'id';     /* le nom de la clé primaire */
    public    $timestamps = false;    /* si vrai la table doit contenir
                                            les deux colonnes updated_at,
                                            created_at */
    protected $follower, $followee;
}

