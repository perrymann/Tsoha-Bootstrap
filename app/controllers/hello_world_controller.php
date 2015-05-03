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
} 
