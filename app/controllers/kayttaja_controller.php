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

		$attributes = array(
			'nimi' => $params['nimi'],
			'tunnus' => $params['tunnus'],
			'salasana' => $params['salasana'],
			'paakaytto' => $params['paakaytto']
			);
		
		$kayttaja = new Kayttaja($attributes);
		$errors = $kayttaja->errors();

		if(count($errors) == 0){
			$kayttaja->save();
			Redirect::to('/kayttaja/' . $kayttaja->id);
		} else {
			View::make('/kayttaja/new.html', array('errors' => $errors, 'attributes' => $attributes) );
		}
    }

}