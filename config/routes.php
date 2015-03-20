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

  $routes->get('/kiinteistot', function(){
  	HelloWorldController::kiinteistot();
  });

  $routes->get('/varauslista', function(){
  	HelloWorldController::varauslista();
  });

  $routes->get('/asiakastiedot', function(){
  	HelloWorldController::asiakastiedot();
  });
