<?php

namespace tweeterapp\view;
use tweeterapp\model\User;
use tweeterapp\model\Tweet;

class TweeterView extends \mf\view\AbstractView {
  
    /* Constructeur 
    *
    * Appelle le constructeur de la classe \mf\view\AbstractView
    */
    public function __construct( $data ){
        parent::__construct($data);
    }

    /* Méthode renderHeader
     *
     *  Retourne le fragment HTML de l'entête (unique pour toutes les vues)
     */ 
    private function renderHeader(){
        $html =

<<<EOT
        
        <h1>MiniTweeTR</h1>
            <nav><a href="$this->script_name"><i class="fa fa-home" aria-hidden="true"></i>
</a> <a href="$this->script_name/login/"><i class="fa fa-sign-in" aria-hidden="true"></i></a> <a href="$this->script_name/signup/">
<i class="fa fa-plus" aria-hidden="true"></i>
</a></nav>
        
      
EOT;
        return $html;
    }
    
    /* Méthode renderFooter
     *
     * Retourne  le fragment HTML du bas de la page (unique pour toutes les vues)
     */
    private function renderFooter(){
        return 'La super app créée en Licence Pro &copy;2017';
    }

    /* Méthode renderHome
     *
     * Retourne le fragment HTML qui réalise la fonctionalité afficher
     * tout les Tweets. 
     *  
     * L'attribut $this->data contient un tableau d'objets tweet.
     * 
     */
    
    protected function renderHome(){


        $html = "";
        foreach ($this->data as $value){

            $html .= '<div class="tweet">';

            $html .= '<p class="author">Auteur : <a href="'.$this->script_name.'/user/?id='.$value->author.'"> '.$value->user->fullname.'</p>';
            $html .= '<p class="tweet"><a href="'.$this->script_name.'/view/?id='.$value['id'].'">'.$value->text.'</a></p>';
            $html .= '<p class="date">'.$value->created_at.'</p>';

            $html .= '</div>';
        }


        return $html;

    }
    
    /* Méthode renderUserTweets
     *
     * Retourne le fragment HTML qui réalise la fonctionalité afficher
     * tout les Tweets d'un utilisateur donné. 
     *  
     * L'attribut $this->data contient un objet User.
     * 
     */
     
    protected function renderUserTweets(){

        $tab = $this->data->tweets()->get();

        $html = "<section>";

        foreach ($tab as $key => $value){

            $html .= '<div>';


                $html .= '<p>Author : '.$this->data->fullname.'</p>';
                $html .= '<p>Tweet : <a href="'.$this->script_name.'/view/?id='.$value['id'].'">'.$value['text'].'</a></p>';
                $html .= '<p>Date : '.$value['created_at'].'</p>';
                $html .= '<p>Followers : '.$this->data->followers.'</p>';



            $html .= '</div>';

        }

        $html .= "</section>";

        return $html;

    }
  
    /* Méthode renderViewTweet 
     * 
     * Retourne le fragment HTML qui réalise l'affichage d'un tweet particulié 
     * 
     * L'attribut $this->data contient un objet Tweet
     *
     */
    protected function renderViewTweet(){

        $html = "<section>";

        $html .= '<p class="text_tweet">text:'.$this->data->text.'</p>';
        $html .= '<p class="author">auteur: <a href="'.$this->script_name.'/user/?id='.$this->data->author.'"> '.$this->data->author.'</a></p>';
        $html .= '<p class="like">score:'.$this->data->score.'</p>';
        $html .= '<p class="date_create">créer le : '.$this->data->created_at.'</p>';
        $html .= '<p>modifier en dernier le : '.$this->data->updated_at.'</p>';

        $html .= "</section>";

        return $html;
    }


    // Html post page
    protected function renderPost(){

        $html =

<<<EOT

        <section>
                <form method="post" action="$this->script_name/send/">
                    <textarea rows="4" cols="50" name="text" value=""></textarea>
                    <input type="submit" value="send"/>
                </form>
        </section>
 
EOT;

        return $html;
    }


    // Html login page
    protected function renderLogin(){

        $html =

<<<EOT
        <section>
            <form method="post" action="$this->script_name/check_login/">
                <input type="text" name="user" placeholder="username"/>
                <input type="password" name="pw" placeholder="password"/>
                
                <input type="submit" value="login"/>
            </form>
        </section>  
EOT;

        return $html;
    }


    // Html sign up page
    protected function renderSignUp(){

        $html =

<<<EOT
        <section>
                <form method="post" action="$this->script_name/check_signup/">
                    <input type="text" name="fullname" placeholder="fullname"/>
                    <input type="text" name="username" placeholder="username"/>
                    <input type="password" name="pw" placeholder="password"/>
                    <input type="password" name="pw_repeat" placeholder="Repeat password"/>
                    
                    <input type="submit" value="create"/>
                </form>
        </section>
EOT;

        return $html;
    }


    /* Méthode renderBody
     *
     * Retourne la framgment HTML de la balise <body> elle est appelée
     * par la méthode héritée render.
     *
     * En fonction du selecteur (un string) passé en paramètre, elle remplit les
     * blocs avec le résultats des différentes méthodes définit plus
     * haut
     * 
     */
    
    protected function renderBody($selector=null){

        $header = $this->renderHeader();
        $footer = $this->renderFooter();

        $body = $this->$selector();

        $html =

<<<EOT

        <header class="theme-backcolor1">${header}</header>
        <section id="container" class="theme-backcolor2">
            ${body}
        </section>
        <footer class="theme-backcolor1">${footer}</footer>

EOT;

        return  $html;
        
    }

}
