<?php

	class KiinteistoController extends BaseController{
		
		// hakee kaikki kiinteistöt
		public static function index() {
			$kiinteistot = Kiinteisto::all();
			View::make('kiinteisto/kiinteistolista.html', array('kiinteistot' => $kiinteistot));
		}

		//hakee kiinteistön ID:n perusteella ja näyttää sen Kiinteistön omalla sivulla.

		public static function kiinteisto($id) {
			$haettukiinteisto = Kiinteisto::findById($id);
			View::make('kiinteisto/kiinteiston_esittely.html', array('haettukiinteisto' => $haettukiinteisto));
		}

		public static function store(){
			$params = $_POST;

			$kiinteisto = new Kiinteisto(array(
				'nimi' => $params['nimi'],
				'katuosoite' => $params['katuosoite'],
				'postinumero' => $params['postinumero'],
				'postitoimipaikka' => $params['postitoimipaikka']
				));
			
			//Kint::dump($params); 
			$kiinteisto->save();

			Redirect::to('/kiinteisto/' . $kiinteisto->id);
		}

		public static function create() {
			View::make('kiinteisto/new.html');
		}

		public static function edit($id){
  			$kiinteisto = Kiinteisto::findById($id);
  			View::make('kiinteisto/edit.html', array('attributes' => $kiinteisto));
  		}

  		public static function update($id){
  			$params = $_POST;

  			$attributes = array(
  				'id' => $params['id'],
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

  		public static function destroy($id){
  			$kiinteisto = new Kiinteisto(array('id' => $id));
  			//$kiinteisto->destroy();
  			Redirect::to('/kiinteisto', array('message' => "Kiinteistön poistaminen onnistui"));

  		}
}