<?php

class Cargo {
	private $cd_cargo;
	private $ds_cargo;

	//M�todo constructor


	function Cargo() {

		$this->cd_cargo = 0;
		$this->ds_cargo = '';
	}

	//M�todos Get


	function getCd_cargo() {
		return $this->cd_cargo;
	}

	function getDs_cargo() {
		return $this->ds_cargo;
	}

	//M�todos Set


	function setCd_cargo($value) {
		$this->cd_cargo = $value;
	}

	function setDs_cargo($value) {
		$this->ds_cargo = $value;
	}

}

