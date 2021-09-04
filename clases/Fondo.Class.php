<?php

class Fondo {
	private $cd_fondo;
	private $cd_proyecto;
	private $nu_monto;
	private $ds_fuente;
	private $ds_resolucion;
	private $bl_tramite;

	//Método constructor


	function Fondo() {

		$this->cd_fondo = '';
		$this->cd_proyecto = '';
		$this->nu_monto = '0';
		$this->ds_fuente = '';

		$this->ds_resolucion = '';

		$this->bl_tramite = 0;
	}

	//Métodos Get


	function getCd_fondo() {
		return $this->cd_fondo;
	}

	function getCd_proyecto() {
		return $this->cd_proyecto;
	}

	function getNu_monto() {
		return $this->nu_monto;
	}



	function getDs_fuente() {
		return $this->ds_fuente;
	}

	function getDs_resolucion() {
		return $this->ds_resolucion;
	}



	function getBl_tramite() {
		return $this->bl_tramite;
	}
	//Métodos Set


	function setCd_fondo($value) {
		$this->cd_fondo = $value;
	}

	function setCd_proyecto($value) {
		$this->cd_proyecto = $value;
	}

	function setNu_monto($value) {
		$this->nu_monto = $value;
	}



	function setDs_fuente($value) {
		$this->ds_fuente = $value;
	}


	function setDs_resolucion($value) {
		$this->ds_resolucion = $value;
	}



	function setBl_tramite($value) {
		$this->bl_tramite = $value;
	}



	//Functions



}

