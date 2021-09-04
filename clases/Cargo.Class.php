<?php

class Cargo {
	private $cd_cargo;
	private $ds_cargo;

	//Método constructor


	function Cargo() {

		$this->cd_cargo = 0;
		$this->ds_cargo = '';
	}

	//Métodos Get


	function getCd_cargo() {
		return $this->cd_cargo;
	}

	function getDs_cargo() {
		return $this->ds_cargo;
	}

	//Métodos Set


	function setCd_cargo($value) {
		$this->cd_cargo = $value;
	}

	function setDs_cargo($value) {
		$this->ds_cargo = $value;
	}

}

