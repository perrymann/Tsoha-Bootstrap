<?php

class Asiakas extends BaseModel{
	
	public $id, $etunimi, $sukunimi, $puhelinnumero, $email, $katuosoite, $postinumero, $postitoimipaikka;

	public function __construct($attributes){
    	parent::__construct($attributes);
  	}

  	public static function all() {
  		$query = DB::connection()->prepare('SELECT * FROM Asiakas');
	  	$query->execute();
	  	$rows = $query->fetchAll();
	  	$asiakkaat = array();

	  	foreach ($rows as $row) {
	  		$asiakkaat[] = new Asiakas(array(
	  			'id' => $row['id'],
	  			'etunimi' => $row['etunimi'],
	  			'sukunimi' => $row['sukunimi'],
	  			'puhelinnumero' => $row['puhelinnumero'],
	  			'email' => $row['email'],
	  			'katuosoite' => $row['katuosoite'],
	  			'postinumero' => $row['postinumero'],
	  			'postitoimipaikka' => $row['postitoimipaikka']
			));	
	  	}
	  	return $asiakkaat;
	}

	public static function findById($id) {
		$query = DB::connection()->prepare('SELECT * FROM Asiakas WHERE id = :id LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if($row) {
			$asiakkaat = new Asiakas(array(
	        'id' => $row['id'],
	        'etunimi' => $row['etunimi'],
	        'sukunimi' => $row['sukunimi'],
	        'puhelinnumero' => $row['puhelinnumero'],
	        'email' => $row['email'],
	        'katuosoite' => $row['katuosoite'],
	        'postinumero' => $row['postinumero'],
	        'postitoimipaikka' => $row['postitoimipaikka']
      		));
      		return $asiakkaat;
		}	
      	return null;
    }
}
  
