<?php

class Organismo {
	private $cd_organismo;
	private $ds_organismo;

	//Método constructor


	function Organismo() {

		$this->cd_organismo = 0;
		$this->ds_organismo = '';
	}

	//Métodos Get


	function getCd_organismo() {
		return $this->cd_organismo;
	}

	function getDs_organismo() {
		return $this->ds_organismo;
	}

	//Métodos Set


	function setCd_organismo($value) {
		$this->cd_organismo = $value;
	}

	function setDs_organismo($value) {
		$this->ds_organismo = $value;
	}

}

