<?php

class Kayttaja extends BaseModel{
	
	public $id, $nimi, $tunnus, $salasana, $paakaytto;

	public function __construct($attributes){
		parent::__construct($attributes);
	}

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Kayttaja (nimi, tunnus, salasana, paakaytto) VALUES (:nimi, :tunnus, :salasana, :paakaytto) RETURNING id');
		$query->execute(array('nimi' => $this->nimi, 'tunnus' => $this->tunnus, 'salasana' => $this->salasana, 'paakaytto' => $this->paakaytto));
		$row= $query->fetch();
		$this->id = $row['id'];
	}

	public static function all(){
		$query = DB::connection()->prepare('SELECT * FROM Kayttaja');
		$query->execute();
		$rows = $query->fetchAll();
		$kayttajat = array();

		foreach ($rows as $row) {
			$kayttajat[] = new Kayttaja(array(
				'id' => $row['id'],
				'nimi' => $row['nimi'],
				'tunnus' => $row['tunnus'],
				'salasana' => $row['salasana'],
				'paakaytto' => $row['paakaytto']
			));

		}
		return $kayttajat;
	}

	public static function findById($id){
		$query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE id = :id LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if ($row) {
			$kayttaja = new Kayttaja(array(
				'id' => $row['id'],
				'nimi' => $row['nimi'],
				'tunnus' => $row['tunnus'],
				'salasana' => $row['salasana'],
				'paakaytto' => $row['paakaytto']
			));
			return $kayttaja;
		}
		return null;
	}
	
	public function update() {
		$query = DB::connection()->prepare('UPDATE Kayttaja SET nimi = :nimi, tunnus = :tunnus, salasana = :salasana, paakaytto = :paakaytto WHERE id = :id');
		$query->execute(array('id' => $this->id, 'nimi' => $this->nimi, 'tunnus' => $this->tunnus, 'salasana' => $this->salasana, 'paakaytto' => $this->paakaytto));
	}

	public function destroy() {
		$query = DB::connection()->prepare('DELETE FROM Kayttaja WHERE id = :id');
		$query->execute(array('id' => $this->id));
	} 

	public function authenticate($tunnus, $salasana){
		$query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE tunnus = :tunnus AND salasana = :salasana LIMIT 1', array('tunnus' => $tunnus, 'salasana' => $salasana));
		$query->execute();
		$row = $query->fetch();

		if ($row) {
			$kayttaja = new Kayttaja(array(
				'id' => $row['id'],
				'nimi' => $row['nimi'],
				'tunnus' => $row['tunnus'],
				'salasana' => $row['salasana'],
				'paakaytto' => $row['paakaytto']
			));
			return $kayttaja;
		} else {
			return null;
		}
	}
}

