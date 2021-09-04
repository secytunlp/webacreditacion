<?php
class Usuarioperfil {
	private $cd_perfil;
	private $cd_usuario;

	//M�todo constructor


	function Usuarioperfil() {
		$this->cd_perfil = 0;
		$this->cd_usuario = '';
	}

	//M�todos Get


	function getCd_perfil() {
		return $this->cd_perfil;
	}

	function getCd_usuario() {
		return $this->cd_usuario;
	}

	//M�todos Set


	function setCd_perfil($value) {
		$this->cd_perfil = $value;
	}

	function setCd_usuario($value) {
		$this->cd_usuario = $value;
	}

}
?>
