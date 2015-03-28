<?php

class Autopaikka extends BaseModel{
	
	public $id, $ap_alue_id, $nimi, $tyyppi, $sahkopistoke;

	public function __construct($attributes) {
		parent::__construct($attributes);
	}

	public static function all(){
		$query = DB::connection()->prepare('SELECT * FROM Autopaikka');
		$query->execute();
		$rows = $query->fetchAll();
		$autopaikat = array();

		foreach($rows as $row) {
			'id' => $row['id'],
			'ap_alue_id' => $row['ap_alue_id'],
			'nimi' => $row['nimi'],
			'tyyppi' => $row['tyyppi'],
			'sahkopistoke' => $row['sahkopistoke']
			));
		}
		return $autopaikat;
	}
}