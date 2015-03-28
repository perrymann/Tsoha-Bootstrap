<?php

class Linkitys extends BaseModel{

	public $id, $ap_alue_id, $kiinteisto_id;

	public function __construct($attributes){
		parent::__construct($attributes);
	}

	public static function all() {
		$query = DB::connection->prepare('SELECT * FROM Linkitys');
		$query->execute();
		$rows = $query->fetchAll();
		$linkitykset = array();

		foreach ($rows as $row) {
			$linkitykset[] = new Linkitys(array(
				'id' => $row['id'],
				'ap_alue_id' => $row['ap_alue_id'],
				'kiinteisto_id' => $row['kiinteisto_id']
			));
		}
		return $linkitykset;
	}

	//työn alla...

	public static function getLinksByHouseAddress() {
		$query = DB::connection->prepare('SELECT 
			FROM Linkitys, Kiinteisto  
			WHERE Kiinteisto->nimi = :nimi AND
			Kiinteisto->id = Linkitys->id');
		$query->execute();
		$rows = $query->fetchAll();
		$linkityksetTalolla = array();

		foreach ($rows as $row) {
			$linkityksetTalolla[] = new Linkitys(array(
				'id' => $row['id'],
				'ap_alue_id' => $row['ap_alue_id'],
				'kiinteisto_id' => $row['kiinteisto_id']
			));
		}
		return $linkityksetTalolla;
	}
}