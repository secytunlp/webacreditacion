<?php
include '../includes/include.php';
include '../includes/datosSession.php';

if (isset ( $_GET ['cd_usuario'] ))
	$cd_usuario = $_GET ['cd_usuario']; else
	$cd_usuario = 0;
/*$oUnidad = new Unidad();
$oUnidad->setCd_usuario($cd_usuario);
UnidadQuery::getUnidadPorId($oUnidad);*/

/*$disciplinas = DisciplinaQuery::getDisciplinasPorDs('');	

$html = '<ul id="ul_disciplinas">';
foreach ($disciplinas as $disciplina) {
	$html .='<li><strong>'.utf8_encode($disciplina['ds_disciplina']).'</strong>';
	$especialidades = EspecialidadQuery::getEspecialidadesPorDs('', $disciplina['cd_disciplina']);
	foreach ($especialidades as $especialidad) {
		$html .='<div>'.utf8_encode($especialidad['ds_especialidad']).'</div>';
	}
	$html .='</li>';	
						
					
}
$html .='</ul>';	*/
$html ="<label>Disciplinas:
					   <input type='text' name='ds_especialidad' id='ds_especialidad' value='' style='width:400px' onchange='mayusculas(this)'/>
                                                <input type='text' id='cd_especialidad' name='cd_especialidad' value='' style='font-size: 10px; width: 20px;display:none'/> 
				  </label> ";					
					

echo $html;

?>