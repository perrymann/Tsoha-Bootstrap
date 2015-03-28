<?php
  
  class HelloWorldController extends BaseController{

    public static function index(){
      View::make('suunnitelmat/etusivu.html');
    }

    public static function sandbox(){
      $stigu = Asiakas::findById(1);
      $asiakkaat = Asiakas::all();

      Kint::dump($stigu);
      Kint::dump($asiakkaat);
    }

    public static function login(){
      View::make('suunnitelmat/login.html');
    }

    public static function kiinteistot(){
      View::make('suunnitelmat/kiinteistolista.html');
    }

    public static function varauslista(){
      View::make('suunnitelmat/varauslista.html');
    }

    public static function asiakastiedot(){
      View::make('suunnitelmat/asiakas.html');
    }
    
} 
