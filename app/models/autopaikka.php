<?php

class Autopaikka extends BaseModel{
	
	public $id, $kiinteisto_id, $nimi, $tyyppi, $sahkopistoke;

	public function __construct($attributes) {
		parent::__construct($attributes);
		$this->validators = array('validate_name');
	}

	public function validate_name(){
    	$errors = array();
    	if($this->nimi == '' || $this->nimi == null){
      		$errors[] = 'Nimi ei saa olla tyhjä!';
    	} 
    	$autopaikat = Autopaikka::all();
    	foreach($autopaikat as $autopaikka) {
    		if($this->nimi == $autopaikka->nimi && $this->kiinteisto_id == $autopaikka->kiinteisto_id){
    			$errors[] = 'Nimi on jo varattu!';
    		}
    	}
		return $errors;
    } 

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Autopaikka (kiinteisto_id, nimi, tyyppi, sahkopistoke) VALUES (:kiinteisto_id, :nimi, :tyyppi, :sahkopistoke) RETURNING id');
		$query->execute(array('kiinteisto_id' => $this->kiinteisto_id, 'nimi' => $this->nimi, 'tyyppi' => $this->tyyppi, 'sahkopistoke' => $this->sahkopistoke));
		$row = $query->fetch();
		$this->id = $row['id'];
	}

	public function update(){
		$query = DB::connection()->prepare('UPDATE Autopaikka SET kiinteisto_id = :kiinteisto_id, nimi = :nimi, tyyppi = :tyyppi, sahkopistoke = :sahkopistoke WHERE id = :id');
		$query->execute(array('id' => $this->id, 'kiinteisto_id' => $this->kiinteisto_id, 'tyyppi' => $this->tyyppi, 'sahkopistoke' => $this->sahkopistoke));
	}

	public function destroy(){
		$query = DB::connection()->prepare('DELETE FROM Autopaikka WHERE id = :id');
		$query->execute(array('id' => $this->id));
	}

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

	public function findById($id){
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

	public function defineTypeNumber($tyyppi){
		if ($tyyppi == "Avoin paikka"){
			return 1;
		}
		else if ($tyyppi == "Autokatos"){
			return 2;
		}
		else {
			return 3;
		}
	}	

	public function containsSocket(){
		if ($this->sahkopistoke == TRUE){
			return "Kyllä";
		} else {
			return "Ei";
		}
	}

	// hakee paikkaan liittyvät varaukset

	public function getReservationHistory($id){
		$query = DB::connection()->prepare('SELECT * FROM Varaus WHERE autopaikka_id = :id ORDER BY aloitus_pvm DESC');
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
			if ($varaus->isCurrentlyTaken()){
				return $varaus;
			} 
		}	
		return null;
	}

	public function futureReservations(){
		$varaukset = Autopaikka::getReservationHistory($this->id);

		foreach($varaukset as $varaus) {
			if ($varaus->willBeTaken()){
				return $varaus;
			} 
		}	
		return null;
	}
}	