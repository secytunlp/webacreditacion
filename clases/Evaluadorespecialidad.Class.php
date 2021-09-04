<?php

class Evaluadorespecialidad {
	private $cd_evaluadorespecialidad;
	private $cd_usuario;
	private $cd_especialidad;
	private $ds_especialidad;



	//Método constructor


	function Evaluadorespecialidad() {

		$this->cd_evaluadorespecialidad = 0;
		$this->cd_usuario = 0;
		$this->cd_especialidad = 0;
		$this->ds_especialidad = '';


	}

	//Métodos Get


	function getCd_evaluadorespecialidad() {
		return $this->cd_evaluadorespecialidad;
	}

	function getCd_usuario() {
		return $this->cd_usuario;
	}

	function getCd_especialidad() {
		return $this->cd_especialidad;
	}

	function getDs_especialidad() {
		return $this->ds_especialidad;
	}






	//Métodos Set


	function setCd_evaluadorespecialidad($value) {
		$this->cd_evaluadorespecialidad = $value;
	}

	function setCd_usuario($value) {
		$this->cd_usuario = $value;
	}

	function setCd_especialidad($value) {
		$this->cd_especialidad = $value;
	}

	function setDs_especialidad($value) {
		$this->ds_especialidad = $value;
	}






}

