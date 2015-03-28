<?php

class Ap_alue extends BaseModel{
	
	public $id, $nimi;

	public function __construct($attributes){
		parent::__construct($attributes); 
	}

	public static function all(){
		$query = DB::connection()->prepare('SELECT * FROM Ap_alue');
		$query->execute();
		$rows = $query->fetchAll();
		$ap_alueet = array();

		foreach ($rows as $row) {
			$kiinteistot[] = new Ap_alue(array(
				'id' => $row['id'],
				'nimi' => $row['nimi']
			));
		}
		return $ap_alueet;
	}


}