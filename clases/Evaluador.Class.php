<?php

class Evaluador {
	private $cd_evaluador;
	private $ds_evaluador;
	private $ds_universidad;
	private $ds_disciplina;
	private $nu_documento;
	private $ds_categoria;
	private $ds_calle;
	private $nu_nro;
	private $nu_piso;
	private $ds_depto;
	private $ds_localidad;
	private $nu_telefono;
	private $nu_cp;
	private $ds_mail;
	//Método constructor


	function Evaluador() {

		$this->cd_evaluador = 0;
		$this->ds_evaluador = '';
		$this->ds_universidad= '';
		$this->ds_disciplina= '';
		$this->nu_documento= '';
		$this->ds_categoria= '';
		$this->ds_calle= '';
		$this->nu_nro= '';
		$this->nu_piso= '';
		$this->ds_depto= '';
		$this->ds_localidad= '';
		$this->nu_telefono= '';
		$this->nu_cp= '';
		$this->ds_mail= '';
	}

	//Métodos Get


	function getCd_evaluador() {
		return $this->cd_evaluador;
	}

	function getDs_evaluador() {
		return $this->ds_evaluador;
	}

	function getDs_universidad() {
		return $this->ds_universidad;
	}

	function getDs_disciplina() {
		return $this->ds_disciplina;
	}

	function getNu_documento() {
		return $this->nu_documento;
	}

	function getDs_categoria() {
		return $this->ds_categoria;
	}

	function getDs_calle() {
		return $this->ds_calle;
	}

	function getNu_nro() {
		return $this->nu_nro;
	}

	function getNu_piso() {
		return $this->nu_piso;
	}

	function getDs_depto() {
		return $this->ds_depto;
	}

	function getDs_localidad() {
		return $this->ds_localidad;
	}

	function getNu_telefono() {
		return $this->nu_telefono;
	}

	function getNu_cp() {
		return $this->nu_cp;
	}

	function getDs_mail() {
		return $this->ds_mail;
	}

	//Métodos Set


	function setCd_evaluador($value) {
		$this->cd_evaluador = $value;
	}

	function setDs_evaluador($value) {
		$this->ds_evaluador = $value;
	}

	function setDs_universidad($value) {
		$this->ds_universidad= $value;
	}

	function setDs_disciplina($value) {
		$this->ds_disciplina= $value;
	}

	function setNu_documento($value) {
		$this->nu_documento= $value;
	}

	function setDs_categoria($value) {
		$this->ds_categoria= $value;
	}

	function setDs_calle($value) {
		$this->ds_calle= $value;
	}

	function setNu_nro($value) {
		$this->nu_nro= $value;
	}

	function setNu_piso($value) {
		$this->nu_piso= $value;
	}

	function setDs_depto($value) {
		$this->ds_depto= $value;
	}

	function setDs_localidad($value) {
		$this->ds_localidad= $value;
	}

	function setNu_telefono($value) {
		$this->nu_telefono= $value;
	}

	function setNu_cp($value) {
		$this->nu_cp= $value;
	}

	function setDs_mail($value) {
		$this->ds_mail= $value;
	}

}

