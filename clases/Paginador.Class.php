<?php
/***************************************************************************
 *                                 paginador.php
 *                            -------------------
 *   begin                :
 *   copyright            : fede
 *   email                : fedecano@codnet.com.ar
 *
 *   $Id: paginador.php
 *
 ***************************************************************************/

class Paginador {

	private $url_and_get_vars; //Direccion del Paginador con las variables pasadas por Get
	private $num_pages; //Cantidad de Páginas que surgen de la consulta que se quiere paginar
	private $actual_page; //Numero de pagina en la que estoy ubicado
	private $css_class_other_page; //Clase de estilo CSS para aplicar a los tags A de link a otros numeros de pagina
	private $css_class_actual_page; //Clase de estilo CSS para aplicar al numero que indica la página actual
	private $num_pages_per_page; //Esta variable me indica la cantidad de paginas que imprimo por pagina
	private $total_rows;


	//
	// Constructor
	//
	function Paginador($url, $numpages, $actualpage, $cssclassotherpage, $cssclassactualpage, $total_rows) {
		$this->url_and_get_vars = $url;
		$this->num_pages = $numpages;
		$this->actual_page = $actualpage;
		$this->css_class_other_page = $cssclassotherpage;
		$this->css_class_actual_page = $cssclassactualpage;
		$this->num_pages_per_page = 25;
		$this->init_page = (floor ( ($this->getActualPage () - 1) / $this->getNumPagesPerPage () ) * $this->getNumPagesPerPage ()) + 1;
		$this->end_page = (($this->getInitPage () + $this->getNumPagesPerPage () - 1) < $this->getNumPages ()) ? $this->getInitPage () + $this->getNumPagesPerPage () - 1 : $this->getNumPages ();
		$this->total_rows = $total_rows;
		return $this;
	}

	function getUrlAndGetVars() {
		return $this->url_and_get_vars;
	}

	function getNumPages() {
		return $this->num_pages;
	}

	function getActualPage() {
		return $this->actual_page;
	}

	function getCssClassOtherPage() {
		return $this->css_class_other_page;
	}

	function getCssClassActualPage() {
		return $this->css_class_actual_page;
	}

	function getNumPagesPerPage() {
		return $this->num_pages_per_page;
	}

	function getInitPage() {
		return $this->init_page;
	}

	function getEndPage() {
		return $this->end_page;
	}

	function getTotalRows(){
		return $this->total_rows;
	}
	//
	// Other base methods
	//
	function imprimirPaginado() {
		$html = "";
		if ($this->getNumPages () > 1) {
			$html .= "<span class=\"tituloPaginador\">P&aacute;ginas:&nbsp;&nbsp;</span>";
				
			if (($this->getActualPage ()) > 1) {
				$ds_pag_anterior = "&lt;&lt; anterior";
				$ant_page = ($this->getActualPage ()) - 1;
				$html .= "<a class=\"" . $this->getCssClassOtherPage () . "\" href=\"" . $this->getUrlAndGetVars () . "&page=" . $ant_page . "\" target=\"_self\">$ds_pag_anterior</a>&nbsp;&nbsp;";
			}
				
			if (($this->getInitPage ()) > 1) {
				$ds_pags_anteriores = "[.....]";
				$ant_pages = $this->getInitPage () - 1;
				$html .= "<a class=\"" . $this->getCssClassOtherPage () . "\" href=\"" . $this->getUrlAndGetVars () . "&page=" . $ant_pages . "\" target=\"_self\">$ds_pags_anteriores</a>&nbsp;&nbsp;";
			}
				
			for($i = $this->getInitPage (); $i <= ($this->getEndPage ()); $i ++) {
				if ($i != ($this->getActualPage ())) {
					$html .= "<a class=\"" . $this->getCssClassOtherPage () . "\" href=\"" . $this->getUrlAndGetVars () . "&page=" . $i . "\" target=\"_self\">$i</a> ";
				} else {
					$html .= "<span class=\"" . $this->getCssClassActualPage () . "\">$i</span> ";
				}
			} //final del for
				

			if ($this->getNumPages () > $this->getEndPage ()) {
				$ds_pags_siguientes = "[.....]";
				$sig_pages = $this->getEndPage () + 1;
				$html .= "&nbsp;<a class=\"" . $this->getCssClassOtherPage () . "\" href=\"" . $this->getUrlAndGetVars () . "&page=" . $sig_pages . "\" target=\"_self\">$ds_pags_siguientes</a>";
			}
				
			if (($this->getActualPage ()) < ($this->getNumPages ())) {
				$ds_pag_siguiente = "siguiente &gt;&gt;";
				$sig_page = ($this->getActualPage ()) + 1;
				$html .= "&nbsp;&nbsp;<a class=\"" . $this->getCssClassOtherPage () . "\" href=\"" . $this->getUrlAndGetVars () . "&page=" . $sig_page . "\" target=\"_self\">$ds_pag_siguiente</a>";
			}
		}
		return $html;
	}

	function imprimirResultados(){
		$limitInf = (($this->getActualPage ()-1)*($this->getNumPagesPerPage()))+1;
		$limitSup = ((($limitInf-1)+$this->getNumPagesPerPage())<$this->getTotalRows())?($limitInf-1)+$this->getNumPagesPerPage():$this->getTotalRows();
		$html = "<div class='titCantRegCantRegTotal' align='right'>";
		$html .= " Resultados ";
		$html .= "<b>".$limitInf."</b> - ";
		$html .= "<b>".$limitSup."</b>";
		$html .= " de un Total de ";
		$html .= "<b>".$this->getTotalRows()."</b>";
		$html .= "</div>";
		return $html;
	}
} // class paginador
?>