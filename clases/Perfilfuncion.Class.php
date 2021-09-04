<?php
class Perfilfuncion {
	private $cd_perfil;
	private $cd_funcion;

	//Método constructor


	function Perfilfuncion() {
		$this->cd_perfil = 0;
		$this->cd_funcion = '';
	}

	//Métodos Get


	function getCd_perfil() {
		return $this->cd_perfil;
	}

	function getCd_funcion() {
		return $this->cd_funcion;
	}

	//Métodos Set


	function setCd_perfil($value) {
		$this->cd_perfil = $value;
	}

	function setCd_funcion($value) {
		$this->cd_funcion = $value;
	}

}
?>
