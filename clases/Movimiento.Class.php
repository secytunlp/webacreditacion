<?php

class Movimiento {
	private $cd_movimiento;
	private $cd_usuario;
	private $ds_apynom;
	private $cd_funcion;
	private $ds_funcion;
	private $dt_fecha;
	private $ds_movimiento;
	private $ds_consecuencia;

	//Método constructor


	function Movimiento() {

		$this->cd_movimiento = 0;
		$this->cd_usuario = 0;
		$this->ds_apynom = '';
		$this->cd_funcion = 0;
		$this->ds_funcion = '';
		$this->dt_fecha = '';
		$this->ds_movimiento = '';
		$this->ds_consecuencia = '';
	}

	//Métodos Get


	function getCd_movimiento() {
		return $this->cd_movimiento;
	}

	function getCd_usuario() {
		return $this->cd_usuario;
	}

	function getDs_apynom() {
		return $this->ds_apynom;
	}

	function getDs_funcion() {
		return $this->ds_funcion;
	}

	function getCd_funcion() {
		return $this->cd_funcion;
	}

	function getDt_fecha() {
		return $this->dt_fecha;
	}

	function getDs_movimiento() {
		return $this->ds_movimiento;
	}

	function getDs_consecuencia() {
		return $this->ds_consecuencia;
	}

	//Métodos Set


	function setCd_movimiento($value) {
		$this->cd_movimiento = $value;
	}

	function setCd_usuario($value) {
		$this->cd_usuario = $value;
	}

	function setDs_apynom($value) {
		$this->ds_apynom = $value;
	}

	function setCd_funcion($value) {
		$this->cd_funcion = $value;
	}

	function setDs_funcion($value) {
		$this->ds_funcion = $value;
	}

	function setDt_fecha($value) {
		$this->dt_fecha = $value;
	}

	function setDs_movimiento($value) {
		$this->ds_movimiento = $value;
	}

	function setDs_consecuencia($value) {
		$this->ds_consecuencia = $value;
	}

}

