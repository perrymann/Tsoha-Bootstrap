<?php

class Ap_alueController extends BaseController{
	
	public static function index(){
		$ap_alueet = Ap_alue::all();
		View::make('ap_alue/ap_alueet.html', array('ap_alueet' => $ap_alueet));
	}


}