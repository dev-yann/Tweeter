<?php
/**
 * Created by PhpStorm.
 * User: yann
 * Date: 25/09/17
 * Time: 16:24
 */
/*Un attribut privé $prefix, qui stock le répertoire qui contient les fichiers des classe. Le constructeur se charge de l'initialiser.

Une méthode loadClass celle-ci fait le même traitement que la fonction test_autoload. Elle utilise la valeur de l'attribut $prefix.

Une méthode register, qui enregistre la méthode au près de l'interprète PHP grâce à la fonction spl_autoload_register (voir la doc)
*/
namespace peopleapp\utils;

class ClassLoader{

    private  $prefix;

    function __construct($prefix)
    {
        $this->prefix = $prefix;
    }

// $path = \peopleapp\personne\Etudiant ( le nom de la classe ), la fonction register
// appel automatiquement le nom de la classe inconnue instancié en parametre 
    function loadClass($path){


        $mynewpath = str_replace("\\",DIRECTORY_SEPARATOR , $path);
        $mynewpath = $this->prefix.DIRECTORY_SEPARATOR.$mynewpath.'.php';


        if(file_exists($mynewpath)){

            require_once ($mynewpath);

        }// alors je laisse l'autoloader eloquent charger

    }


    function register(){

        spl_autoload_register([$this,"loadClass"]);

    }

}
