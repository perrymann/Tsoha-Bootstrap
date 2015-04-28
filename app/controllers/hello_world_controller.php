<?php
  
  class HelloWorldController extends BaseController{

    public static function index(){
        View::make('index/etusivu.html');
    }

    public static function yllapito(){
        BaseController::check_logged_in();
        BaseController::check_admin();
      View::make('index/yllapito.html');
    }

    // public static function kiinteistot(){
    //   View::make('suunnitelmat/kiinteistolista.html');
    // }

    // public static function varauslista(){
    //   View::make('suunnitelmat/varauslista.html');
    // }

    // public static function sandbox(){
    //   $testikiinteisto = new Kiinteisto(array(
    //     'nimi' => 'As Oy',
    //     'katuosoite' => 'Testikatu',
    //     'postinumero' => '000000',
    //     'postitoimipaikka' => 'Ii'  

    //   ));
    //   $errors = $testikiinteisto->errors();

    //   Kint::dump($errors);
    // }

} 
