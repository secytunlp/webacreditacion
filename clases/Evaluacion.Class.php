<?php

class Evaluacion {
	private $cd_evaluacion;
	private $cd_usuario;
	private $cd_proyecto;
	private $cd_estado;
	private $ds_estado;
	private $dt_fecha;
	private $nu_puntaje;
	private $bl_interno;
	private $ds_observacion;
	private $ds_observacionsecyt;
	//Método constructor


	function Evaluacion() {

		$this->cd_evaluacion = 0;
		$this->cd_usuario = 0;
		$this->cd_proyecto = 0;
		$this->cd_estado = 0;
		$this->ds_estado = 0;
		$this->dt_fecha = '';
		$this->nu_puntaje = 0;
		$this->bl_interno = 0;
		$this->ds_observacion = '';
		$this->ds_observacionsecyt = '';
	}

	//Métodos Get


	function getCd_evaluacion() {
		return $this->cd_evaluacion;
	}

	function getCd_usuario() {
		return $this->cd_usuario;
	}

	function getCd_proyecto() {
		return $this->cd_proyecto;
	}

	function getCd_estado() {
		return $this->cd_estado;
	}

	function getDs_estado() {
		return $this->ds_estado;
	}

	function getDt_fecha() {
		return $this->dt_fecha;
	}

	function getNu_puntaje() {
		return $this->nu_puntaje;
	}

	function getBl_interno() {
		return $this->bl_interno;
	}

	function getDs_observacion() {
		return $this->ds_observacion;
	}

	function getDs_observacionsecyt() {
		return $this->ds_observacionsecyt;
	}

	//Métodos Set


	function setCd_evaluacion($value) {
		$this->cd_evaluacion = $value;
	}

	function setCd_usuario($value) {
		$this->cd_usuario = $value;
	}

	function setCd_proyecto($value) {
		$this->cd_proyecto = $value;
	}

	function setCd_estado($value) {
		$this->cd_estado = $value;
	}

	function setDs_estado($value) {
		$this->ds_estado = $value;
	}

	function setDt_fecha($value) {
		$this->dt_fecha = $value;
	}

	function setNu_puntaje($value) {
		$this->nu_puntaje = $value;
	}


	function setBl_interno($value) {
		$this->bl_interno = $value;
	}

	function setDs_observacion($value) {
		$this->ds_observacion = $value;
	}

	function setDs_observacionsecyt($value) {
		$this->ds_observacionsecyt = $value;
	}

}

