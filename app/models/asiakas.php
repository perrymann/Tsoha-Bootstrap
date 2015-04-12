<?php

class Asiakas extends BaseModel{
	
	public $id, $etunimi, $sukunimi, $puhelinnumero, $email, $katuosoite, $postinumero, $postitoimipaikka;

	public function __construct($attributes){
    	parent::__construct($attributes);
  	}

  	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Asiakas (etunimi, sukunimi, puhelinnumero, email, katuosoite, postinumero, postitoimipaikka) VALUES (:etunimi, :sukunimi, :puhelinnumero, :email, :katuosoite, :postinumero, :postitoimipaikka) RETURNING id');
		$query->execute(array('etunimi' => $this->etunimi, 'sukunimi' => $this->sukunimi, 'puhelinnumero' => $this->puhelinnumero, 'email' => $this->email, 'katuosoite' => $this->katuosoite, 'postinumero' => $this->postinumero, 'postitoimipaikka' => $this->postitoimipaikka));
		$row = $query->fetch();
		$this->id = $row['id'];
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
			$haettuasiakas = new Asiakas(array(
	        'id' => $row['id'],
	        'etunimi' => $row['etunimi'],
	        'sukunimi' => $row['sukunimi'],
	        'puhelinnumero' => $row['puhelinnumero'],
	        'email' => $row['email'],
	        'katuosoite' => $row['katuosoite'],
	        'postinumero' => $row['postinumero'],
	        'postitoimipaikka' => $row['postitoimipaikka']
      		));
      		return $haettuasiakas;
		}	
      	return null;
    }

    public function update(){
    	$query = DB::connection()->prepare('UPDATE Asiakas SET etunimi = :etunimi, sukunimi = :sukunimi, puhelinnumero = :puhelinnumero, email = :email, katuosoite = :katuosoite, postinumero = :postinumero, postitoimipaikka = :postitoimipaikka WHERE id = :id');
    	$query->execute(array('id' => $this->id, 'etunimi' => $this->etunimi, 'sukunimi' => $this->sukunimi, 'puhelinnumero' => $this->puhelinnumero, 'email' => $this->email, 'katuosoite' => $this->katuosoite, 'postinumero' => $this->postinumero, 'postitoimipaikka' => $this->postitoimipaikka));
	}

    public function destroy(){
		$query = DB::connection()->prepare('DELETE FROM Asiakas WHERE id = :id');
		$query->execute(array('id' => $this->id));

	}
}
  
