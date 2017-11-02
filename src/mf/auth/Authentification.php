<?php
/**
 * Created by PhpStorm.
 * User: yann
 * Date: 25/10/17
 * Time: 09:54
 */

namespace mf\auth;


class Authentification extends AbstractAuthentification {

    public function __construct()
    {
        if(isset($_SESSION['user_login'])){

            $this->user_login = $_SESSION['user_login'];
            $this->access_level = $_SESSION['acces_level'];
            $this->logged_in = true;

        } else {

            $this->logged_in = false;
            $this->user_login = null;
            $this->access_level = AbstractAuthentification::ACCESS_LEVEL_NONE;
        }

    }


    public function updateSession($username, $level)
    {

        $this->user_login = $username;
        $this->access_level = $level;

        $_SESSION['user_login'] = $username;
        $_SESSION['acces_level'] = $level;

        $this->logged_in = true;

    }

    public function logout()
    {

        unset($_SESSION['user_login']);
        unset( $_SESSION['access_right']);

        $this->user_login = null;
        $this->access_level = AbstractAuthentification::ACCESS_LEVEL_NONE;
        $this->logged_in = false;

    }

    public function checkAccessRight($requested){

        if($requested > $this->access_level ){

            return false;

        } else {

            // vrai si le niveaux requis est inférieur ou égale à la valeur du niveau de l'utilisateur
            return true;
        }
    }

    protected function hashPassword($password){

        return password_hash($password,PASSWORD_BCRYPT);

    }

    protected function verifyPassword($password, $hash){

        return password_verify($password,$hash);

    }

}