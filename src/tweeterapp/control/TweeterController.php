<?php
/**
 * Created by PhpStorm.
 * User: yann
 * Date: 16/10/17
 * Time: 16:30
 */
namespace tweeterapp\control;



/* Classe TweeterController :
 *
 * RÃ©alise les algorithmes des fonctionnalitÃ©s suivantes:
 *
 *  - afficher la liste des Tweets
 *  - afficher un Tweet
 *  - afficher les tweet d'un utilisateur
 *  - afficher la le formulaire pour poster un Tweet
 *  - afficher la liste des utilisateurs suivis
 *  - Ã©valuer un Tweet
 *  - suivre un utilisateur
 *
 */

use tweeterapp\model\Tweet;
use tweeterapp\model\User;
use tweeterapp\view\TweeterView;
use tweeterapp\auth\TweeterAuthentification;

class TweeterController extends \mf\control\AbstractController {


    /* Constructeur : Appelle le constructeur parent
       c.f. la classe \mf\control\AbstractController */

    public function __construct(){
        parent::__construct();
    }



    // Affiche la liste des tweets
    public function viewHome(){

        $tweets = Tweet::get();



        $vue = new TweeterView($tweets);
        $vue->render('renderHome');
    }


    // Affiche un tweet en particulier
    public function viewTweet(){

        /* Algorithme :
         *
         *  1 L'identifiant du Tweet en question est passÃ© en paramÃ¨tre (id)
         *    d'une requÃªte GET
         *  2 RÃ©cupÃ©rer le Tweet depuis le modÃ¨le Tweet
         *  3 Afficher toutes les informations du tweet
         *      (text, auteur, date, score)
         *
         *  Erreurs possibles : (*** Ã  implanter ultÃ©rieurement ***)
         *    - pas de paramÃ¨tre dans la requÃªte
         *    - le paramÃ¨tre passÃ© ne correspond pas a un identifiant existant
         *    - le paramÃ¨tre passÃ© n'est pas un entier
         *
         */

        $id = $this->request->get['id'];
        $tweet = Tweet::select()->where('id','=', $id)->first();

        $vue = new TweeterView($tweet);
        $vue->render('renderViewTweet');

    }


    // Méthode viewUserTweets : Réalise la fonctionnalitée afficher les tweet d'un utilisateur
    public function viewUserTweets(){

        /*
         *
         *  1 L'identifiant de l'utilisateur en question est passÃ© en
         *      paramÃ¨tre (id) d'une requÃªte GET
         *  2 RÃ©cupÃ©rer l'utilisateur et ses Tweets depuis le modÃ¨le
         *      Tweet et User
         *  3 Afficher les informations de l'utilisateur
         *      (non, login, nombre de suiveurs)
         *  4 Afficher ses Tweets (text, auteur, date)
         *
         *    - pas de paramÃ¨tre dans la requÃªte
         *    - le paramÃ¨tre passÃ© ne correspond pas a un identifiant existant
         *    - le paramÃ¨tre passÃ© n'est pas un entier
         *
        *  Erreurs possibles : (*** Ã  implanter ultÃ©rieurement ***)
         */

        $id = $this->request->get['id'];

        // recuperer les tweet d'un user donné

        // on récupere d'abord l'user
        $u = User::where('id', '=', $id)->first();

        // Puis on récupere la liste de ses tweet via la méthode club crée ds la classe user
        //$liste_tweet = $u->tweets()->with('tweet')->get();

        //var_dump($u);

        // liste tweet est un ensemble d'instance


        $vue = new TweeterView($u);
        $vue->render('renderUserTweets');

    }


    // Affiche la vue pour poster un tweet
    public function viewPost(){

        $vide = array();
        $vue = new TweeterView($vide);
        $vue->render('renderPost');
    }


    // Save post
    public function sendPost(){


        $text = $_POST['text'];

        $v = new Tweet();
        // rejouter un filtre pour forcer la string
        $v->text = filter_var($text,FILTER_SANITIZE_SPECIAL_CHARS);
        $v->author = 1;
        $v->score = 0;

        $v->save();

        $vide = array();
        $vue = new TweeterView($vide);
        $vue->render('renderPost');
    }


    // Show login form
    public function viewLogin(){
        $vide = array();
        $vue = new TweeterView($vide);
        $vue->render('renderLogin');
    }




    // Show sign up form
    public function viewSignUp(){

        $vide = array();
        $vue = new TweeterView($vide);
        $vue->render('renderSignUp');

    }

    // Throw check login
    // Control login form
    public function checkLogin(){

        // save post var

        if(isset($_POST['user'], $_POST['pw']) AND !empty($_POST['user']) AND !empty($_POST['pw'])){

            $user = filter_input(INPUT_POST,'user',FILTER_SANITIZE_SPECIAL_CHARS);
            $pass = filter_input(INPUT_POST,'pw',FILTER_SANITIZE_SPECIAL_CHARS);


            $connect = new TweeterAuthentification();

            // Si l'authentification retourne vrai
            if($connect->login($user,$pass)){

                $this->viewHome();

            } else {

                $this->viewLogin();
            }

        } else {

            $this->viewLogin();

        }
    }


    public function checkSignup(){

        if(filter_has_var(INPUT_POST,'fullname') AND filter_has_var(INPUT_POST,'username') AND filter_has_var(INPUT_POST,'pw') AND filter_has_var(INPUT_POST,'pw') AND filter_has_var(INPUT_POST,'pw_repeat')){

            $fullname = filter_input(INPUT_POST,'fullname',FILTER_SANITIZE_SPECIAL_CHARS);
            $username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS);
            $pw = filter_input(INPUT_POST,'pw',FILTER_SANITIZE_SPECIAL_CHARS);
            $pw_repeat = filter_input(INPUT_POST,'pw_repeat',FILTER_SANITIZE_SPECIAL_CHARS);

            if($pw === $pw_repeat){

                $signUp = new TweeterAuthentification();
                $signUp->createUser($username, $pw, $fullname);

                $this->viewHome();

            } else {

                $this->viewSignUp();
            }

        } else {

            $this->checkSignup();
        }
    }
}