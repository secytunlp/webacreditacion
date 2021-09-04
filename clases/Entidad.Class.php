<?php

class Entidad {
	private $cd_entidad;
	private $ds_entidad;
	private $ds_codigo;
	//Método constructor


	function Entidad() {

		$this->cd_entidad = 0;
		$this->ds_entidad = '';
		$this->ds_codigo = '';
	}

	//Métodos Get


	function getCd_entidad() {
		return $this->cd_entidad;
	}

	function getDs_entidad() {
		return $this->ds_entidad;
	}

	function getDs_codigo() {
		return $this->ds_codigo;
	}

	//Métodos Set


	function setCd_entidad($value) {
		$this->cd_entidad = $value;
	}

	function setDs_entidad($value) {
		$this->ds_entidad = $value;
	}

	function setDs_codigo($value) {
		$this->ds_codigo = $value;
	}

}

