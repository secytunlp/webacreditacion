<?php

class Titulo {
	private $cd_titulo;
	private $ds_titulo;

	//Método constructor


	function Titulo() {

		$this->cd_titulo = 0;
		$this->ds_titulo = '';
	}

	//Métodos Get


	function getCd_titulo() {
		return $this->cd_titulo;
	}

	function getDs_titulo() {
		return $this->ds_titulo;
	}

	//Métodos Set


	function setCd_titulo($value) {
		$this->cd_titulo = $value;
	}

	function setDs_titulo($value) {
		$this->ds_titulo = $value;
	}

}

