<?php

class Estado {
	private $cd_estado;
	private $ds_estado;

	//Método constructor


	function Estado() {

		$this->cd_estado = 0;
		$this->ds_estado = '';
	}

	//Métodos Get


	function getCd_estado() {
		return $this->cd_estado;
	}

	function getDs_estado() {
		return $this->ds_estado;
	}

	//Métodos Set


	function setCd_estado($value) {
		$this->cd_estado = $value;
	}

	function setDs_estado($value) {
		$this->ds_estado = $value;
	}

}

