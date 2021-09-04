<?php

class Tipomodificacion {
	private $cd_tipomodificacion;
	private $ds_tipomodificacion;

	//Método constructor


	function Tipomodificacion() {

		$this->cd_tipomodificacion = 0;
		$this->ds_tipomodificacion = '';
	}

	//Métodos Get


	function getCd_tipomodificacion() {
		return $this->cd_tipomodificacion;
	}

	function getDs_tipomodificacion() {
		return $this->ds_tipomodificacion;
	}

	//Métodos Set


	function setCd_tipomodificacion($value) {
		$this->cd_tipomodificacion = $value;
	}

	function setDs_tipomodificacion($value) {
		$this->ds_tipomodificacion = $value;
	}

}

