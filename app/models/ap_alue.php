<?php

class Ap_alue extends BaseModel{
	
	public $id, $nimi;

	public function __construct($attributes){
		parent::__construct($attributes); 
	}

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Ap_alue (nimi) VALUES (:nimi) RETURNING id');
		$query->execute(array('nimi' => $this->nimi));
		$row = $query->fetch();
		//Kint::trace();
  		//Kint::dump($row);
		$this->id = $row['id'];
	}	

	public static function all(){
		$query = DB::connection()->prepare('SELECT * FROM Ap_alue');
		$query->execute();
		$rows = $query->fetchAll();
		$ap_alueet = array();

		foreach ($rows as $row) {
			$ap_alueet[] = new Ap_alue(array(
				'id' => $row['id'],
				'nimi' => $row['nimi']
			));
		}
		return $ap_alueet;
	}

	public static function find($id){
		$query = DB::connection()->prepare('SELECT * FROM Ap_alue WHERE id = :id LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if ($row) {
			$ap_alue[] = new Ap_alue(array(
				'id' => $row['id'],
				'nimi' => $row['nimi'],
				));
			return $ap_alue;
		}
		return null;
	}



}