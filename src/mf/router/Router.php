<?php
/**
 * Created by PhpStorm.
 * User: yann
 * Date: 16/10/17
 * Time: 17:34
 */
namespace mf\router;

use mf\auth\Authentification;
use mf\utils\HttpRequest;

class Router extends AbstractRouter {


    public function __construct()
    {
        parent::__construct();
    }

    /*
     * MÃ©thode addRoute : ajoute une route a la liste des routes
     *
     * ParamÃ¨tres :
     *
     * - $name (String) : un nom pour la route
     * - $url (String)  : l'url de la route
     * - $ctrl (String) : le nom de la classe du Controleur
     * - $mth (String)  : le nom de la mÃ©thode qui rÃ©alise la fonctionalitÃ©
     *                     de la route
     *
     * Algorithme :
     *
     * - Ajouter le tablau [ $ctrl, $mth ] au tableau $this->route
     *   sous la clÃ© $url et sous la clÃ© $name
     *
     */


    public function addRoute($name, $url, $ctrl, $mth, $level){


        self::$routes[$url] = [$ctrl,$mth, $level];
        self::$routes[$name] = [$ctrl,$mth, $level];

    }

    // L'objectif de la méthode run est de déclencher la fonctionnalité demandée
    public function run()
    {
        // TODO: Implement run() method.

        /*
        * MÃ©thode run : execute une route en fonction de la requÃªte
        *
        *
        * Algorithme :
        *
        * - l'URL de la route est stockÃ©e dans l'attribut $path_info de
        *         $http_request
        *   Et si une route existe dans le tableau $route sous le nom $path_info
        *     - crÃ©er une instance du controleur de la route
        *     - exÃ©cuter la mÃ©thode de la route
        * - Sinon
        *     - exÃ©cuter la route par dÃ©faut :
        *        - crÃ©er une instance du controleur de la route par dÃ©fault
        *        - exÃ©cuter la mÃ©thode de la route par dÃ©fault
        *
        */

        // la requête
        $path = $this->http_req->path_info;

        // la route éxiste
       if(isset(self::$routes[$path])){

           // stock le controller
           $ctrl = self::$routes[$path][0];
           // stock la méthode
           $mth = self::$routes[$path][1];
           // stock le niveau de la fonctionalité
           $lvl = self::$routes[$path][2];

           if($lvl > 0){

               $check = new Authentification();

               if($check->checkAccessRight(self::$routes[$path][2])){

                   $c = new $ctrl();
                   $c->$mth();

               } else {

                   // stock le controller
                   $ctrl = self::$routes['default'][0];
                   // stock la méthode
                   $mth = self::$routes['default'][1];

                   $c = new $ctrl();
                   $c->$mth();

               }

           } else {

               $c = new $ctrl();
               $c->$mth();
           }

       } else {

           // stock le controller
           $ctrl = self::$routes['default'][0];
           // stock la méthode
           $mth = self::$routes['default'][1];

           $c = new $ctrl();
           $c->$mth();
       }

    }
}