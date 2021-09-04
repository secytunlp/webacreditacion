<?php

class Facultadproyecto {
	private $cd_facultadproyecto;
	private $cd_facultad;
	private $cd_proyecto;



	//Método constructor


	function Facultadproyecto() {

		$this->cd_facultadproyecto = '';
		$this->cd_facultad = '';
		$this->cd_proyecto = '';



	}

	//Métodos Get


	function getCd_facultadproyecto() {
		return $this->cd_facultadproyecto;
	}

	function getCd_facultad() {
		return $this->cd_facultad;
	}

	function getCd_proyecto() {
		return $this->cd_proyecto;
	}






	//Métodos Set


	function setCd_facultadproyecto($value) {
		$this->cd_facultadproyecto = $value;
	}

	function setCd_facultad($value) {
		$this->cd_facultad = $value;
	}

	function setCd_proyecto($value) {
		$this->cd_proyecto = $value;
	}









	//Functions



}

