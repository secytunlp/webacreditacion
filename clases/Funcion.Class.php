<?php

class Funcion {
	private $cd_funcion;
	private $ds_funcion;

	//Método constructor


	function Funcion() {

		$this->cd_funcion = 0;
		$this->ds_funcion = '';
	}

	//Métodos Get


	function getCd_funcion() {
		return $this->cd_funcion;
	}

	function getDs_funcion() {
		return $this->ds_funcion;
	}

	//Métodos Set


	function setCd_funcion($value) {
		$this->cd_funcion = $value;
	}

	function setDs_funcion($value) {
		$this->ds_funcion = $value;
	}

}

