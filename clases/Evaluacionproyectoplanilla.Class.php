<?php

class Evaluacionproyectoplanilla {
	private $cd_evaluacionproyectoplanilla;
	private $cd_subgrupo;
	private $ds_evaluacionproyectoplanilla;
	private $ds_subgrupo;
	private $ds_letra;

	//Método constructor


	function Evaluacionproyectoplanilla() {

		$this->cd_evaluacionproyectoplanilla = 0;
		$this->cd_subgrupo = 0;
		$this->ds_evaluacionproyectoplanilla = 0;
		$this->ds_subgrupo = '';
		$this->ds_letra = 0;

	}

	//Métodos Get


	function getCd_evaluacionproyectoplanilla() {
		return $this->cd_evaluacionproyectoplanilla;
	}

	function getCd_subgrupo() {
		return $this->cd_subgrupo;
	}

	function getDs_evaluacionproyectoplanilla() {
		return $this->ds_evaluacionproyectoplanilla;
	}

	function getDs_subgrupo() {
		return $this->ds_subgrupo;
	}

	function getDs_letra() {
		return $this->ds_letra;
	}



	//Métodos Set


	function setCd_evaluacionproyectoplanilla($value) {
		$this->cd_evaluacionproyectoplanilla = $value;
	}

	function setCd_subgrupo($value) {
		$this->cd_subgrupo = $value;
	}

	function setDs_evaluacionproyectoplanilla($value) {
		$this->ds_evaluacionproyectoplanilla = $value;
	}

	function setDs_subgrupo($value) {
		$this->ds_subgrupo = $value;
	}

	function setDs_letra($value) {
		$this->ds_letra = $value;
	}



}

