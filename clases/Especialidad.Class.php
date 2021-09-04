<?php

class Especialidad {
	private $cd_especialidad;
	private $ds_especialidad;
	private $ds_codigo;
	private $cd_disciplina;
	//Método constructor


	function Especialidad() {

		$this->cd_especialidad = 0;
		$this->ds_especialidad = '';
		$this->ds_codigo = '';
		$this->cd_disciplina = 0;
	}

	//Métodos Get


	function getCd_especialidad() {
		return $this->cd_especialidad;
	}

	function getCd_disciplina() {
		return $this->cd_disciplina;
	}

	function getDs_especialidad() {
		return $this->ds_especialidad;
	}

	function getDs_codigo() {
		return $this->ds_codigo;
	}

	//Métodos Set


	function setCd_especialidad($value) {
		$this->cd_especialidad = $value;
	}

	function setCd_disciplina($value) {
		$this->cd_disciplina = $value;
	}

	function setDs_especialidad($value) {
		$this->ds_especialidad = $value;
	}

	function setDs_codigo($value) {
		$this->ds_codigo = $value;
	}

}

