<?php

  class BaseController{

    public static function get_user_logged_in(){
      if(isset($_SESSION['kayttaja'])){
        $kayttaja_id = $_SESSION['kayttaja'];
        $kayttaja = Kayttaja::findById($kayttaja_id);

      return $kayttaja;
      }  else {
        return null;
      }
    }

    public static function check_logged_in(){
      if(!isset($_SESSION['kayttaja'])){
        Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään'));
      }
    }

    public static function check_admin(){
      if(isset($_SESSION['kayttaja'])){
        $kayttaja_id = $_SESSION['kayttaja'];
        $kayttaja = Kayttaja::findById($kayttaja_id);

      if (!$kayttaja->paakaytto == 1){
        Redirect::to('/', array('message' => 'Ei pääkäyttöoikeuksia')); 
        }
      }  
    }
  }