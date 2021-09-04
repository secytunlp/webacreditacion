<?php

class Usuario {
	private $cd_usuario;
	private $nu_precuil;
	private $nu_documento;
	private $nu_postcuil;
	private $dt_alta;
	private $ds_apynom;
	private $ds_mail;
	private $ds_password;
	private $cd_perfil;
	private $cd_facultad;
	private $bl_activo;

	//M�todo constructor


	function Usuario() {

		$this->cd_usuario = '';
		$this->nu_precuil = '';
		$this->nu_documento = '';
		$this->nu_postcuil = '';
		$this->ds_apynom = '';
		$this->dt_alta = '';
		$this->ds_password = '';
		$this->cd_perfil = 0;
		$this->cd_facultad = 0;
		$this->bl_activo = 1;
	}

	//M�todos Get


	function getCd_usuario() {
		return $this->cd_usuario;
	}

	function getNu_precuil() {
		return $this->nu_precuil;
	}

	function getNu_documento() {
		return $this->nu_documento;
	}

	function getNu_postcuil() {
		return $this->nu_postcuil;
	}

	function getDt_alta() {
		return $this->dt_alta;
	}

	function getDs_password() {
		return $this->ds_password;
	}

	function getCd_perfil() {
		return $this->cd_perfil;
	}

	function getCd_facultad() {
		return $this->cd_facultad;
	}

	function getDs_mail() {
		return $this->ds_mail;
	}
	function getDs_apynom() {
		return $this->ds_apynom;
	}

	function getBl_activo() {
		return $this->bl_activo;
	}
	//M�todos Set


	function setCd_usuario($value) {
		$this->cd_usuario = $value;
	}

	function setNu_precuil($value) {
		$this->nu_precuil = $value;
	}

	function setNu_postcuil($value) {
		$this->nu_postcuil = $value;
	}

	function setNu_documento($value) {
		$this->nu_documento = $value;
	}

	function setDs_password($value) {
		$this->ds_password = $value;
	}

	function setCd_perfil($value) {
		$this->cd_perfil = $value;
	}

	function setCd_facultad($value) {
		$this->cd_facultad = $value;
	}

	function setDs_mail($value) {
		$this->ds_mail = $value;
	}

	function setDs_apynom($value) {
		$this->ds_apynom = $value;
	}

	function setBl_activo($value) {
		$this->bl_activo = $value;
	}

	function setDt_alta($value) {
		$this->dt_alta = $value;
	}

	//Functions


	function iniciarSesion($year) {
		session_start ();
		$_SESSION ["ds_usuario"] = $this->getDs_apynom ();
		$_SESSION ["cd_usuarioSession"] = $this->getCd_usuario ();
		$_SESSION ["cd_facultadSession"] = $this->getCd_facultad ();
		$_SESSION ["nu_documentoSession"] = $this->getNu_documento();
		$_SESSION ["nu_yearSession"] = $year;
		$_SESSION ["cd_perfilSession"] = $this->getCd_perfil();
	}

	function cerrarSesion() {
		session_start();
		if (! session_destroy ()) {
			$_SESSION ['cd_usuarioSession'] = null;
			unset ( $_SESSION ['cd_usuarioSession'] );
			session_unregister ( 'cd_usuarioSession' );
		}
	}
}

