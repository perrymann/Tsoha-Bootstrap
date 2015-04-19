<?php

	class VarausController extends BaseController {

		// tallentaa varauksen
		public static function store($autopaikka_id){
			BaseController::check_logged_in();
			$params = $_POST;
			$asiakas_id = $params['asiakas'];

			if ($params['paattymis_pvm'] === ""){
				$paattymis_pvm = null;
			} else {
				$paattymis_pvm = $params['paattymis_pvm'];
			}

			$attributes = array(
				'autopaikka_id' => $autopaikka_id, 
				'asiakas_id' => $asiakas_id, 
				'aloitus_pvm' => $params['aloitus_pvm'], 
				'paattymis_pvm' => $paattymis_pvm
				);
			
			$varaus = new Varaus($attributes);
			$errors = array();  //$errors = $varaus->errors();

			if(count($errors) == 0){
				$varaus->save();
				Redirect::to('/kiinteisto');
			} else {
				View::make('/varaus/new.html', array('errors' => $errors, 'attributes' => $attributes) );
			}
		}

		public static function create($id){
			BaseController::check_logged_in();
			$autopaikka = Autopaikka::findById($id);
			$asiakkaat = Asiakas::all();
			View::make('/varaus/new.html', array('autopaikka' => $autopaikka, 'asiakkaat' => $asiakkaat));
		}		

		public static function update($id){
			BaseController::check_logged_in();
			$params = $_POST;

			$attributes = array(
				'id' => $id,
				'autopaikka_id' => $params['autopaikka_id'], 
				'asiakas_id' => $params['asiakas_id'], 
				'aloitus_pvm' => $params['aloitus_pvm'], 
				'paattymis_pvm' => $params['paattymis_pvm']
				);

			$varaus = new Kiinteisto($attributes);
			$errors = $varaus->errors();

			if (count($errors) > 0) {
				View::make('/varaus/new.html', array('errors' => $errors, 'attributes' => $attributes) );
			} else {
  				$varaus->update();

  				// tämä pitää vielä merkitä näkymään sitten kun metodi toimii...
  				Redirect::to('/autopaikka/' . $kiinteisto->id, array('message' => "Varauksen muokkaus onnistui"));
  			}

		}




		
	}