<?php

	class AutopaikkaController extends BaseController{

		public static function index() {
			BaseController::check_logged_in();
			$autopaikat = Autopaikka::all();
			View::make('autopaikka/autopaikkalista.html', array('autopaikat' => $autopaikat));
		}

		// haetaan yksittäinen autopaikka ja siihen liittyvät varaukset

		public static function autopaikka($id) {
			BaseController::check_logged_in();
			$autopaikka = Autopaikka::findById($id);
			$varaukset = Autopaikka::getReservationHistory($id);
			View::make('autopaikka/autopaikka.html', array('autopaikka' => $autopaikka, 'varaukset' => $varaukset));
		}

		public static function store() {
			BaseController::check_logged_in();
			$params =$_POST;
			$kiinteisto_id = $params['kiinteisto'];
			$tyyppi = $params['tyyppi'];
			
			if (isset($_POST['sahkopistoke'])) {
    			$sahkopistoke = 1;
    		} else {
    			$sahkopistoke = 0;
    		}	

			$attributes = array(
				'kiinteisto_id' => $kiinteisto_id,
				'numero' => $params['numero'],
				'tyyppi' => $tyyppi,
				'sahkopistoke' => $sahkopistoke
				);

			$autopaikka = new Autopaikka($attributes);
			$errors = $autopaikka->errors();

			if(count($errors) == 0){
				$autopaikka->save();
				Redirect::to('/autopaikka/' . $autopaikka->id);
			} else {
				Redirect::to('/autopaikka/new', array('errors' => $errors, 'autopaikka' => $attributes));
			}

		}

		public static function update($id){
  			BaseController::check_logged_in();
  			BaseController::check_admin();
  			$params = $_POST;
  			$kiinteisto_id = $params['kiinteisto_id'];
			$tyyppi = $params['tyyppi'];
			
			if (isset($_POST['sahkopistoke'])) {
    			$sahkopistoke = 1;
    		} else {
    			$sahkopistoke = 0;
    		}	

  			$attributes = array(
  				'id' => $id,
  				'kiinteisto_id' => $kiinteisto_id,
  				'numero' => $params['numero'],
				'tyyppi' => $tyyppi,
				'sahkopistoke' => $sahkopistoke
				);

  			$autopaikka = new Autopaikka($attributes);
  			$errors = $autopaikka->errors();

  			if (count($errors) > 0) {
  				View::make('autopaikka/edit.html', array('errors' => $errors, 'autopaikka' => $attributes));
  			} else {
  				$autopaikka->update();
  				Redirect::to('/autopaikka/' . $autopaikka->id, array('message' => "Autopaikan muokkaus onnistui"));
  			}
  		}

		public static function create() {
			BaseController::check_logged_in();
			BaseController::check_admin();
			$kiinteistot = Kiinteisto::all();
			View::make('autopaikka/new.html', array('kiinteistot' => $kiinteistot));
			 
		}

		public static function edit($id) {
			BaseController::check_logged_in();
			$autopaikka = Autopaikka::findById($id);
			View::make('autopaikka/edit.html', array('autopaikka' => $autopaikka));

		}

		public static function destroy($id){
			BaseController::check_logged_in();
			BaseController::check_admin();
			$apu = Autopaikka::findById($id)->kiinteisto_id;
			$autopaikka =  new Autopaikka(array('id' => $id));
			$autopaikka->destroy();
			Redirect::to('/kiinteisto/' . $apu, array('message' => "Autopaikan poisto onnistui"));

		}	
	}