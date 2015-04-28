<?php

	class KiinteistoController extends BaseController{
		
		// hakee kaikki kiinteistöt

		public static function index() {
			BaseController::check_logged_in();
			// $params = $_GET;
			// $options = array()

			// if(isset($params['search'])){
   //   			$options['search'] = $params['search'];
   //  		}
			// $kiinteistot = Kiinteisto::all($options);
			$kiinteistot = Kiinteisto::all();
			View::make('kiinteisto/kiinteistolista.html', array('kiinteistot' => $kiinteistot));
		}

		// hakee kiinteistön id:llä

		public static function kiinteisto($id) {
			BaseController::check_logged_in();
			$haettukiinteisto = Kiinteisto::findById($id);
			$autopaikat = Kiinteisto::getParkingBoxes($id);
			View::make('kiinteisto/kiinteiston_esittely.html', array('haettukiinteisto' => $haettukiinteisto, 'autopaikat' => $autopaikat));
		}

 		// tallentaa

		public static function store(){
			BaseController::check_logged_in();
			BaseController::check_admin();
			$params = $_POST;

			$attributes = array(
				'nimi' => $params['nimi'],
				'katuosoite' => $params['katuosoite'],
				'postinumero' => $params['postinumero'],
				'postitoimipaikka' => $params['postitoimipaikka']
				);
			
			$kiinteisto = new Kiinteisto($attributes);
			$errors = $kiinteisto->errors();

			if(count($errors) == 0){
				$kiinteisto->save();
				Redirect::to('/kiinteisto/' . $kiinteisto->id, array('message' => "Kiinteistön luonti onnistui"));
			} else {
				View::make('/kiinteisto/new.html', array('errors' => $errors, 'attributes' => $attributes) );
			}

		}

		// ohjaa uudelle lomakkeelle

		public static function create() {
			BaseController::check_logged_in();
			BaseController::check_admin();
			View::make('kiinteisto/new.html');
		}

		// edit

		public static function edit($id){
			BaseController::check_logged_in();
			BaseController::check_admin();
  			$kiinteisto = Kiinteisto::findById($id);
  			View::make('kiinteisto/edit.html', array('attributes' => $kiinteisto));
  		}

  		// update

  		public static function update($id){
  			BaseController::check_logged_in();
  			BaseController::check_admin();
  			$params = $_POST;

  			$attributes = array(
  				'id' => $id,
  				'nimi' => $params['nimi'],
				'katuosoite' => $params['katuosoite'],
				'postinumero' => $params['postinumero'],
				'postitoimipaikka' => $params['postitoimipaikka']
				);

  			$kiinteisto = new Kiinteisto($attributes);
  			$errors = $kiinteisto->errors();

  			if (count($errors) > 0) {
  				View::make('kiinteisto/edit.html', array('errors' => $errors, 'attributes' => $attributes));
  			} else {
  				$kiinteisto->update();

  				Redirect::to('/kiinteisto/' . $kiinteisto->id, array('message' => "Kiinteistön muokkaus onnistui"));
  			}
  		}

  		// destroy

  		public static function destroy($id){
  			BaseController::check_logged_in();
  			BaseController::check_admin();
  			$kiinteisto = new Kiinteisto(array('id' => $id));
  			$kiinteisto->destroy();
  			Redirect::to('/kiinteisto', array('message' => "Kiinteistön poistaminen onnistui"));

  		}
  		
}