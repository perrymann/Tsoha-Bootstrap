<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/yllapito', function(){
   HelloWorldController::yllapito();
  });

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

  $routes->post('/asiakas/:id', function($id){
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
  
  $routes->post('/kayttaja/:id', function($id){
    KayttajaController::update($id);
  });

  $routes->post('/kayttaja/:id/destroy', function($id){
    KayttajaController::destroy($id);
  });


  // AutopaikkaController

  $routes->get('/autopaikka', function(){
    AutopaikkaController::index();
  });

  $routes->post('/autopaikka', function(){
    AutopaikkaController::store();
  });

  $routes->get('/autopaikka/new', function(){
    AutopaikkaController::create();
  });
 
  $routes->get('/autopaikka/:id', function($id){
    AutopaikkaController::autopaikka($id);
  });

   $routes->get('/autopaikka/:id/edit', function($id){
    AutopaikkaController::edit($id);
  });

  $routes->post('/autopaikka/:id/edit', function($id){
    AutopaikkaController::update($id);
  });

  $routes->post('/autopaikka/:id/destroy', function($id){
    AutopaikkaController::destroy($id);
  });

  // Varauskontroller

  $routes->get('/autopaikka/:id/varaus/new', function($id){
    VarausController::create($id);
  });

  $routes->post('/autopaikka/:id/varaus/new', function($id){
    VarausController::store($id);
  });

  $routes->get('/varaus/:id', function($id){
    VarausController::varaus($id);
  });

  $routes->post('/varaus/:id', function($id){
    VarausController::update($id);
  });

  $routes->post('/varaus/:id/destroy', function($id){
    VarausController::destroy($id);
  });