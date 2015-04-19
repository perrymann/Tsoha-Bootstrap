<?php

class Autopaikka extends BaseModel{
	
	public $id, $kiinteisto_id, $nimi, $tyyppi, $sahkopistoke;

	public function __construct($attributes) {
		parent::__construct($attributes);
	}

	//validoinnit puuttuu

	public static function all(){
		$query = DB::connection()->prepare('SELECT * FROM Autopaikka');
		$query->execute();
		$rows = $query->fetchAll();
		$autopaikat = array();

		foreach($rows as $row) {
			$autopaikat[] = new Autopaikka(array(
			'id' => $row['id'],
			'kiinteisto_id' => $row['kiinteisto_id'],
			'nimi' => $row['nimi'],
			'tyyppi' => $row['tyyppi'],
			'sahkopistoke' => $row['sahkopistoke']
			));
		}
		return $autopaikat;
	}

	public static function findById($id){
		$query = DB::connection()->prepare('SELECT * FROM Autopaikka WHERE id = :id LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if ($row) {
			$autopaikka = new Autopaikka(array(
				'id' => $row['id'],
				'kiinteisto_id' => $row['kiinteisto_id'],
				'nimi' => $row['nimi'],
				'tyyppi' => $row['tyyppi'],
				'sahkopistoke' => $row['sahkopistoke']
				));
		}
		return $autopaikka;
	}

	public function defineType(){
		if ($this->tyyppi == 1){
			return "Avoin paikka";
		}
		else if ($this->tyyppi == 2){
			return "Autokatos";
		}
		else {
			return "Autohalli";
		}
	}	

	public function containsSocket(){
		if ($this->sahkopistoke == TRUE){
			return "on";
		}
	}

	// hakee paikkaan liittyvät varaukset

	public function getReservationHistory($id){
		$query = DB::connection()->prepare('SELECT * FROM Varaus WHERE autopaikka_id = :id');
		$query->execute(array('id' => $id));
		$rows = $query->fetchAll();
		$varaukset = array();

		foreach($rows as $row) {
			$varaukset[] = new Varaus(array(
			'id' => $row['id'],
			'autopaikka_id' => $row['autopaikka_id'], 
			'asiakas_id' => $row['asiakas_id'], 
			'aloitus_pvm' => $row['aloitus_pvm'], 
			'paattymis_pvm' => $row['paattymis_pvm']
			));
		}
		return $varaukset;
	}

	// metodi, joka hakee voimassa olevan varauksen, palauttaa null jos vapaa tällä hetkellä

	public function isReserved() {
		$varaukset = Autopaikka::getReservationHistory($this->id);

		foreach($varaukset as $varaus) {
			if ($varaus->isValid()){
				//Kint::dump($varaus);
				return $varaus;
			} 
		}	
		return null;
	}

}	