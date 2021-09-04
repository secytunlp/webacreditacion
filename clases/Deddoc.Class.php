<?php

class Deddoc {
	private $cd_deddoc;
	private $ds_deddoc;

	//Método constructor


	function Deddoc() {

		$this->cd_deddoc = 0;
		$this->ds_deddoc = '';
	}

	//Métodos Get


	function getCd_deddoc() {
		return $this->cd_deddoc;
	}

	function getDs_deddoc() {
		return $this->ds_deddoc;
	}

	//Métodos Set


	function setCd_deddoc($value) {
		$this->cd_deddoc = $value;
	}

	function setDs_deddoc($value) {
		$this->ds_deddoc = $value;
	}

}

