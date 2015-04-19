<?php

class Varaus extends BaseModel{
	
	public $id, $autopaikka_id, $asiakas_id, $aloitus_pvm, $paattymis_pvm, $varaus_pvm, $irtisanomis_pvm;

	public function __construct($attributes){
		parent::__construct($attributes);
	}


	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Varaus (autopaikka_id, asiakas_id, aloitus_pvm, paattymis_pvm) VALUES (:autopaikka_id, :asiakas_id, :aloitus_pvm, :paattymis_pvm) RETURNING id');
		$query->execute(array('autopaikka_id' => $this->autopaikka_id, 'asiakas_id' => $this->asiakas_id, 'aloitus_pvm' => $this->aloitus_pvm, 'paattymis_pvm' => $this->paattymis_pvm));
		$row = $query->fetch();
		$this->id = $row['id'];
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

	//$today = getdate(); testaa tätä metodia!


	public function isValid(){
		$today = getdate();
		if ($this->paattymis_pvm == null || $this->paattymis_pvm < $today) {
			return true;
		} else {
			return false;
		}
	}
	
}



