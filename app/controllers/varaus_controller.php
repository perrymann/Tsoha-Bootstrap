<?php

	class VarausController extends BaseController {

		public static function varaus($id){
			BaseController::check_logged_in();
			$varaus = Varaus::findById($id);
			View::make('varaus/varaus.html', array('varaus' => $varaus));
		}

		public static function store($autopaikka_id){
			BaseController::check_logged_in();
			$params = $_POST;
			$asiakas_id = $params['asiakas'];

			if ($params['paattymis_pvm'] === ''){
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
			$errors = $varaus->errors();

			if(count($errors) == 0){
				$varaus->save();
				Redirect::to('/autopaikka/' . $varaus->autopaikka_id, array('message' => "Varauksen luonti onnistui"));
			} else {
				$asiakkaat = Asiakas::all();
				$autopaikka = Autopaikka::findById($autopaikka_id);
				View::make('/varaus/new.html', array('errors' => $errors, 'attributes' => $attributes, 'asiakkaat' => $asiakkaat, 'autopaikka' => $autopaikka));
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

			if ($params['paattymis_pvm'] === ''){
				$paattymis_pvm = null;
			} else {
				$paattymis_pvm = $params['paattymis_pvm'];
			}

			$attributes = array(
				'id' => $id,
				'autopaikka_id' => $params['autopaikka_id'], 
				'asiakas_id' => $params['asiakas_id'], 
				'aloitus_pvm' => $params['aloitus_pvm'], 
				'paattymis_pvm' => $paattymis_pvm
				);

			$varaus = new Varaus($attributes);
			$errors = $varaus->errors();

			if (count($errors) > 0) {
				View::make('/varaus/varaus.html', array('errors' => $errors, 'varaus' => $attributes) );
			} else {
  				$varaus->update();

				Redirect::to('/autopaikka/' . $varaus->autopaikka_id, array('message' => "Varauksen muokkaus onnistui"));
  			}

		}

		public static function destroy($id){
			BaseController::check_logged_in();
			$apu = Varaus::findById($id)->autopaikka_id;
			$varaus = new Varaus(array('id' => $id));
			$varaus->destroy();
			Redirect::to('/autopaikka/' . $apu, array('message' => 'Varauksen poisto onnistui!'));
		}




		
	}