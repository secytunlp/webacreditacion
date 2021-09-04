<?php

class Tipoinvestigador {
	private $cd_tipoinvestigador;
	private $ds_tipoinvestigador;

	//Método constructor


	function Tipoinvestigador() {

		$this->cd_tipoinvestigador = 0;
		$this->ds_tipoinvestigador = '';
	}

	//Métodos Get


	function getCd_tipoinvestigador() {
		return $this->cd_tipoinvestigador;
	}

	function getDs_tipoinvestigador() {
		return $this->ds_tipoinvestigador;
	}

	//Métodos Set


	function setCd_tipoinvestigador($value) {
		$this->cd_tipoinvestigador = $value;
	}

	function setDs_tipoinvestigador($value) {
		$this->ds_tipoinvestigador = $value;
	}

}

