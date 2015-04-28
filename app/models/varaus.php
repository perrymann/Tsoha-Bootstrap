<?php

class Varaus extends BaseModel{
	
	public $id, $autopaikka_id, $asiakas_id, $aloitus_pvm, $paattymis_pvm, $varaus_pvm, $irtisanomis_pvm;

	public function __construct($attributes){
		parent::__construct($attributes);
		$this->validators = array('validate_enddate', 'validReservationDate');
	}

	// mallin validoinnit

	// "päättymispäivä ei ennen aloituspäivää"

	public function validate_enddate(){
		$errors = array();
		if(!$this->paattymis_pvm == '' || !$this->paattymis_pvm == null){
			if($this->aloitus_pvm > $this->paattymis_pvm){
				$errors[] = "Päättymispäivän on oltava aloituspäivän jälkeen!";
			}
		}
		return $errors;
	}

	// "varaus ei menee päällekkäin"

	public function validReservationDate(){
		$errors = array();
		$varaukset = Autopaikka::getReservationHistory($this->autopaikka_id);
		foreach($varaukset as $varaus){
			if ($this->paattymis_pvm == null) {
				$paattymis_pvm = $this->paattymis_pvm;
				$paattymis_pvm = date('9999-12-31');
			} else {
				$paattymis_pvm = $this->paattymis_pvm;
			}	 
			if ($this->aloitus_pvm > $varaus->aloitus_pvm && ($varaus->paattymis_pvm == '' || $varaus->paattymis_pvm == null)) {
				$errors[] = "Paikassa on toistaiseksi voimassa oleva varaus!";
			} 
			if ($this->aloitus_pvm >= $varaus->aloitus_pvm && $this->aloitus_pvm <= $varaus->paattymis_pvm && $this->id != $varaus->id){
				$errors[] = "Paikka on varattu tällä aikavälillä! -- 1";
			}
			if ($paattymis_pvm >= $varaus->paattymis_pvm && $this->aloitus_pvm <= $varaus->paattymis_pvm && $this->id != $varaus->id){
				$errors[] = "Paikka on varattu tällä aikavälillä! -- 2";
			}
			if ($this->aloitus_pvm < $varaus->aloitus_pvm && $paattymis_pvm >= $varaus->aloitus_pvm){
				$errors[] = "Paikka on varattu tällä aikavälillä! -- 3";
				
			}
		}
		return $errors;
	} 

	// mallin varsinaiset metodit....

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Varaus (autopaikka_id, asiakas_id, aloitus_pvm, paattymis_pvm) VALUES (:autopaikka_id, :asiakas_id, :aloitus_pvm, :paattymis_pvm) RETURNING id');
		$query->execute(array('autopaikka_id' => $this->autopaikka_id, 'asiakas_id' => $this->asiakas_id, 'aloitus_pvm' => $this->aloitus_pvm, 'paattymis_pvm' => $this->paattymis_pvm));
		$row = $query->fetch();
		$this->id = $row['id'];
	}

	public function update(){
  		$query = DB::connection()->prepare('UPDATE Varaus SET autopaikka_id = :autopaikka_id, asiakas_id = :asiakas_id, aloitus_pvm = :aloitus_pvm, paattymis_pvm = :paattymis_pvm WHERE id = :id');
		$query->execute(array('id' => $this->id, 'autopaikka_id' => $this->autopaikka_id, 'asiakas_id' => $this->asiakas_id, 'aloitus_pvm' => $this->aloitus_pvm, 'paattymis_pvm' => $this->paattymis_pvm));
	}

	public function destroy(){
		$query = DB::connection()->prepare('DELETE FROM Varaus WHERE id = :id');
		$query->execute(array('id' => $this->id));
	}

	public static function all(){
		$query = DB::connection()->prepare('SELECT * FROM Varaus');
		$query->execute();
		$rows = $query->fetchAll();
		$varaukset = array();

		foreach($rows as $row) {
			$varaukset[] = new Varaus(array(
			'id' => $row['id'],
			'autopaikka_id' => $row['autopaikka_id'], 
			'asiakas_id' => $row['asiakas_id'], 
			'aloitus_pvm' => $row['aloitus_pvm'], 
			'paattymis_pvm' => $row['paattymis_pvm'], 
			));
		}
		return $varaukset;
	}

	public static function findById($id){
		$query = DB::connection()->prepare('SELECT * FROM Varaus WHERE id = :id LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if ($row) {
			$varaus = new Varaus(array(
				'id' => $row['id'],
				'autopaikka_id' => $row['autopaikka_id'], 
				'asiakas_id' => $row['asiakas_id'], 
				'aloitus_pvm' => $row['aloitus_pvm'], 
				'paattymis_pvm' => $row['paattymis_pvm'], 
				));
			return $varaus;
		} else {
			return null;
		}
	}

	// metodi joka hakee varaajan...sama kuin Asiakas-luokan metodi mutta "pakko" olla myös tässä

	public function getCustomerInfo(){
		$query = DB::connection()->prepare('SELECT * FROM Asiakas WHERE id = :id LIMIT 1');
		$query->execute(array('id' => $this->asiakas_id));
		$row = $query->fetch();

		if($row) {
			$varaaja = new Asiakas(array(
	        'id' => $row['id'],
	        'etunimi' => $row['etunimi'],
	        'sukunimi' => $row['sukunimi'],
	        'puhelinnumero' => $row['puhelinnumero'],
	        'email' => $row['email'],
	        'katuosoite' => $row['katuosoite'],
	        'postinumero' => $row['postinumero'],
	        'postitoimipaikka' => $row['postitoimipaikka']
      		));
      		return $varaaja;
			
		}	
      	return null;
	}

 	public function getParkingBoxName($id){
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
		return $autopaikka->nimi;
 	}

	public function isCurrentlyTaken(){
		$today = date("Y-m-d");
		if ((($this->paattymis_pvm == null || $this->paattymis_pvm == '') && $this->aloitus_pvm < $today) || ($this->paattymis_pvm > $today && $this->aloitus_pvm < $today)) {
			return true;
		} else if ($this->aloitus_pvm > $today && $this->paattymis_pvm > $today){	
			return false;
		} else {
			return false;
		}
	}

	public function willBeTaken(){
		$today = date("Y-m-d");
		if ($this->aloitus_pvm > $today) {
			return true;
		} else {
			return false;
		}
	}

}



