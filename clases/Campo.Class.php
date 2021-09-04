<?php

class Campo {
	private $cd_campo;
	private $ds_campo;
	private $ds_codigo;
	//Método constructor


	function Campo() {

		$this->cd_campo = 0;
		$this->ds_campo = '';
		$this->ds_codigo = '';
	}

	//Métodos Get


	function getCd_campo() {
		return $this->cd_campo;
	}

	function getDs_campo() {
		return $this->ds_campo;
	}

	function getDs_codigo() {
		return $this->ds_codigo;
	}

	//Métodos Set


	function setCd_campo($value) {
		$this->cd_campo = $value;
	}

	function setDs_campo($value) {
		$this->ds_campo = $value;
	}

	function setDs_codigo($value) {
		$this->ds_codigo = $value;
	}

}

