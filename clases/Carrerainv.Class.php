<?php

class Carrerainv {
	private $cd_carrerainv;
	private $ds_carrerainv;

	//Método constructor


	function Carrerainv() {

		$this->cd_carrerainv = 0;
		$this->ds_carrerainv = '';
	}

	//Métodos Get


	function getCd_carrerainv() {
		return $this->cd_carrerainv;
	}

	function getDs_carrerainv() {
		return $this->ds_carrerainv;
	}

	//Métodos Set


	function setCd_carrerainv($value) {
		$this->cd_carrerainv = $value;
	}

	function setDs_carrerainv($value) {
		$this->ds_carrerainv = $value;
	}

}

