<?php

class Tipoacreditacion {
	private $cd_tipoacreditacion;
	private $ds_tipoacreditacion;

	//M�todo constructor


	function Tipoacreditacion() {

		$this->cd_tipoacreditacion = 0;
		$this->ds_tipoacreditacion = '';
	}

	//M�todos Get


	function getCd_tipoacreditacion() {
		return $this->cd_tipoacreditacion;
	}

	function getDs_tipoacreditacion() {
		return $this->ds_tipoacreditacion;
	}

	//M�todos Set


	function setCd_tipoacreditacion($value) {
		$this->cd_tipoacreditacion = $value;
	}

	function setDs_tipoacreditacion($value) {
		$this->ds_tipoacreditacion = $value;
	}

}

