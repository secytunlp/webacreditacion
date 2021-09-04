<?php

class Unidad {
	private $cd_unidad;
	private $cd_tipounidad;

	private $cd_padre;
	private $bl_hijos;
	private $ds_unidad;
	private $ds_codigo;
	private $ds_sigla;
	private $ds_direccion;
	private $ds_mail;
	private $ds_telefono;
	private $cd_facultad;
	//Método constructor


	function Unidad() {

		$this->cd_unidad = 0;
		$this->cd_tipounidad = 0;
		$this->cd_facultad = 0;
		$this->cd_padre = 0;
		$this->bl_hijos = 0;
		$this->ds_unidad = '';
		$this->ds_codigo = '';
		$this->ds_sigla = '';
		$this->ds_direccion = '';
		$this->ds_mail = '';
		$this->ds_telefono = '';
	}

	//Métodos Get


	function getCd_unidad() {
		return $this->cd_unidad;
	}

	function getCd_tipounidad() {
		return $this->cd_tipounidad;
	}

	function getCd_padre() {
		return $this->cd_padre;
	}

	function getCd_facultad() {
		return $this->cd_facultad;
	}

	function getBl_hijos() {
		return $this->bl_hijos;
	}

	function getDs_unidad() {
		return $this->ds_unidad;
	}

	function getDs_codigo() {
		return $this->ds_codigo;
	}

	function getDs_sigla() {
		return $this->ds_sigla;
	}

	function getDs_direccion() {
		return $this->ds_direccion;
	}

	function getDs_mail() {
		return $this->ds_mail;
	}

	function getDs_telefono() {
		return $this->ds_telefono;
	}
	//Métodos Set


	function setCd_unidad($value) {
		$this->cd_unidad = $value;
	}

	function setCd_tipounidad($value) {
		$this->cd_tipounidad = $value;
	}

	function setCd_padre($value) {
		$this->cd_padre = $value;
	}

	function setCd_facultad($value) {
		$this->cd_facultad = $value;
	}

	function setBl_hijos($value) {
		$this->bl_hijos = $value;
	}

	function setDs_unidad($value) {
		$this->ds_unidad = $value;
	}

	function setDs_codigo($value) {
		$this->ds_codigo = $value;
	}

	function setDs_sigla($value) {
		$this->ds_sigla = $value;
	}

	function setDs_direccion($value) {
		$this->ds_direccion = $value;
	}

	function setDs_mail($value) {
		$this->ds_mail = $value;
	}

	function setDs_telefono($value) {
		$this->ds_telefono = $value;
	}

}

