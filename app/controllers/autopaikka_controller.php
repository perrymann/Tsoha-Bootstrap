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
			$_params =$_POST;

			$attributes = array(
				'kiinteisto_id' => $params['kiinteisto_id'],
				'nimi' => $params['nimi'],
				'tyyppi' => $params['tyyppi'],
				'sahkopistoke' => $params['sahkopistoke']
				);

			// validointi puuttuu!

			$autopaikka = new Autopaikka($attributes);

			$autopaikka->save();
			Redirect::to('/kiinteisto' . $kiinteisto_id);

		}

		public static function create() {
			BaseController::check_logged_in();
			View::make('autopaikka/new.html');
			 
		}

		public static function edit($id) {
			BaseController::check_logged_in();
			$autopaikka = Autopaikka::findById($id);
			View::make('autopaikka/' . $autopaikka->id, array('attributes' => $autopaikka));

		}

	}