<?php
/**
 * Created by PhpStorm.
 * User: yann
 * Date: 11/10/17
 * Time: 13:20
 */
session_status();

/* pour le chargement automatique des classes dans vendor */
require_once ('vendor/autoload.php');
require_once ('src/mf/utils/ClassLoader.php');
$load = new \peopleapp\utils\ClassLoader('src');
$load->register();

use mf\router\Router;
use mf\router\AbstractRouter;
use tweeterapp\model\User;
use tweeterapp\model\Follow;
use tweeterapp\model\Like;
use tweeterapp\model\Tweet;
use tweeterapp\control\TweeterController;
use tweeterapp\view\TweeterView;

$config = parse_ini_file('conf/config.ini');

$db = new Illuminate\Database\Capsule\Manager();

// initialisation connection
$db->addConnection( $config );
$db->setAsGlobal();
$db->bootEloquent();



/*echo ('<h1>Tous les utilisateurs</h1>');
$requete = User::select();  /* SQL : select * from 'ville'
$lignes = $requete->get();   /* exécution de la requête et plusieurs lignesrésultat

foreach ($lignes as $v){
    echo "Identifiant = $v->id, Nom = $v->fullname\n" ;
}    /* $v est une instance de la classe Ville


echo ('<h1>récupérer la liste de tous les Tweets et les ordonner par date de modification.</h1>');

$Tweet = Tweet::select()->orderBy("updated_at")->get();

foreach ($Tweet as $t){

    echo ("<p>Le tweet : $t->text La date : $t->updated_at</p>");

}

echo ('<h1> les Tweets qui ont un score positif </h1>');

$scorePositif = Tweet::select()->where('score','>',0)->get();
foreach ($scorePositif as $key){
    echo ("<p>Le tweet : $key->text Le score : $key->score</p>");
}

echo ("<h1>ajout du tweet : </h1>");

$v = new Tweet();
$v->text = 'Je suis un tweet';
$v->author = 10;
$v->score = 0;
$v->save();*/

/*
echo '<p>liste des tweet</p>';
$ctrl = new TweeterController();
echo $ctrl->viewHome();
*/

$router = new \mf\router\Router();

/*Pour ajouter une nouvelles fonctionnalité à l'application il suffit d'ajouter
 une route, un contrôleur associée et une vue.*/

$router->addRoute('home',    '/home/','\tweeterapp\control\TweeterController', 'viewHome',\tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('default', 'DEFAULT_ROUTE','\tweeterapp\control\TweeterController', 'viewHome', tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('view',    '/view/','\tweeterapp\control\TweeterController','viewTweet',tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('user',    '/user/','\tweeterapp\control\TweeterController','viewUserTweets',tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('post',    '/post/','\tweeterapp\control\TweeterController','viewPost',tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_USER);
$router->addRoute('send',    '/send/','\tweeterapp\control\TweeterController','sendPost',tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_USER);
$router->addRoute('login',   '/login/','\tweeterapp\control\TweeterController','viewLogin',tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('signup',   '/signup/','\tweeterapp\control\TweeterController','viewSignUp',tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('check_login',   '/check_login/','\tweeterapp\control\TweeterController','checkLogin',tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('check_signup',   '/check_signup/','\tweeterapp\control\TweeterController','checkSignup',tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_NONE);
//print_r(Router::$routes);
$router->run();



