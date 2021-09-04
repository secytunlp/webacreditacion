<?php
//include '../fpdf/fpdf.php';
include '../fpdf/fpdfhtml.php';
include '../includes/include.php';
include '../includes/datosSession.php';


if (PermisoQuery::permisosDeUsuario( $cd_usuario, 'Ver Planilla Admisibilidad' )) {
	
	$oProyecto = new Proyecto ( );
	$oProyecto->setCd_proyecto ($_GET ['id']);
	
	$oPDF_Proyecto = new PDF_Planilla ( );
	$oPDF_Proyecto->AliasNbPages();
	$oPDF_Proyecto->PDF('L');
	ProyectoQuery::getProyectoPorid ( $oProyecto );
	$nuevaFecha = explode ( "-", $oProyecto->getDt_ini() );
	$year = $nuevaFecha [0];
	$ds_titulo = $oProyecto->getDs_titulo();
	$ds_facultad = $oProyecto->getDs_facultad();
	
	$oPDF_Proyecto->AddPage();
	if ($oProyecto->getNu_duracion()==2){		
			$ds_duracion =  "BIENAL";
			
		}
		if ($oProyecto->getNu_duracion()==4){	
			$ds_duracion =  "TETRA ANUAL";	
			
			
		}
	$oUnidad = new Unidad();
	$oUnidad->setCd_unidad($oProyecto->getCd_unidad());
	UnidadQuery::getUnidadPorId($oUnidad);
	$ds_unidad = ($oUnidad->getDs_sigla())?trim($oUnidad->getDs_unidad()).' ('.trim($oUnidad->getDs_sigla()).')':trim($oUnidad->getDs_unidad());

	$oPDF_Proyecto->cabecera($ds_unidad, $ds_duracion);
	
	$oIntegrante = new Integrante();
	$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
	$oIntegrante->setCd_tipoinvestigador(1);
	$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
	
	$oPDF_Proyecto->integrante($integrantes, $oProyecto->getCd_proyecto());
	
	$oIntegrante->setCd_tipoinvestigador(2);
	$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
	if (count($integrantes)>0) {
		$oPDF_Proyecto->integrante($integrantes, $oProyecto->getCd_proyecto());
	}
	
	
	$oIntegrante->setCd_tipoinvestigador(3);
	$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
	if (count($integrantes)>0) {
		$oPDF_Proyecto->integrante($integrantes, $oProyecto->getCd_proyecto());
	}
	
	$oIntegrante->setCd_tipoinvestigador(4);
	$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
	if (count($integrantes)>0) {
		$oPDF_Proyecto->integrante($integrantes, $oProyecto->getCd_proyecto());
	}
	
	$oIntegrante->setCd_tipoinvestigador(5);
	$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
	if (count($integrantes)>0) {
		$oPDF_Proyecto->integrante($integrantes, $oProyecto->getCd_proyecto());
	}
	
	$oIntegrante->setCd_tipoinvestigador(6);
	$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
	if (count($integrantes)>0) {
		$oPDF_Proyecto->integrante($integrantes, $oProyecto->getCd_proyecto());
	}
	//Imprimo el PDF
	
	
	
	$oPDF_Proyecto->Output();
	
} else
	header ( 'Location:../includes/finsolicitud.php' );

?>