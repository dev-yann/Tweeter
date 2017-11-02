<?php
/**
 * Created by PhpStorm.
 * User: yann
 * Date: 16/10/17
 * Time: 16:32
 */
namespace mf\control;

abstract class AbstractController {

    /* Attribut pour stocker l'objet HttpRequest */
    protected $request=null;

    /*
     * Constructeur :
     *
     * Reçoit une instance de la classe HttRequest et la stocke dans l'attribut
     * $request, dès l'instanciation, je récupere un objet qui détient tte les infos
     * de httpRequest : get post etc
     *
     *
     */

    public function __construct(){

        $this->request = new \mf\utils\HttpRequest();

    }

}


