<?php

class Tipounidad {
	private $cd_tipounidad;
	private $ds_tipounidad;

	//Método constructor


	function Tipounidad() {

		$this->cd_tipounidad = 0;
		$this->ds_tipounidad = '';
	}

	//Métodos Get


	function getCd_tipounidad() {
		return $this->cd_tipounidad;
	}

	function getDs_tipounidad() {
		return $this->ds_tipounidad;
	}

	//Métodos Set


	function setCd_tipounidad($value) {
		$this->cd_tipounidad = $value;
	}

	function setDs_tipounidad($value) {
		$this->ds_tipounidad = $value;
	}

}

