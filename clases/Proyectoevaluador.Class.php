<?php

class Proyectoevaluador {
	private $cd_proyectoevaluador;
	private $cd_proyecto;
	private $cd_evaluador;
	private $cd_tipoevaluador;


	//Método constructor


	function Proyectoevaluador() {

		$this->cd_proyectoevaluador = '';
		$this->cd_proyecto = '';
		$this->cd_evaluador = '';
		$this->cd_tipoevaluador = '';


	}

	//Métodos Get


	function getCd_proyectoevaluador() {
		return $this->cd_proyectoevaluador;
	}

	function getCd_proyecto() {
		return $this->cd_proyecto;
	}

	function getCd_evaluador() {
		return $this->cd_evaluador;
	}



	function getCd_tipoevaluador() {
		return $this->cd_tipoevaluador;
	}


	//Métodos Set


	function setCd_proyectoevaluador($value) {
		$this->cd_proyectoevaluador = $value;
	}

	function setCd_proyecto($value) {
		$this->cd_proyecto = $value;
	}

	function setCd_evaluador($value) {
		$this->cd_evaluador = $value;
	}



	function setCd_tipoevaluador($value) {
		$this->cd_tipoevaluador = $value;
	}






	//Functions



}

