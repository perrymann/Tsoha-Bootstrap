<?php

	class KiinteistoController extends BaseController{
		
		// hakee kaikki kiinteistöt

		public static function index() {
			$kiinteistot = Kiinteisto::all();
			View::make('kiinteisto/kiinteistolista.html', array('kiinteistot' => $kiinteistot));
		}

		// hakee kiinteistön id:llä

		public static function kiinteisto($id) {
			$haettukiinteisto = Kiinteisto::findById($id);
			View::make('kiinteisto/kiinteiston_esittely.html', array('haettukiinteisto' => $haettukiinteisto));
		}

		// hakee kiinteistön osoitteella

		public static function kiinteistoOsoitteella($katuosoite) {
			$haettukiinteisto = Kiinteisto::findByAddress($katuosoite);
			View::make('kiinteisto/kiinteistolista.html', array('haettukiinteisto' => $haettukiinteisto));
		}

		// tallentaa

		public static function store(){
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
				Redirect::to('/kiinteisto/' . $kiinteisto->id);
			} else {
				View::make('/kiinteisto/new.html', array('errors' => $errors, 'attributes' => $attributes) );
			}

		}

		// ohjaa uudelle lomakkeelle

		public static function create() {
			View::make('kiinteisto/new.html');
		}

		// edit

		public static function edit($id){
  			$kiinteisto = Kiinteisto::findById($id);
  			View::make('kiinteisto/edit.html', array('attributes' => $kiinteisto));
  		}

  		// update

  		public static function update($id){
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

  				// tämä pitää vielä merkitä näkymään sitten kun metodi toimii...
  				Redirect::to('/kiinteisto/' . $kiinteisto->id, array('message' => "Kiinteistön muokkaus onnistui"));
  			}
  		}

  		// destroy

  		public static function destroy($id){
  			$kiinteisto = new Kiinteisto(array('id' => $id));
  			$kiinteisto->destroy();
  			Redirect::to('/kiinteisto', array('message' => "Kiinteistön poistaminen onnistui"));

  		}
  		
}