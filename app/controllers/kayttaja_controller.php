<?php

class KayttajaController extends BaseController{

  	public static function login(){
  		View::make('kayttaja/login.html');
  	}

  	public static function handle_login(){
  		$params = $_POST;

  		$kayttaja = Kayttaja::authenticate($params['tunnus'], $params['salasana']);

  		if(!$kayttaja){
  			View::make('kayttaja/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'tunnus' => $params['tunnus']));
  		} else {
  			$_SESSION['kayttaja'] = $kayttaja->id;

  			Redirect::to('/', array('message' => 'Tervetuloa takaisin, ' . $kayttaja->nimi . '!'));
  		}
  	}

  	public static function logout(){
        $_SESSION['kayttaja'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));   
      }

    public static function index(){
    	BaseController::check_logged_in();
    	BaseController::check_admin();
    	$kayttajat = Kayttaja::all();
    	View::make('kayttaja/kayttajat.html', array('kayttajat' => $kayttajat));
    }

    public static function kayttaja($id){
    	BaseController::check_logged_in();
    	BaseController::check_admin();
    	$kayttaja = Kayttaja::findById($id);
    	View::make('kayttaja/kayttaja.html', array('kayttaja' => $kayttaja));
    }

    public static function create(){
    	BaseController::check_logged_in();
    	BaseController::check_admin();
    	View::make('kayttaja/new.html');
    }

    public static function store(){
    	BaseController::check_logged_in();
    	BaseController::check_admin();
    	$params = $_POST;

      if (isset($_POST['paakaytto'])) {
        $paakaytto = 1;
      } else {
        $paakaytto = 0;
      } 

		$attributes = array(
			'nimi' => $params['nimi'],
			'tunnus' => $params['tunnus'],
			'salasana' => $params['salasana'],
			'paakaytto' => $paakaytto
			);
		
		$kayttaja = new Kayttaja($attributes);
		$errors = $kayttaja->errors();

		if(count($errors) == 0){
			$kayttaja->save();
			Redirect::to('/kayttaja', array('message' => "Käyttäjä lisätty onnistuneesti!"));
		} else {
			View::make('/kayttaja/new.html', array('errors' => $errors, 'attributes' => $attributes));
		}
    }

    public static function update($id){
        BaseController::check_logged_in();
        BaseController::check_admin();
        $params = $_POST;

        if (isset($_POST['paakaytto'])) {
    		$paakaytto = 1;
    	} else {
    		$paakaytto = 0;
    	}	

        $attributes = array(
          'id' => $id,
          'nimi' => $params['nimi'],
          'tunnus' => $params['tunnus'],
          'salasana' => $params['salasana'],
          'paakaytto' => $paakaytto         
          );

        $kayttaja = new Kayttaja($attributes);
        $errors = $kayttaja->errors();

        if(count($errors) == 0){
          $kayttaja->update();
          Redirect::to('/kayttaja', array('message' => "Käyttäjän muokkaus onnistui"));
        } else {
          View::make('/kayttaja/kayttaja.html', array('errors' => $errors, 'kayttaja' => $attributes));
        }
	  }

    public static function destroy($id){
        BaseController::check_logged_in();
        BaseController::check_admin();
        $kayttaja = new Kayttaja(array('id' => $id));
        $kayttaja->destroy();
        Redirect::to('/kayttaja', array('message' => "Käyttäjän poistaminen onnistui"));

    }

}