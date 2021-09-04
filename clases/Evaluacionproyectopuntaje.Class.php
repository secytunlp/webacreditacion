<?php

class Evaluacionproyectopuntaje {
	private $cd_evaluacionproyectopuntaje;
	private $cd_evaluacionproyectoplanilla;
	private $cd_evaluacion;

	private $nu_puntaje;


	//Método constructor


	function Evaluacionproyectopuntaje() {

		$this->cd_evaluacionproyectopuntaje = 0;
		$this->cd_evaluacionproyectoplanilla = 0;
		$this->cd_evaluacion = 0;

		$this->nu_puntaje = 0;

	}

	//Métodos Get


	function getCd_evaluacionproyectopuntaje() {
		return $this->cd_evaluacionproyectopuntaje;
	}

	function getCd_evaluacionproyectoplanilla() {
		return $this->cd_evaluacionproyectoplanilla;
	}

	function getCd_evaluacion() {
		return $this->cd_evaluacion;
	}



	function getNu_puntaje() {
		return $this->nu_puntaje;
	}



	//Métodos Set


	function setCd_evaluacionproyectopuntaje($value) {
		$this->cd_evaluacionproyectopuntaje = $value;
	}

	function setCd_evaluacionproyectoplanilla($value) {
		$this->cd_evaluacionproyectoplanilla = $value;
	}

	function setCd_evaluacion($value) {
		$this->cd_evaluacion = $value;
	}


	function setNu_puntaje($value) {
		$this->nu_puntaje = $value;
	}



}

