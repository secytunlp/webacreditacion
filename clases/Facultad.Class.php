<?php

class Facultad {
	private $cd_facultad;
	private $ds_facultad;

	//Método constructor


	function Facultad() {

		$this->cd_facultad = 0;
		$this->ds_facultad = '';
	}

	//Métodos Get


	function getCd_facultad() {
		return $this->cd_facultad;
	}

	function getDs_facultad() {
		return $this->ds_facultad;
	}

	//Métodos Set


	function setCd_facultad($value) {
		$this->cd_facultad = $value;
	}

	function setDs_facultad($value) {
		$this->ds_facultad = $value;
	}

}

