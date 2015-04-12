<?php

	class AsiakasController extends BaseController{
		
		// hakee kaikki asiakkaat 

		public static function index(){
			$asiakkaat = Asiakas::all();
			View::make('asiakas/asiakaslista.html', array('asiakkaat' => $asiakkaat));
		}

		// hakee asiakkaan id:llä

		public static function asiakastiedot($id){
			$haettuasiakas = Asiakas::findById($id);
      		View::make('asiakas/asiakas.html', array('haettuasiakas' => $haettuasiakas));
    	}

      // tallentaa

      public static function store(){
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
        $errors = array();    //$asiakas->errors(); <- validointi!!!

        if(count($errors) == 0){
          $asiakas->save();
          Redirect::to('/asiakas/' . $asiakas->id);
        } else {
          View::make('/asiakas/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }

      }

    	// ohjaa uudelle lomakkeelle

    	public static function create(){
    		View::make('asiakas/new.html');
    	}

      // edit: ei toimi

      public static function edit($id){
        $asiakas = Asiakas::findById($id);
        View::make('asiakas/' . $asiakas->id, array('attributes' => $kiinteisto));
      }

      // update: ei toimi

      public static function update($id){
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
        $errors = array();    //$asiakas->errors(); <- validointi!!!

        if(count($errors) == 0){
          $asiakas->update();
          Redirect::to('/asiakas/' . $asiakas->id);
        } else {
          View::make('/asiakas/' . $asiakas->id, array('errors' => $errors, 'attributes' => $attributes));
        }

      }


    	// destroy

    	public static function destroy($id){
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