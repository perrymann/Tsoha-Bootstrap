<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/login', function() {
  	HelloWorldController::login();
  });

  $routes->get('/varauslista', function(){
  	HelloWorldController::varauslista();
  });

  $routes->get('/asiakastiedot', function(){
  	HelloWorldController::asiakastiedot();
  });

  // Kiinteistokontroller

  $routes->get('/', function(){
    KiinteistoController::index();
  });

  $routes->get('/kiinteisto', function(){
    KiinteistoController::index();
  });

  $routes->post('/kiinteisto', function(){
    KiinteistoController::store();
  });

  $routes->get('/kiinteisto/new', function(){
    KiinteistoController::create();
  });

  $routes->get('/kiinteisto/:id', function($id){
    KiinteistoController::kiinteisto($id);
  });

  $routes->get('/kiinteisto/:id/edit', function($id){
    KiinteistoController::edit($id);
  });

  $routes->post('/kiinteisto/:id/edit', function($id){
    KiinteistoController::update($id);
  });

  $routes->post('/kiinteisto/:id/destroy', function($id){
    KiinteistoController::destroy($id);
  });

  //Ap_alueController

  $routes->get('/ap_alue', function(){
    Ap_alueController::index();


    
  });


