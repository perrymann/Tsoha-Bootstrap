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

		//OK

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
}