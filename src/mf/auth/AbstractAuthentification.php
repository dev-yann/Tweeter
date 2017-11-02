<?php

namespace mf\auth;

abstract class AbstractAuthentification {

    /* une constante pour le niveau le plus bas*/
    const ACCESS_LEVEL_NONE = -9999; 
  
    /* l'identifiant de l'utilisateur connecté */ 
    protected $user_login   = null;

    /* son niveau d'accès */
    protected $access_level = self::ACCESS_LEVEL_NONE; 

    /* vrai s'il est connecté */
    protected $logged_in    = false;


    /* un getter et un setter + toString*/
    public function __get($attr_name) {
        if (property_exists( __CLASS__, $attr_name))
            return $this->$attr_name;
        $emess = __CLASS__ . ": unknown member $attr_name (__get)";
        throw new \Exception($emess);
    }

    
    public function __set($attr_name, $attr_val) {
        if (property_exists( __CLASS__, $attr_name)) 
            $this->$attr_name=$attr_val; 
        else{
            $emess = __CLASS__ . ": unknown member $attr_name (__set)";
            throw new \Exception($emess);
        }
    }

    public function __toString(){
        return json_encode(get_object_vars($this));
    } 


    /* Le constructeur: 
     * 
     * Faire le lien entre la variable de session et les attributs de la classe
     *
     *   Les variables de session sont les suivante :
     *    - $_SESSION['user_login'] 
     *    - $_SESSION['access_level'] 
     *    
     *  Algorithme :
     * 
     *  Si la variable de session 'user_login' existe 
     * 
     *     - renseigner l'attribut $this->user_login avec sa valeur 
     *     - renseigner l'attribut $this->access_level avec la valeur de 
     *       la variable de session 'access_level'
     *     - mettre l'attribut $this->logged_in a vrai
     *
     *  sinon 
     *     - mettre les valeurs null, ACCESS_LEVEL_NONE et false respectivement 
     *       dans les trois attribut.
     *
     */





    /* La méthode updateSession : 
     *
     * Méthode pour enregistrer la connexion d'un utilisateur dans la session 
     *
     * ATTENTION : cette méthode n'est appelée uniquement quand la connexion 
     *             réussie
     *
     * @param String : $username, le login de l'utilisateur  
     * @param String : $level, le niveau d'accès
     *
     *  Algorithme:
     *    - renseigner l'attribut $this->user_login avec le paramètre $username 
     *    - renseigner l'attribut $this->access_level avec $level
     *
     *    - renseigner $_SESSION['user_login']  $username
     *    - renseigner $_SESSION['access_level'] $level

     *    - mettre l'attribut $this->logged_in à vrai
     *
     */
    
    abstract public function updateSession($username, $level);

     /* la méthode logout :
      * 
      * Méthode pour effectuer la déconnexion : 
      *
      * Algorithme :
      *
      *  - Effacer les variables $_SESSION['user_login'] et 
      *    $_SESSION['access_right']
      *  - Réinitialiser les attributs $this->user_login, $this->access_level
      *  - Mettre l'attribut $this->logged_in a faux
      * 
      */
    
    abstract public function logout();


    /* La méthode checkAccessRight:
     * 
     * Méthode pour verifier le niveau d'accès de l'utilisateur.
     *  
     * @param  int  : $requested, le niveau requis
     * @return bool : vrai si le niveaux requis est inférieur ou égale à la 
     *                valeur du niveau de l'utilisateur 
     * 
     * Algorithme :
     *
     * Si $requested > $this->access_level  
     *     retourner faux
     * Sinon 
     *     retourner vrai
     */
    
    abstract public function checkAccessRight($requested);

    
    /* Méthode hashPassword :
     *
     * Méthode pour hacher un mot de passe
     *  
     * @param  string : $password, le mots de passe en clair
     * @return string : mot de passe haché
     * 
     * Algorithme : 
     *  
     *   Retourner le résultat de la fonction password_hash
     *
     */
    
    abstract protected function hashPassword($password);

    /* La Méthodes verifyPassword : 
     * 
     * Méthode pour vérifier si un mot de passe est égale a un hache  
     *  
     * @param string : $password, mot de passe non haché (depuis un formulaire)
     * @param string : $hash, le mot de passe haché (depuis BD)
     * @return bool  : vrai si concordance faut sinon
     *
     *
     * Algorithme :
     *
     *  Retourner le résultat de la fonction password_verify
     */
    
    abstract protected function verifyPassword($password, $hash);

    
    
}