<?php

	class AsiakasController extends BaseController{
		
		// hakee kaikki asiakkaat 

		public static function index(){
            BaseController::check_logged_in();
			$asiakkaat = Asiakas::all();
			View::make('asiakas/asiakaslista.html', array('asiakkaat' => $asiakkaat));
		}

		// hakee asiakkaan id:llä

		public static function asiakastiedot($id){
            BaseController::check_logged_in();
			$asiakas = Asiakas::findById($id);
      		View::make('asiakas/asiakas.html', array('asiakas' => $asiakas));
    	}

        // tallentaa

        public static function store(){
            BaseController::check_logged_in();
            $params = $_POST;
         
            $attributes = array(
                'etunimi' => $params['etunimi'],
                'sukunimi' => $params['sukunimi'],
                'puhelinnumero' => $params['puhelinnumero'],
                'email' => $params['email'],
                'katuosoite' => $params['katuosoite'],
                'postinumero' => $params['postinumero'],
                'postitoimipaikka' => $params['postitoimipaikka']
                );

            $asiakas = new Asiakas($attributes);
            $errors = $asiakas->errors();

            if(count($errors) == 0){
                $asiakas->save();
                Redirect::to('/asiakas/' . $asiakas->id);
            } else {
                View::make('/asiakas/new.html', array('errors' => $errors, 'attributes' => $attributes));
            }
        }

    	public static function create(){
        BaseController::check_logged_in();
    		View::make('asiakas/new.html');
    	}

        public static function edit($id){
            BaseController::check_logged_in();
            $asiakas = Asiakas::findById($id);
            View::make('asiakas/' . $asiakas->id, array('attributes' => $kiinteisto));
        }

        public static function update($id){
            BaseController::check_logged_in();
            $params = $_POST;

            $attributes = array(
                'id' => $id,
                'etunimi' => $params['etunimi'],
                'sukunimi' => $params['sukunimi'],
                'puhelinnumero' => $params['puhelinnumero'],
                'email' => $params['email'],
                'katuosoite' => $params['katuosoite'],
                'postinumero' => $params['postinumero'],
                'postitoimipaikka' => $params['postitoimipaikka']
            );

            $asiakas = new Asiakas($attributes);
            $errors = $asiakas->errors();

            if(count($errors) == 0){
                $asiakas->update();
                Redirect::to('/asiakas', array('message' => "Asiakkaan muokkaus onnistui"));
            } else {
                View::make('/asiakas/asiakas.html', array('errors' => $errors, 'asiakas' => $attributes));
            }
        }

    	// destroy

    	public static function destroy($id){
            BaseController::check_logged_in();
    		$asiakas = new Asiakas(array('id' => $id));
    		$asiakas->destroy();
    		Redirect::to('/asiakas', array('message' => "Asiakkaan poisto onnistui"));
    	}

    	// testimetodi

    	public static function sandbox(){
        	$stigu = Asiakas::findById(1);
      		$asiakkaat = Asiakas::all();
      		Kint::dump($stigu);
      		Kint::dump($asiakkaat);
    	}
	}