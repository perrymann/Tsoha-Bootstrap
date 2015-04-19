<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/yllapito', function(){
   HelloWorldController::yllapito();
  });

  // $routes->get('/sandbox', function(){
  //   HelloWorldController::sandbox();
  // });

  // -------- Kiinteistokontroller -------------------
   
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

  // AsiakasController -------------------------

  $routes->get('/asiakas', function(){
    AsiakasController::index();
  });

  $routes->post('/asiakas', function(){
    AsiakasController::store();
  });

  $routes->get('/asiakas/new', function(){
    AsiakasController::create();
  });

  $routes->get('/asiakas/:id', function($id){
    AsiakasController::asiakastiedot($id);
  });

  $routes->post('/asiakas/:id/destroy', function($id){
    AsiakasController::destroy($id);
  });

  $routes->get('/hiekkalaatikko', function() {
    AsiakasController::sandbox();
  });

  $routes->post('/asiakas/:id/edit', function($id){
    AsiakasController::update($id);
  });

  // KayttajaController

  $routes->get('/login', function() {
    KayttajaController::login();
  });

  $routes->post('/login', function(){
    KayttajaController::handle_login();
  });

  $routes->post('/logout', function(){
    KayttajaController::logout();
  });

  $routes->get('/kayttaja', function(){
    KayttajaController::index();
  });

  $routes->post('/kayttaja', function(){
    KayttajaController::store();
  });

  $routes->get('/kayttaja/new', function(){
    KayttajaController::create();
  });

  $routes->get('/kayttaja/:id', function($id){
    KayttajaController::kayttaja($id);
  });
  
  // AutopaikkaController

  $routes->get('/autopaikka/:id', function($id){
    AutopaikkaController::autopaikka($id);
  });

  // Varauskontroller

  $routes->get('/autopaikka/:id/varaus/new', function($id){
    VarausController::create($id);
  });

  $routes->post('/autopaikka/:id/varaus/new', function($id){
    VarausController::store($id);
  });



  


