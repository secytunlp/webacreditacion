<?php

class Categoria {
	private $cd_categoria;
	private $ds_categoria;

	//Método constructor


	function Categoria() {

		$this->cd_categoria = 0;
		$this->ds_categoria = '';
	}

	//Métodos Get


	function getCd_categoria() {
		return $this->cd_categoria;
	}

	function getDs_categoria() {
		return $this->ds_categoria;
	}

	//Métodos Set


	function setCd_categoria($value) {
		$this->cd_categoria = $value;
	}

	function setDs_categoria($value) {
		$this->ds_categoria = $value;
	}

}

