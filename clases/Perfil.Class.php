<?php

class Perfil {
	private $cd_perfil;
	private $ds_perfil;

	//Método constructor


	function Perfil() {

		$this->cd_perfil = 0;
		$this->ds_perfil = '';
	}

	//Métodos Get


	function getCd_perfil() {
		return $this->cd_perfil;
	}

	function getDs_perfil() {
		return $this->ds_perfil;
	}

	//Métodos Set


	function setCd_perfil($value) {
		$this->cd_perfil = $value;
	}

	function setDs_perfil($value) {
		$this->ds_perfil = $value;
	}

}

