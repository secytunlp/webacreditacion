<?php

class Universidad {
	private $cd_universidad;
	private $ds_universidad;

	//Método constructor


	function Universidad() {

		$this->cd_universidad = 0;
		$this->ds_universidad = '';
	}

	//Métodos Get


	function getCd_universidad() {
		return $this->cd_universidad;
	}

	function getDs_universidad() {
		return $this->ds_universidad;
	}

	//Métodos Set


	function setCd_universidad($value) {
		$this->cd_universidad = $value;
	}

	function setDs_universidad($value) {
		$this->ds_universidad = $value;
	}

}

