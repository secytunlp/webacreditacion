####Investigadores con mas de 2 proyectos
SELECT CONCAT(D.ds_apellido,', ',D.ds_nombre) AS Investigador, CONCAT(D.nu_precuil,'-',D.nu_documento,'-',D.nu_postcuil) as CUIL, P.ds_codigo, I.dt_alta, I.dt_baja
FROM docente D INNER JOIN integrante I ON D.cd_docente = I.cd_docente INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto

WHERE P.dt_fin > '2011-12-31' AND EXISTS (SELECT I2.cd_docente, count( I2.cd_proyecto )
FROM integrante I2
INNER JOIN proyecto P2 ON I2.cd_proyecto = P2.cd_proyecto
WHERE I2.cd_tipoinvestigador <>6 AND D.cd_docente = I2.cd_docente
AND P2.dt_fin > '2011-12-31'
GROUP BY I2.cd_docente
HAVING count( I2.cd_proyecto ) >2)

UPDATE proyecto SET dt_ini= '2012-08-01', dt_fin = '2014-07-31' WHERE cd_tipoacreditacion = 2 AND dt_ini = '2012-01-01'


####################Listado de Proyectos############################
SELECT P.ds_codigo as Proyecto, ds_titulo as Titulo, CONCAT(SUBSTRING(dt_ini,9,2),'/',SUBSTRING(dt_ini,6,2),'/',SUBSTRING(dt_ini,1,4)) as Inicio,CONCAT(SUBSTRING(dt_fin,9,2),'/',SUBSTRING(dt_fin,6,2),'/',SUBSTRING(dt_fin,1,4)) as Fin,CONCAT(D.ds_apellido,', ',D.ds_nombre) as Director
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto 
LEFT JOIN docente D ON I.cd_docente = D.cd_docente 
WHERE P.cd_estado=5 AND dt_ini < '2021-01-01' AND dt_fin >= '2020-01-01' AND I.cd_tipoinvestigador = 1
ORDER BY P.cd_facultad, P.ds_codigo

####################Integrantes de proyectos############################
SELECT CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador, CONCAT(D.nu_precuil,'-',LPAD(D.nu_documento,8,'0'),'-',D.nu_postcuil) AS CUIL, P.ds_codigo as Proyecto, E.ds_tipoacreditacion as Tipo_Proyecto,  
TI.ds_tipoinvestigador as Tipo, EI.ds_estado as Estado, 
CONCAT(SUBSTRING(dt_alta,9,2),'/',SUBSTRING(dt_alta,6,2),'/',SUBSTRING(dt_alta,1,4)) as Alta, 
CONCAT(SUBSTRING(dt_baja,9,2),'/',SUBSTRING(dt_baja,6,2),'/',SUBSTRING(dt_baja,1,4)) as Baja, C.ds_cargo as Cargo, DED.ds_deddoc as Ded_Doc, 
CAT.ds_categoria as Categoria, CASE  WHEN beca.cd_beca IS NULL THEN (CASE D.bl_becario WHEN '1' THEN CONCAT(D.ds_tipobeca, '-', D.ds_orgbeca) ELSE '' END) ELSE CONCAT(beca.ds_tipobeca, '-UNLP') END as becario, 
CASE WHEN (D.cd_carrerainv IS NULL OR D.cd_carrerainv = 11) THEN ''  ELSE CONCAT(carrerainv.ds_carrerainv, '-', organismo.ds_codigo) END carrera, 
I.nu_horasinv 
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto 
LEFT JOIN docente D ON I.cd_docente = D.cd_docente
LEFT JOIN tipoacreditacion E ON E.cd_tipoacreditacion = P.cd_tipoacreditacion 
LEFT JOIN tipoinvestigador TI ON TI.cd_tipoinvestigador = I.cd_tipoinvestigador 

LEFT JOIN cargo C ON C.cd_cargo = D.cd_cargo
LEFT JOIN deddoc DED ON DED.cd_deddoc = D.cd_deddoc
LEFT JOIN categoria CAT ON CAT.cd_categoria = D.cd_categoria
LEFT JOIN estadointegrante EI ON EI.cd_estado = I.cd_estado
LEFT JOIN beca ON D.cd_docente = beca.cd_docente AND beca.dt_hasta >= '2022-01-01' 
LEFT JOIN carrerainv ON D.cd_carrerainv = carrerainv.cd_carrerainv LEFT JOIN organismo ON D.cd_organismo = organismo.cd_organismo

WHERE P.cd_estado = 5 AND dt_fin >= '2022-01-01' AND (I.dt_baja IS NULL OR I.dt_baja = '0000-00-00' OR I.dt_baja > '2022-01-01')
ORDER BY D.ds_apellido, D.ds_nombre

####################Exportar proyectos nuevos entre bases (solo los docentes, integrantes y proyectos hay que pasar desde que los proyectos se importan desde SIGEVA############################
SELECT facultadproyecto.* FROM facultadproyecto INNER JOIN proyecto ON facultadproyecto.cd_proyecto = proyecto.cd_proyecto WHERE proyecto.dt_ini='2014-01-01';

SELECT financiamientoanterior.* FROM financiamientoanterior INNER JOIN proyecto ON financiamientoanterior.cd_proyecto = proyecto.cd_proyecto WHERE proyecto.dt_ini='2014-01-01';

SELECT financiamientoitem.* FROM financiamientoitem INNER JOIN proyecto ON financiamientoitem.cd_proyecto = proyecto.cd_proyecto WHERE proyecto.dt_ini='2014-01-01';

SELECT fondo.* FROM fondo INNER JOIN proyecto ON fondo.cd_proyecto = proyecto.cd_proyecto WHERE proyecto.dt_ini='2014-01-01';

SELECT proyectoevaluador.* FROM proyectoevaluador INNER JOIN proyecto ON proyectoevaluador.cd_proyecto = proyecto.cd_proyecto WHERE proyecto.dt_ini='2014-01-01';

SELECT unidadproyecto.* FROM unidadproyecto INNER JOIN proyecto ON unidadproyecto.cd_proyecto = proyecto.cd_proyecto WHERE proyecto.dt_ini='2014-01-01'

SET FOREIGN_KEY_CHECKS=0;
INSERT INTO incentivos.docente 
SELECT viajes.docente.* FROM viajes.docente WHERE exists(SELECT viajes.integrante.cd_docente FROM viajes.integrante INNER JOIN viajes.proyecto ON viajes.integrante.cd_proyecto = viajes.proyecto.cd_proyecto WHERE viajes.proyecto.dt_ini='2019-01-01' AND viajes.docente.cd_docente = viajes.integrante.cd_docente) AND NOT EXISTS (SELECT incentivos.docente.cd_docente FROM incentivos.docente WHERE incentivos.docente.nu_documento = viajes.docente.nu_documento);
SET FOREIGN_KEY_CHECKS=1;

SET FOREIGN_KEY_CHECKS=0;
INSERT INTO incentivos.proyecto
SELECT viajes.proyecto.* FROM viajes.proyecto WHERE NOT EXISTS (SELECT incentivos.proyecto.cd_proyecto FROM incentivos.proyecto WHERE (viajes.proyecto.cd_proyecto = incentivos.proyecto.cd_proyecto));
SET FOREIGN_KEY_CHECKS=1;

SET FOREIGN_KEY_CHECKS=0;
INSERT INTO incentivos.integrante
SELECT viajes.integrante.* FROM viajes.integrante WHERE NOT EXISTS (SELECT incentivos.integrante.cd_proyecto FROM incentivos.integrante WHERE (viajes.integrante.oid = incentivos.integrante.oid));
SET FOREIGN_KEY_CHECKS=1;

SET FOREIGN_KEY_CHECKS=0;
INSERT INTO incentivos.cyt_integrante_estado
SELECT viajes.cyt_integrante_estado.* FROM viajes.cyt_integrante_estado WHERE NOT EXISTS (SELECT incentivos.cyt_integrante_estado.oid FROM incentivos.cyt_integrante_estado WHERE (viajes.cyt_integrante_estado.oid = incentivos.cyt_integrante_estado.oid));
SET FOREIGN_KEY_CHECKS=1;


############################################ Importar proyectos desde SIGEVA ##########################################

SELECT T.codigo as 'CODIGO TRAMITE', case when C.descripcion like "%I+D%" then 1 else 2 end as CD_TIPOACREDITACION,
DA.tema_periodo as TITULO,
PROY.fecha_inicio_periodo,
PROY.fecha_fin_periodo,  

CASE 
WHEN IVO_unidad.id= 632 THEN 175
WHEN IVO_unidad.id= 627 THEN 170
WHEN IVO_unidad.id= 638 THEN 179
WHEN IVO_unidad.id= 622 THEN 168
WHEN IVO_unidad.id= 623 THEN 176
WHEN IVO_unidad.id= 624 THEN 165
WHEN IVO_unidad.id= 625 THEN 171
WHEN IVO_unidad.id= 626 THEN 172
WHEN IVO_unidad.id= 628 THEN 173
WHEN IVO_unidad.id= 629 THEN 177
WHEN IVO_unidad.id= 630 THEN 181
WHEN IVO_unidad.id= 631 THEN 167
WHEN IVO_unidad.id= 634 THEN 169
WHEN IVO_unidad.id= 635 THEN 180
WHEN IVO_unidad.id= 636 THEN 174
WHEN IVO_unidad.id= 637 THEN 1220
WHEN IVO_unidad.id= 633 THEN 187

END as 'CD_FACULTAD',

O.id as 'CD_UNIDAD',
CASE 
WHEN C.descripcion LIKE "%BIENAL%" THEN 2
WHEN C.descripcion LIKE "%TETRA%" THEN 4
WHEN C.descripcion LIKE "%PPID%" THEN 2
END as 'DURACION',
DA.campo_aplicacion_id,
DD.disciplina_desagregada,
IVO.denominacion, 
DA.resumen_tema_periodo,
DA.palabra_clave_1,
DA.palabra_clave_2,
DA.palabra_clave_3,
DA.palabra_clave_in_1,
DA.palabra_clave_in_2,
DA.palabra_clave_in_3


FROM PERSONA P
INNER JOIN PROPIETARIO PROP ON PROP.persona_responsable_id = P.id
INNER JOIN TRAMITE T ON T.propietario_id = PROP.id
INNER JOIN CONVOCATORIA C ON T.convocatoria_id = C.id
INNER JOIN ESTADO E ON T.estado_id = E.id
INNER JOIN PROPIETARIO_GRUPO PG ON PG.propietario_id = PROP.id
INNER JOIN GRUPO G ON PG.grupo_id = G.id
INNER JOIN LUGAR_TRABAJO_PROPUESTO LTP ON LTP.tramite_id = T.id
INNER JOIN LUGAR_TRABAJO LT ON LT.id = LTP.lugar_trabajo_id
INNER JOIN ORGANIZACION O ON O.id = LT.organizacion_id
LEFT JOIN PROYECTO PROY ON T.id = PROY.tramite_id
LEFT JOIN DATO_ACADEMICO DA ON PROP.id = DA.propietario_id AND DA.fecha_fin_vigencia is null
LEFT JOIN DISCIPLINA_DESAGREGADA DD ON DD.id = DA.disciplina_desagregada_id
inner JOIN FORMULARIO_INSTRUMENTO_TRAMITE FIT ON FIT.tramite_id = T.id
inner JOIN INSTRUMENTO_VARIABLE_OPCION IVO ON IVO.id = FIT.instrumento_variable_opcion_id  AND IVO.instrumento_variable_id=147


inner JOIN FORMULARIO_INSTRUMENTO_TRAMITE FIT_unidad ON FIT_unidad.tramite_id = T.id
inner JOIN INSTRUMENTO_VARIABLE_OPCION IVO_unidad ON IVO_unidad.id = FIT_unidad.instrumento_variable_opcion_id AND IVO_unidad.instrumento_variable_id=148



WHERE
C.grupo_convocatoria_id = 11

AND C.id > 801202000 AND C.id < 801202006 

AND (E.id = 11  OR E.id = 2 OR E.id = 3 OR E.id = 10)


-- OR (C.id = 801201605 AND E.id = 2)



order by T.codigo

############################################ Importar integrantes desde SIGEVA ##########################################

SELECT T.codigo as 'CODIGO TRAMITE', 
PE.apellido as 'APELLIDO INTEGRANTE', 
PE.nombre as 'NOMBRE INTEGRANTE',   
SUBSTRING(PE.cuil,1,2) AS PRECUIL,
DP.numero_documento AS 'DNI INTEGRANTE',
SUBSTRING(PE.cuil,-1) AS POSTCUIL, 
RG.rol_grupo as 'ROL INTEGRANTE',
GP.porcentaje_dedicacion as 'HORAS',
DP.fecha_nacimiento, 
CASE 
WHEN DP.sexo_id LIKE 0 THEN "F"
WHEN DP.sexo_id LIKE 1 THEN "M"
END as 'SEXO'
/*,

CA.fecha_inicio, 
CA.fecha_fin,  
CC.clase_cargo AS CD_CARGO, 
TDHD.tipo_dedicacion_horaria_docente, 
CCID.clase_cargo AS CD_CATEGORIA_CARGO_ID, 
GC.grupo_cargo AS CD_CARRERA*/


FROM PROPIETARIO PROP 
INNER JOIN TRAMITE T ON T.propietario_id = PROP.id
INNER JOIN CONVOCATORIA C ON T.convocatoria_id = C.id
INNER JOIN ESTADO E ON T.estado_id = E.id
INNER JOIN PROPIETARIO_GRUPO PG ON PG.propietario_id = PROP.id
INNER JOIN GRUPO G ON PG.grupo_id = G.id
INNER JOIN GRUPO_PERSONA GP ON GP.grupo_id = G.id  and GP.fecha_baja is NULL
INNER JOIN PERSONA PE ON GP.persona_id = PE.id  
INNER JOIN DATO_PERSONAL DP ON DP.persona_id = PE.id and DP.fecha_fin_vigencia is NULL
INNER JOIN ROL_GRUPO RG ON RG.id = GP.rol_grupo_id
/*LEFT JOIN CARGO CA ON CA.persona_id = PE.id  AND CA.tipo_cargo_id = 3 AND CA.fecha_fin_vigencia IS NULL AND (CA.fecha_fin IS NULL OR CA.fecha_fin > STR_TO_DATE('01-07-2015','%d-%m-%Y') )
LEFT JOIN CLASE_CARGO CC ON CC.id = CA.clase_cargo_id
LEFT JOIN ORGANIZACION O ON O.id = CA.organizacion_id
LEFT JOIN ORGANIZACION_NOMBRE N ON O.id = N.organizacion_id AND N.organizacion_nombre_tipo_id = 6  AND N.organizacion_nombre LIKE '%01850%'
LEFT JOIN CARGO_DOCENTE_SUPERIOR CDS ON CDS.cargo_id = CA.id
LEFT JOIN TIPO_DEDICACION_HORARIA_DOCENTE TDHD ON TDHD.id = CDS.tipo_dedicacion_horaria_docente_id

LEFT JOIN CARGO CID ON CID.persona_id = PE.id  AND CID.tipo_cargo_id = 9 AND CID.fecha_fin_vigencia IS NULL AND CA.fecha_fin IS NULL
LEFT JOIN CLASE_CARGO CCID ON CCID.id = CID.clase_cargo_id
LEFT JOIN GRUPO_CARGO GC ON CCID.grupo_cargo_id = GC.id*/
WHERE
C.grupo_convocatoria_id = 11
AND C.id > 801202000 AND C.id < 801202006

-- AND  C.id < 801201706  

AND (E.id = 11  OR E.id = 2 OR E.id = 3 OR E.id = 10)
AND RG.habilitado = 1





-- AND PE.cuil= '27045088117' 

-- AND T.codigo = '80120150100003LP'

ORDER BY T.codigo

##################################### Crear tablas auxiliares #########################################
CREATE TABLE `proyecto_sigeva` (
`codigo` VARCHAR(16) NULL, 
`tipoacreditacion_oid` INT(11) NULL, 
`titulo` VARCHAR(254) NULL, 
`inicio` DATE NULL, 
`fin` DATE NULL, 
`facultad_oid` INT(11) NULL, 
`unidad_oid` INT(11) NULL, 
`duracion` INT(11) NULL, 
`campo_oid` INT(11) NULL, 
`disciplina` VARCHAR(255) NULL, 
`tipo` VARCHAR(255) NULL, 
`resumen` TEXT NULL, 
`clave_1` VARCHAR(255) NULL, 
`clave_2` VARCHAR(255) NULL, 
`clave_3` VARCHAR(255) NULL, 
`clave_in_1` VARCHAR(255) NULL, 
`clave_in_2` VARCHAR(255) NULL, 
`clave_in_3` VARCHAR(255) NULL) 
ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_spanish_ci;

CREATE TABLE `integrantes_sigeva` (
`codigo` VARCHAR(16) NULL, 
`apellido` VARCHAR(254) NULL, 
`nombre` VARCHAR(254) NULL, 
`precuil` INT(11) NULL, 
`dni` VARCHAR(255) NULL,
`postcuil` INT(11) NULL, 
`rol` VARCHAR(255) NULL, 
`horas` INT(11) NULL,
`nacimiento` DATE NULL, 
`sexo` VARCHAR(1) NULL) 
ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_spanish_ci;

CREATE TABLE `cargos_sigeva` (
`codigo` VARCHAR(16) NULL, 
`apellido` VARCHAR(254) NULL, 
`nombre` VARCHAR(254) NULL, 
`precuil` INT(11) NULL, 
`dni` VARCHAR(255) NULL,
`postcuil` INT(11) NULL, 
`rol` VARCHAR(255) NULL, 
`horas` INT(11) NULL,
`nacimiento` DATE NULL, 
`sexo` VARCHAR(1) NULL,
fecha_inicio date NULL, 
fecha_fin date NULL, 
cd_cargo VARCHAR(254) NULL, 
cd_deddoc VARCHAR(254) NULL,
cd_facultad VARCHAR(254) NULL,
tipo_cargo VARCHAR(254) NULL

) 
ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_spanish_ci;

CREATE TABLE `carreainv_sigeva` (
`codigo` VARCHAR(16) NULL, 
`apellido` VARCHAR(254) NULL, 
`nombre` VARCHAR(254) NULL, 
`precuil` INT(11) NULL, 
`dni` VARCHAR(255) NULL,
`postcuil` INT(11) NULL, 
`rol` VARCHAR(255) NULL, 
`horas` INT(11) NULL,
`nacimiento` DATE NULL, 
`sexo` VARCHAR(1) NULL,
cd_carrerainv VARCHAR(254) NULL, 
cd_organismo VARCHAR(254) NULL,
fecha_inicio date NULL, 
fecha_fin date NULL
) 
ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_spanish_ci;

################# Docentes que estan en SIGEVA y NO en mi WEB ##############################################
INSERT INTO docente (cd_docente, nu_ident, ds_nombre, ds_apellido, nu_precuil, nu_documento, nu_postcuil, dt_nacimiento, ds_sexo)
SELECT DISTINCT ((SELECT MAX(DOC.cd_docente) FROM docente DOC)+1),((SELECT MAX(DOC.cd_docente) FROM docente DOC)+1),I.nombre, I.apellido, I.precuil, I.dni, I.postcuil, I.nacimiento, I.sexo 
FROM `integrantes_sigeva` I WHERE NOT EXISTS ( SELECT D.nu_documento FROM docente D WHERE I.dni = D.nu_documento)

############################# Actualizar proyecto_sigeva #######################################
UPDATE `proyecto_sigeva` SET `facultad_oid` = 574 WHERE `facultad_oid` is null;
UPDATE `proyecto_sigeva` SET `facultad_oid` = 574 WHERE `facultad_oid` =0;

UPDATE `proyecto_sigeva` SET `disciplina` = 30 WHERE disciplina = 'ODONTOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 30 WHERE disciplina = 'ODONTOLOGIA-OPERATORIA DENTAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 30 WHERE disciplina = 'ODONTOLOGIA-OTRAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 30 WHERE disciplina = 'ODONTOLOGIA-PREVENTIVA Y SOCIAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 29 WHERE disciplina = 'CIENCIAS MEDICAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 29 WHERE disciplina = 'MEDICINA-PATOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 29 WHERE disciplina = 'MEDICINA-OTRAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 29 WHERE disciplina = 'MEDICINA';
UPDATE `proyecto_sigeva` SET `disciplina` = 29 WHERE disciplina = 'MEDICINA-FISIOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 29 WHERE disciplina = 'MEDICINA-INMUNOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 29 WHERE disciplina = 'MEDICINA-VARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 29 WHERE disciplina = 'FARMACOLOGIA-CARDIOVASCULAR';
UPDATE `proyecto_sigeva` SET `disciplina` = 29 WHERE disciplina = 'FARMACOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 29 WHERE disciplina = 'FARMACOLOGIA-TOXICOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 29 WHERE disciplina = 'FARMACOLOGIA-FARMACODINAMIA Y DISEO D/FARM';
UPDATE `proyecto_sigeva` SET `disciplina` = 29 WHERE disciplina = 'MEDICINA-ONCOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 29 WHERE disciplina = 'MEDICINA-EPIDEMIOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 29 WHERE disciplina = 'VARIAS CIENCIAS MEDICAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 11 WHERE disciplina = 'VETERINARIA Y ESP. PECUARIAS-VARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 11 WHERE disciplina = 'VETERINARIA Y ESP. PECUARIAS-MICROBIOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 11 WHERE disciplina = 'VETERINARIA Y ESP. PECUARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 11 WHERE disciplina = 'VETERINARIA Y ESP. PECUARIAS-GENET.REP. OBST';
UPDATE `proyecto_sigeva` SET `disciplina` = 11 WHERE disciplina = 'VETERINARIA Y ESP. PECUARIAS-OTRAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 11 WHERE disciplina = 'VETERINARIA Y ESP. PECUARIAS-INFECTOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 11 WHERE disciplina = 'VETERINARIA Y ESP. PECUARIAS-CLINICA ANIMAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 11 WHERE disciplina = 'VETERINARIA Y ESP. PECUARIAS-ZOOTECNIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 11 WHERE disciplina = 'VETERINARIA Y ESP. PECUARIAS-PARASITOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 11 WHERE disciplina = 'VETERINARIA Y ESP. PECUARIAS-ANATOMIA Y FIS';
UPDATE `proyecto_sigeva` SET `disciplina` = 44 WHERE disciplina = 'HISTORIA-DEL ARTE';
UPDATE `proyecto_sigeva` SET `disciplina` = 44 WHERE disciplina = 'LITERATURA Y ARTES-VARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 44 WHERE disciplina = 'LITERATURA Y ARTES-LITERATURA';
UPDATE `proyecto_sigeva` SET `disciplina` = 44 WHERE disciplina = 'LITERATURA Y ARTES-CINEMATOGRAFIA Y TEATROL';
UPDATE `proyecto_sigeva` SET `disciplina` = 44 WHERE disciplina = 'LITERATURA Y ARTES';
UPDATE `proyecto_sigeva` SET `disciplina` = 44 WHERE disciplina = 'LITERATURA Y ARTES-OTRAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 44 WHERE disciplina = 'LITERATURA Y ARTES-PLASTICAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 44 WHERE disciplina = 'LITERATURA Y ARTES-MUSICOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 44 WHERE disciplina = 'LITERATURA Y ARTES-PRESERVACION Y RESTAURACI';
UPDATE `proyecto_sigeva` SET `disciplina` = 43 WHERE disciplina = 'LINGUISTICA-ENSEANZA DE LAS LENGUAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 43 WHERE disciplina = 'LINGUISTICA-VARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 43 WHERE disciplina = 'LINGUISTICA-LENGUAJES EN RELACIONES C/O/CAM';
UPDATE `proyecto_sigeva` SET `disciplina` = 43 WHERE disciplina = 'LINGUISTICA-DESCRIPTIVA';
UPDATE `proyecto_sigeva` SET `disciplina` = 43 WHERE disciplina = 'LINGUISTICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 43 WHERE disciplina = 'LINGUISTICA-HISTORICA Y COMPARADA';
UPDATE `proyecto_sigeva` SET `disciplina` = 39 WHERE disciplina = 'EDUCACION-DIDACTICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 39 WHERE disciplina = 'EDUCACION-OTRAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 39 WHERE disciplina = 'EDUCACION';
UPDATE `proyecto_sigeva` SET `disciplina` = 39 WHERE disciplina = 'EDUCACION-ESPECIAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 39 WHERE disciplina = 'EDUCACION-HISTORIA DE LA EDUCACION';
UPDATE `proyecto_sigeva` SET `disciplina` = 39 WHERE disciplina = 'EDUCACION-PEDAGOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 39 WHERE disciplina = 'EDUCACION-POLITICA Y PLANIFICACION EDUCATIV';
UPDATE `proyecto_sigeva` SET `disciplina` = 39 WHERE disciplina = 'EDUCACION-SOCIOLOGIA DE LA EDUCACION';
UPDATE `proyecto_sigeva` SET `disciplina` = 39 WHERE disciplina = 'EDUCACION-PSICOLOGIA DE LA EDUCACION';
UPDATE `proyecto_sigeva` SET `disciplina` = 39 WHERE disciplina = 'EDUCACION-ADMINISTRACION DE LA EDUCACION';
UPDATE `proyecto_sigeva` SET `disciplina` = 46 WHERE disciplina = 'SOCIOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 46 WHERE disciplina = 'SOCIOLOGIA-VARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 46 WHERE disciplina = 'SOCIOLOGIA-OTRAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 46 WHERE disciplina = 'SOCIOLOGIA-ESTRATIFICACION Y CAMBIO SOCIAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 46 WHERE disciplina = 'SOCIOLOGIA-DEL TRABAJO';
UPDATE `proyecto_sigeva` SET `disciplina` = 46 WHERE disciplina = 'SOCIOLOGIA-DE LA COMUNICACION';
UPDATE `proyecto_sigeva` SET `disciplina` = 46 WHERE disciplina = 'SOCIOLOGIA-RURAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 46 WHERE disciplina = 'VARIAS CIENCIAS SOCIALES';
UPDATE `proyecto_sigeva` SET `disciplina` = 46 WHERE disciplina = 'CIENCIAS SOCIALES';
UPDATE `proyecto_sigeva` SET `disciplina` = 46 WHERE disciplina = 'CIENCIAS HUMANAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 46 WHERE disciplina = 'VARIAS CIENCIAS HUMANAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 10 WHERE disciplina = 'CIENCIAS AGROPECUARIAS Y VETERINARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 10 WHERE disciplina = 'AGRONOMIA Y DASONOMIA-SOCIOLOGIA RURAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 10 WHERE disciplina = 'AGRONOMIA Y DASONOMIA-INGENIERIA FORESTAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 10 WHERE disciplina = 'AGRONOMIA Y DASONOMIA-FITOPATOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 10 WHERE disciplina = 'AGRONOMIA Y DASONOMIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 10 WHERE disciplina = 'AGRONOMIA Y DASONOMIA-VARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 10 WHERE disciplina = 'AGRONOMIA Y DASONOMIA-OTRAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 10 WHERE disciplina = 'AGRONOMIA Y DASONOMIA-INGENIERIA AGRICOLA';
UPDATE `proyecto_sigeva` SET `disciplina` = 10 WHERE disciplina = 'AGRONOMIA Y DASONOMIA-FITOTECNIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 10 WHERE disciplina = 'AGRONOMIA Y DASONOMIA-ECONOMIA AGRICOLA';
UPDATE `proyecto_sigeva` SET `disciplina` = 10 WHERE disciplina = 'AGRONOMIA Y DASONOMIA-SILVICULTURA';
UPDATE `proyecto_sigeva` SET `disciplina` = 10 WHERE disciplina = 'AGRONOMIA Y DASONOMIA-SILVICULTURA';
UPDATE `proyecto_sigeva` SET `disciplina` = 10 WHERE disciplina = 'AGRONOMIA Y DASONOMIA-TECNOL. E INDUST.AGRAR';
UPDATE `proyecto_sigeva` SET `disciplina` = 10 WHERE disciplina = 'AGRONOMIA Y DASONOMIA-EDAFOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 10 WHERE disciplina = 'AGRONOMIA Y DASONOMIA-FITOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 9 WHERE disciplina = 'QUIMICA-INORGANICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 9 WHERE disciplina = 'QUIMICA-APLICADA';
UPDATE `proyecto_sigeva` SET `disciplina` = 9 WHERE disciplina = 'QUIMICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 9 WHERE disciplina = 'QUIMICA-ORGANICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 9 WHERE disciplina = 'QUIMICA-FISICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 9 WHERE disciplina = 'QUIMICA-TECNOLOGICA O INDUSTRIAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 28 WHERE disciplina = 'QUIMICA-FARMACEUTICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 45 WHERE disciplina = 'PSICOLOGIA-OTRAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 45 WHERE disciplina = 'PSICOLOGIA-EDUCACIONAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 45 WHERE disciplina = 'PSICOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 45 WHERE disciplina = 'PSICOLOGIA-SOCIAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 45 WHERE disciplina = 'PSICOLOGIA-CLINICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 45 WHERE disciplina = 'PSICOLOGIA-DEL DESARROLLO';
UPDATE `proyecto_sigeva` SET `disciplina` = 45 WHERE disciplina = 'PSICOLOGIA-PERSONALIDAD';
UPDATE `proyecto_sigeva` SET `disciplina` = 45 WHERE disciplina = 'PSICOLOGIA-VARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 45 WHERE disciplina = 'PSICOLOGIA-LABORAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 41 WHERE disciplina = 'HISTORIA-ANTIGUA';
UPDATE `proyecto_sigeva` SET `disciplina` = 41 WHERE disciplina = 'HISTORIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 41 WHERE disciplina = 'HISTORIA-CONTEMPORANEA';
UPDATE `proyecto_sigeva` SET `disciplina` = 41 WHERE disciplina = 'HISTORIA-VARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 41 WHERE disciplina = 'HISTORIA-SOCIAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 41 WHERE disciplina = 'HISTORIA-OTRAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 41 WHERE disciplina = 'HISTORIA-DE LAS INSTITUCIONES';
UPDATE `proyecto_sigeva` SET `disciplina` = 41 WHERE disciplina = 'HISTORIA-DE LAS IDEAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 41 WHERE disciplina = 'HISTORIA-METODOLOGIA DE LA HISTORIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 41 WHERE disciplina = 'HISTORIA-MODERNA';
UPDATE `proyecto_sigeva` SET `disciplina` = 41 WHERE disciplina = 'HISTORIA-POLITICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 41 WHERE disciplina = 'HISTORIA-DE LAS CIENCIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 24 WHERE disciplina = 'INGENIERIA-TECNOLOGIA DE LOS ALIMENTOS';
UPDATE `proyecto_sigeva` SET `disciplina` = 24 WHERE disciplina = 'INGENIERIA-QUIMICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 17 WHERE disciplina = 'INGENIERIA-ELECTRONICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 15 WHERE disciplina = 'INGENIERIA-CIVIL';
UPDATE `proyecto_sigeva` SET `disciplina` = 14 WHERE disciplina = 'INGENIERIA-AERONAUTICA Y ESPACIAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 20 WHERE disciplina = 'INGENIERIA-MECANICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'INGENIERIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'INGENIERIA-VARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'INGENIERIA-DEL PRODUCTO';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'INGENIERIA-BIOLOGICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'OTRAS CIENCIAS O DISCIPLINAS CIENTIFICAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'INGENIERIA-DE MATERIALES';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'INGENIERIA-FISICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 16 WHERE disciplina = 'INGENIERIA-DE LAS COMUNICACIONES';
UPDATE `proyecto_sigeva` SET `disciplina` = 16 WHERE disciplina = 'INFORMATICA-VARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 16 WHERE disciplina = 'INFORMATICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 16 WHERE disciplina = 'INFORMATICA-DESARROLLO D/EQUIPOS D/COMPUTAC';
UPDATE `proyecto_sigeva` SET `disciplina` = 5 WHERE disciplina = 'GEOGRAFÍA-VARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 5 WHERE disciplina = 'GEOGRAFÍA-URBANA Y RURAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 5 WHERE disciplina = 'GEOGRAFIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 5 WHERE disciplina = 'GEOGRAFÍA-POLÍTICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 5 WHERE disciplina = 'GEOGRAFÍA-ECONÓMICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 5 WHERE disciplina = 'CIENCIAS DE LA TIERRA-GEOGRAFIA (OTRAS)';
UPDATE `proyecto_sigeva` SET `disciplina` = 5 WHERE disciplina = 'CIENCIAS DE LA TIERRA-VARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 5 WHERE disciplina = 'CIENCIAS DE LA TIERRA-HIDROLOGIA SUPERFICIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 3 WHERE disciplina = 'FISICA-TEORICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 3 WHERE disciplina = 'FISICA-DEL ESTADO SOLIDO';
UPDATE `proyecto_sigeva` SET `disciplina` = 3 WHERE disciplina = 'FISICA-OPTICA Y LASER';
UPDATE `proyecto_sigeva` SET `disciplina` = 3 WHERE disciplina = 'FISICA-MATERIA CONDENSADA';
UPDATE `proyecto_sigeva` SET `disciplina` = 3 WHERE disciplina = 'FISICA-ASTROFISICA Y HELIOFISICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 3 WHERE disciplina = 'FISICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 3 WHERE disciplina = 'FISICA-OTRAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 3 WHERE disciplina = 'FISICA-VARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 3 WHERE disciplina = 'FISICA-PLASMA';
UPDATE `proyecto_sigeva` SET `disciplina` = 40 WHERE disciplina = 'FILOSOFIA-CONTEMPORANEA';
UPDATE `proyecto_sigeva` SET `disciplina` = 40 WHERE disciplina = 'FILOSOFIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 40 WHERE disciplina = 'FILOSOFIA-MODERNA';
UPDATE `proyecto_sigeva` SET `disciplina` = 40 WHERE disciplina = 'FILOSOFIA-EPISTEMOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 40 WHERE disciplina = 'FILOSOFIA-ANTROPOLOGIA FILOSOFICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 40 WHERE disciplina = 'FILOSOFIA-ANTIGUA';
UPDATE `proyecto_sigeva` SET `disciplina` = 40 WHERE disciplina = 'FILOSOFIA-ETICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 40 WHERE disciplina = 'FILOSOFIA-DE LA HISTORIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 39 WHERE disciplina = 'EDUCACION-VARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 38 WHERE disciplina = 'ECONOMIA-OTRAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 38 WHERE disciplina = 'ECONOMIA-VARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 38 WHERE disciplina = 'ECONOMIA-SOCIAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 38 WHERE disciplina = 'ECONOMIA-INDUSTRIAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 38 WHERE disciplina = 'ECONOMIA-INTERNACIONAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 38 WHERE disciplina = 'ECONOMIA-FINANZAS Y ADMINISTRACION DE EMPRES';
UPDATE `proyecto_sigeva` SET `disciplina` = 38 WHERE disciplina = 'ECONOMIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 38 WHERE disciplina = 'ECONOMIA-DEL TRABAJO';
UPDATE `proyecto_sigeva` SET `disciplina` = 38 WHERE disciplina = 'ECONOMIA-PLANIFICACION Y DESARROLLO ECONOMI';
UPDATE `proyecto_sigeva` SET `disciplina` = 38 WHERE disciplina = 'ECONOMIA-POLITICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 38 WHERE disciplina = 'ECONOMIA-DE LA EDUCACION';
UPDATE `proyecto_sigeva` SET `disciplina` = 38 WHERE disciplina = 'ECONOMIA-MACROECONOMIA, CUENTAS NACIONALES';
UPDATE `proyecto_sigeva` SET `disciplina` = 38 WHERE disciplina = 'ECONOMIA-ESTADISTICA ECONOMICA, ECONOMETRIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 37 WHERE disciplina = 'DERECHO';
UPDATE `proyecto_sigeva` SET `disciplina` = 37 WHERE disciplina = 'DERECHO-CONSTITUCIONAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 37 WHERE disciplina = 'DERECHO-VARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 37 WHERE disciplina = 'DERECHO-INTERNACIONAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 37 WHERE disciplina = 'DERECHO-AGRARIO Y MINERO';
UPDATE `proyecto_sigeva` SET `disciplina` = 37 WHERE disciplina = 'DERECHO-CIVIL';
UPDATE `proyecto_sigeva` SET `disciplina` = 37 WHERE disciplina = 'DERECHO-OTRAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 34 WHERE disciplina = 'CS. POLITICAS Y ADMINIST. PUBLICA-POLIT. IN';
UPDATE `proyecto_sigeva` SET `disciplina` = 34 WHERE disciplina = 'CS. POLITICAS Y ADMINIST. PUBLICA-POLIT. SOC';
UPDATE `proyecto_sigeva` SET `disciplina` = 34 WHERE disciplina = 'CS. POLITICAS Y ADMINIST. PUBLICA-VARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 6 WHERE disciplina = 'CIENCIAS DE LA TIERRA-GEOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 6 WHERE disciplina = 'CIENCIAS DE LA TIERRA-OTRAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 2 WHERE disciplina = 'BIOLOGIA-ZOOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 2 WHERE disciplina = 'BIOLOGIA-OTRAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 2 WHERE disciplina = 'BIOLOGIA-ENTOMOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 2 WHERE disciplina = 'BIOLOGIA-ECOLOGIA (BIOECOLOGIA)';
UPDATE `proyecto_sigeva` SET `disciplina` = 2 WHERE disciplina = 'BIOLOGIA-CELULAR Y MOLECULAR';
UPDATE `proyecto_sigeva` SET `disciplina` = 2 WHERE disciplina = 'BIOLOGIA-BOTANICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 2 WHERE disciplina = 'BIOLOGIA-BIOQUIMICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 2 WHERE disciplina = 'BIOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 2 WHERE disciplina = 'BIOLOGIA-MICROBIOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 2 WHERE disciplina = 'BIOLOGIA-BIOINGENIERIA, BIOTECNOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 2 WHERE disciplina = 'BIOLOGIA-BIOFISICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 2 WHERE disciplina = 'BIOLOGIA-TAXONOMIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 2 WHERE disciplina = 'BIOLOGIA-INMUNOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 2 WHERE disciplina = 'BIOLOGIA-GENETICA (BIOGENETICA)';
UPDATE `proyecto_sigeva` SET `disciplina` = 33 WHERE disciplina = 'BIBLIOTECOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 1 WHERE disciplina = 'ASTRONOMIA-ASTROFISICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 1 WHERE disciplina = 'ASTRONOMIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 1 WHERE disciplina = 'ASTRONOMIA-GALAXIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 1 WHERE disciplina = 'ASTRONOMIA-MECANICA CELESTE';
UPDATE `proyecto_sigeva` SET `disciplina` = 26 WHERE disciplina = 'ARQUITECTURA-CONSERVACION Y RESTAURAC.EDIFIC';
UPDATE `proyecto_sigeva` SET `disciplina` = 26 WHERE disciplina = 'ARQUITECTURA-PLANIFICACION URBANA';
UPDATE `proyecto_sigeva` SET `disciplina` = 26 WHERE disciplina = 'ARQUITECTURA';
UPDATE `proyecto_sigeva` SET `disciplina` = 26 WHERE disciplina = 'ARQUITECTURA-OTRAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 26 WHERE disciplina = 'ARQUITECTURA-DISEOS, PROYECTOS';
UPDATE `proyecto_sigeva` SET `disciplina` = 26 WHERE disciplina = 'ARQUITECTURA-VARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 26 WHERE disciplina = 'ARQUITECTURA-VIVIENDA ECONOMICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 26 WHERE disciplina = 'ARQUITECTURA-HISTORIA DE LA ARQUITECTURA';
UPDATE `proyecto_sigeva` SET `disciplina` = 26 WHERE disciplina = 'ARQUITECTURA-HISTORIA DE LA ARQUITECTURA';
UPDATE `proyecto_sigeva` SET `disciplina` = 26 WHERE disciplina = 'CIENCIAS DE LA INGENIERIA Y ARQUITECTURA';
UPDATE `proyecto_sigeva` SET `disciplina` = 26 WHERE disciplina = 'PLANEAMIENTO';
UPDATE `proyecto_sigeva` SET `disciplina` = 26 WHERE disciplina = 'PLANEAMIENTO-URBANA';
UPDATE `proyecto_sigeva` SET `disciplina` = 32 WHERE disciplina = 'ANTROPOLOGIA-VARIAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 32 WHERE disciplina = 'ANTROPOLOGIA-FISICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 32 WHERE disciplina = 'ANTROPOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 32 WHERE disciplina = 'ANTROPOLOGIA-ARQUEOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 32 WHERE disciplina = 'ANTROPOLOGIA-ETNOLOGIA Y ETNOGRAFIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 32 WHERE disciplina = 'ANTROPOLOGIA-OTRAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 32 WHERE disciplina = 'ANTROPOLOGIA-PREHISTORIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'CIENCIAS EXACTAS Y NATURALES';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'CIENCIAS DE LA TIERRA-MEDIO AMBIENTE CONTAM';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'CIENCIAS DE LA TIERRA-CONTAMINACION D/LAS A';
UPDATE `proyecto_sigeva` SET `disciplina` = 4 WHERE disciplina = 'CIENCIAS DE LA TIERRA-GEOFISICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'CIENCIAS DE LA TIERRA-CLIMATOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'CIENCIAS DE LA TIERRA-ATMOSFERICAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'CIENCIAS DE LA TIERRA';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'CIENCIAS DE LA TIERRA-HIDROSFERICAS';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'CIENCIAS DE LA TIERRA-AERONOMIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'BIOTECNOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 7 WHERE disciplina = 'MATEMATICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 7 WHERE disciplina = 'MATEMATICA-ESTADISTICA MATEMATICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 7 WHERE disciplina = 'MATEMATICA-FUNDAMENTOS Y LOGICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'CS. AMB-ECOTOXICOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'CS. AMB-ECOTOXICOLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'CS. AMB-ECOHIDROLOGIA';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'CS. AMB-CONTAMINACIÓN';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'CS. AMB-CAMBIOS EN EL USO DEL SUELO';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'CS. AMB-ORDENAMIENTO AMBIENTAL TERRITORIAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'CS. AMB-GEOGRAFÍA AMBIENTAL';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'CS. AMB-ECOLOGIA POLÍTICA';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'CS. AMB-BIOREMEDIACIÓN';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'CIENCIAS AMBIENTALES';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'CIENCIAS DE LA TIERRA-HIDROLOGIA SUBTERRANE';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'VARIAS CS. O ESPECIALIDADES MULTIDISCIPLINA';
UPDATE `proyecto_sigeva` SET `disciplina` = 47 WHERE disciplina = 'OTRAS';

UPDATE `proyecto_sigeva` SET `tipo` = 'A' WHERE tipo = 'Investigación aplicada';
UPDATE `proyecto_sigeva` SET `tipo` = 'B' WHERE tipo = 'Investigación básica';
UPDATE `proyecto_sigeva` SET `tipo` = 'D' WHERE tipo = 'Desarrollo experimental o tecnológico';

INSERT INTO proyecto (cd_proyecto, ds_codigo, ds_titulo, dt_ini, dt_fin, cd_facultad, nu_duracion, cd_unidad, cd_campo, cd_disciplina, ds_tipo, cd_estado, ds_abstract1, ds_clave1, ds_clave2, ds_clave3, ds_claveeng1, ds_claveeng2, ds_claveeng3, cd_tipoacreditacion)
SELECT ((SELECT MAX(P.cd_proyecto) FROM proyecto P)+1), PS.codigo, PS.titulo, PS.inicio, PS.fin, PS.facultad_oid, PS.duracion, PS.unidad_oid, PS.campo_oid, PS.disciplina, PS.tipo, '6', PS.resumen, PS.clave_1, PS.clave_2, PS.clave_3, PS.clave_in_1, PS.clave_in_2, PS.clave_in_3, PS.tipoacreditacion_oid FROM `proyecto_sigeva` PS 
WHERE NOT EXISTS ( SELECT P1.ds_codigo FROM proyecto P1 WHERE PS.codigo = P1.ds_codigo);

UPDATE `proyecto` set ds_codigoSIGEVA=ds_codigo WHERE dt_ini = '2021-01-01';

############################# Actualizar unidades de investigación #######################################
OJO!!!!! "UNIDAD DE INVESTIGACION ODONTOLOGIA REHABILITADORA"
"LABORATORIO DE PARASITOSIS HUMANAS Y ZOONOSIS PARASITARIAS"


UPDATE `proyecto` SET cd_unidad= '110130' WHERE cd_unidad = 25784;
UPDATE `proyecto` SET cd_unidad= '900035' WHERE cd_unidad = 25926;
UPDATE `proyecto` SET cd_unidad= '110910' WHERE cd_unidad = 24969;
UPDATE `proyecto` SET cd_unidad= '22126' WHERE cd_unidad = 22715;
UPDATE `proyecto` SET cd_unidad= '22126' WHERE cd_unidad = 22020;
UPDATE `proyecto` SET cd_unidad= '1874' WHERE cd_unidad = 25638;
UPDATE `proyecto` SET cd_unidad= '110522' WHERE cd_unidad = 24600;
UPDATE `proyecto` SET cd_unidad= '110522' WHERE cd_unidad = 21922;
UPDATE `proyecto` SET cd_unidad= '111127' WHERE cd_unidad = 25033;
UPDATE `proyecto` SET cd_unidad= '111126' WHERE cd_unidad = 25032;
UPDATE `proyecto` SET cd_unidad= '111122' WHERE cd_unidad = 25400; 
UPDATE `proyecto` SET cd_unidad= '111108' WHERE cd_unidad = 23081; 
UPDATE `proyecto` SET cd_unidad= '111124' WHERE cd_unidad = 24970;
UPDATE `proyecto` SET cd_unidad= '111120' WHERE cd_unidad = 24599;
UPDATE `proyecto` SET cd_unidad= '900003' WHERE cd_unidad = 23735;
UPDATE `proyecto` SET cd_unidad= '110716' WHERE cd_unidad = 26322;
UPDATE `proyecto` SET cd_unidad= '110717' WHERE cd_unidad = 26300;
UPDATE `proyecto` SET cd_unidad= '13177' WHERE cd_unidad = 24792;
UPDATE `proyecto` SET cd_unidad= '900053' WHERE cd_unidad = 23757;
UPDATE `proyecto` SET cd_unidad= '110335' WHERE cd_unidad = 25042;
UPDATE `proyecto` SET cd_unidad= '110334' WHERE cd_unidad = 25031;
UPDATE `proyecto` SET cd_unidad= '110333' WHERE cd_unidad = 24967;
UPDATE `proyecto` SET cd_unidad= '900034' WHERE cd_unidad = 26967;
UPDATE `proyecto` SET cd_unidad= '14122' WHERE cd_unidad = 25977;

#UPDATE `integrantes_sigeva` SET `horas` = 0 WHERE rol = 'Colaborador';
UPDATE `integrantes_sigeva` SET `rol` = 6 WHERE rol = 'Colaborador';
UPDATE `integrantes_sigeva` SET `rol` = 1 WHERE rol = 'Titular';
UPDATE `integrantes_sigeva` SET `rol` = 2 WHERE rol = 'Co-titular';
UPDATE `integrantes_sigeva` SET `rol` = 5 WHERE rol = 'Becario - Tesista';
UPDATE `integrantes_sigeva` SET `rol` = 4 WHERE rol = 'Investigador En Formación';
UPDATE `integrantes_sigeva` SET `rol` = 3 WHERE rol = 'Investigador Formado';
###############UPDATE `integrantes_sigeva` I INNER JOIN docente D ON I.dni = D.nu_documento 
###############SET `rol` = 3 
###############WHERE rol = 'Investigador' AND D.cd_categoria IN (6,7,8);
###############UPDATE `integrantes_sigeva` I INNER JOIN docente D ON I.dni = D.nu_documento 
###############SET `rol` = 4 
###############WHERE rol = 'Investigador' AND D.cd_categoria NOT IN (6,7,8);

INSERT INTO integrante (cd_proyecto, cd_docente, cd_tipoinvestigador, dt_alta, nu_horasinv, cd_estado, ds_mail, cd_categoria, cd_deddoc, cd_cargo, dt_cargo, cd_facultad, cd_unidad, cd_carrerainv, cd_organismo, cd_universidad, ds_orgbeca, ds_tipobeca, dt_beca, cd_titulo, cd_titulopost, bl_estudiante, nu_materias, bl_becaEstimulo, dt_becaEstimulo )
SELECT P.cd_proyecto, D.cd_docente, I.rol, '2021-01-01', I.horas, 3, D.ds_mail, D.cd_categoria, D.cd_deddoc, D.cd_cargo, D.dt_cargo, D.cd_facultad, D.cd_unidad, D.cd_carrerainv, D.cd_organismo, D.cd_universidad, D.ds_orgbeca, D.ds_tipobeca, D.dt_beca, D.cd_titulo, D.cd_titulopost, D.bl_estudiante, D.nu_materias, D.bl_becaEstimulo, D.dt_becaEstimulo 
FROM `integrantes_sigeva` I INNER JOIN proyecto P ON I.codigo = P.ds_codigo 
INNER JOIN docente D ON I.dni = D.nu_documento
WHERE NOT EXISTS (SELECT I2.oid FROM integrante I2 WHERE D.cd_docente = I2.cd_docente AND I2.cd_proyecto = P.cd_proyecto );

INSERT INTO cyt_integrante_estado (integrante_oid, estado_oid, tipoInvestigador_oid, dt_alta, nu_horasinv, user_oid, categoria_oid, deddoc_oid, cargo_oid, facultad_oid, fechaDesde,carrerainv_oid,organismo_oid,ds_orgbeca,ds_tipobeca,dt_beca,dt_becaHasta,bl_becaEstimulo,dt_becaEstimulo,dt_becaEstimuloHasta)
SELECT INTE.oid, 3, I.rol, '2021-01-01', I.horas, 1, D.cd_categoria, D.cd_deddoc, D.cd_cargo, D.cd_facultad, now(),D.cd_carrerainv,D.cd_organismo,D.ds_orgbeca,D.ds_tipobeca,D.dt_beca,D.dt_becaHasta,D.bl_becaEstimulo,D.dt_becaEstimulo,D.dt_becaEstimuloHasta
FROM `integrantes_sigeva` I INNER JOIN proyecto P ON I.codigo = P.ds_codigo 
INNER JOIN docente D ON I.dni = D.nu_documento
INNER JOIN integrante INTE ON INTE.cd_docente = D.cd_docente AND INTE.cd_proyecto = P.cd_proyecto 
WHERE NOT EXISTS (SELECT I2.oid FROM cyt_integrante_estado I2 WHERE INTE.oid = I2.integrante_oid );


############################################ Actualizar cargos desde SIGEVA (no lo he usado)##########################################
UPDATE `cargos_sigeva` SET `cd_deddoc` = 2 WHERE cd_deddoc = 'Semi-exclusiva';
UPDATE `cargos_sigeva` SET `cd_deddoc` = 2 WHERE cd_deddoc = 'Parcial';
UPDATE `cargos_sigeva` SET `cd_deddoc` = 3 WHERE cd_deddoc = 'Simple';
UPDATE `cargos_sigeva` SET `cd_deddoc` = 1 WHERE cd_deddoc = 'Exclusiva';
UPDATE `cargos_sigeva` SET `cd_deddoc` = 1 WHERE cd_deddoc = 'Completa';

UPDATE `cargos_sigeva` SET `cd_cargo` = 1 WHERE cd_cargo = 'Profesor titular' AND tipo_cargo = 'Regular o por concurso';
UPDATE `cargos_sigeva` SET `cd_cargo` = 7 WHERE cd_cargo = 'Profesor titular' AND tipo_cargo = 'Interino';
UPDATE `cargos_sigeva` SET `cd_cargo` = 7 WHERE cd_cargo = 'Profesor titular' AND tipo_cargo = 'Por contrato';
UPDATE `cargos_sigeva` SET `cd_cargo` = 2 WHERE cd_cargo = 'Profesor adjunto' AND tipo_cargo = 'Regular o por concurso';
UPDATE `cargos_sigeva` SET `cd_cargo` = 8 WHERE cd_cargo = 'Profesor adjunto' AND tipo_cargo = 'Interino';
UPDATE `cargos_sigeva` SET `cd_cargo` = 8 WHERE cd_cargo = 'Profesor adjunto' AND tipo_cargo = 'Por contrato';
UPDATE `cargos_sigeva` SET `cd_cargo` = 3 WHERE cd_cargo = 'Profesor asociado' AND tipo_cargo = 'Regular o por concurso';
UPDATE `cargos_sigeva` SET `cd_cargo` = 9 WHERE cd_cargo = 'Profesor asociado' AND tipo_cargo = 'Interino';
UPDATE `cargos_sigeva` SET `cd_cargo` = 9 WHERE cd_cargo = 'Profesor asociado' AND tipo_cargo = 'Por contrato';
UPDATE `cargos_sigeva` SET `cd_cargo` = 4 WHERE cd_cargo = 'Jefe de trabajos prácticos' AND tipo_cargo = 'Regular o por concurso';
UPDATE `cargos_sigeva` SET `cd_cargo` = 10 WHERE cd_cargo = 'Jefe de trabajos prácticos' AND tipo_cargo = 'Interino';
UPDATE `cargos_sigeva` SET `cd_cargo` = 10 WHERE cd_cargo = 'Jefe de trabajos prácticos' AND tipo_cargo = 'Por contrato';
UPDATE `cargos_sigeva` SET `cd_cargo` = 5 WHERE cd_cargo = 'Ayudante diplomado' AND tipo_cargo = 'Regular o por concurso';
UPDATE `cargos_sigeva` SET `cd_cargo` = 11 WHERE cd_cargo = 'Ayudante diplomado' AND tipo_cargo = 'Interino';
UPDATE `cargos_sigeva` SET `cd_cargo` = 11 WHERE cd_cargo = 'Ayudante diplomado' AND tipo_cargo = 'Por contrato';
UPDATE `cargos_sigeva` SET `cd_cargo` = 11 WHERE cd_cargo = 'Ayudante de primera' AND tipo_cargo = 'Interino';
UPDATE `cargos_sigeva` SET `cd_cargo` = 11 WHERE cd_cargo = 'Ayudante de primera' AND tipo_cargo = 'Por contrato';
UPDATE `cargos_sigeva` SET `cd_cargo` = 12 WHERE cd_cargo = 'Profesor emérito';
UPDATE `cargos_sigeva` SET `cd_cargo` = 13 WHERE cd_cargo = 'Profesor consulto';


UPDATE docente AS D
JOIN
(SELECT C.* FROM cargos_sigeva C
JOIN
(SELECT C1.dni, C1.cd_deddoc, MIN( C1.`cd_cargo`) AS maxcargo  FROM cargos_sigeva C1
JOIN
(SELECT C2.`dni`, MIN( C2.`cd_deddoc`) AS maxded
FROM cargos_sigeva C2
WHERE C2.`cd_deddoc` IN ( 1, 2, 3 )
GROUP BY C2.`dni`) AS dmax
ON C1.`dni` = dmax.`dni` AND C1.cd_deddoc = dmax.maxded
WHERE C1.`cd_cargo` IN ( 1, 2, 3,4,5,7,8,9,10,11,12,13 )
GROUP BY C1.`dni`, C1.cd_deddoc) AS cmax
ON C.`dni` = cmax.`dni` AND C.cd_cargo = cmax.maxcargo AND C.cd_deddoc = cmax.cd_deddoc) AS cargos_sigeva
ON D.nu_documento = cargos_sigeva.dni 
SET D.cd_cargo = cargos_sigeva.cd_cargo, D.cd_deddoc = cargos_sigeva.cd_deddoc, D.dt_cargo = cargos_sigeva.fecha_inicio;

UPDATE integrante I INNER JOIN docente AS D ON I.cd_docente = D.cd_docente
INNER JOIN proyecto AS P ON I.cd_proyecto = P.cd_proyecto
JOIN
(SELECT C.* FROM cargos_sigeva C
JOIN
(SELECT C1.codigo,C1.dni, C1.cd_deddoc, MIN( C1.`cd_cargo`) AS maxcargo  FROM cargos_sigeva C1
JOIN
(SELECT C2.`dni`, MIN( C2.`cd_deddoc`) AS maxded
FROM cargos_sigeva C2
WHERE C2.`cd_deddoc` IN ( 1, 2, 3 )
GROUP BY C2.`dni`) AS dmax
ON C1.`dni` = dmax.`dni` AND C1.cd_deddoc = dmax.maxded
WHERE C1.`cd_cargo` IN ( 1, 2, 3,4,5,7,8,9,10,11,12,13 )
GROUP BY C1.`codigo`,C1.`dni`, C1.cd_deddoc) AS cmax
ON C.`dni` = cmax.`dni` AND C.cd_cargo = cmax.maxcargo AND C.cd_deddoc = cmax.cd_deddoc) AS cargos_sigeva
ON D.nu_documento = cargos_sigeva.dni AND P.ds_codigo = cargos_sigeva.codigo
SET I.cd_cargo = cargos_sigeva.cd_cargo, I.cd_deddoc = cargos_sigeva.cd_deddoc, I.dt_cargo = cargos_sigeva.fecha_inicio;

UPDATE cyt_integrante_estado E INNER JOIN integrante I ON E.integrante_oid = I.oid  INNER JOIN docente AS D ON I.cd_docente = D.cd_docente
INNER JOIN proyecto AS P ON I.cd_proyecto = P.cd_proyecto
JOIN
(SELECT C.* FROM cargos_sigeva C
JOIN
(SELECT C1.codigo, C1.dni, C1.cd_deddoc, MIN( C1.`cd_cargo`) AS maxcargo  FROM cargos_sigeva C1
JOIN
(SELECT C2.`dni`, MIN( C2.`cd_deddoc`) AS maxded
FROM cargos_sigeva C2
WHERE C2.`cd_deddoc` IN ( 1, 2, 3 )
GROUP BY C2.`dni`) AS dmax
ON C1.`dni` = dmax.`dni` AND C1.cd_deddoc = dmax.maxded
WHERE C1.`cd_cargo` IN ( 1, 2, 3,4,5,7,8,9,10,11,12,13 )
GROUP BY C1.`codigo`,C1.`dni`, C1.cd_deddoc) AS cmax
ON C.`dni` = cmax.`dni` AND C.cd_cargo = cmax.maxcargo AND C.cd_deddoc = cmax.cd_deddoc) AS cargos_sigeva
ON D.nu_documento = cargos_sigeva.dni AND P.ds_codigo = cargos_sigeva.codigo
SET E.cargo_oid = cargos_sigeva.cd_cargo, E.deddoc_oid = cargos_sigeva.cd_deddoc;

############################################ Actualizar cargos desde alfabetico ##########################################
UPDATE `cargos_alfabetico` SET `cd_deddoc` = 1 WHERE clase LIKE '%E' AND escalafon = 'Docente' AND situacion = 'Trabajando';
UPDATE `cargos_alfabetico` SET `cd_deddoc` = 2 WHERE clase LIKE '%S' AND escalafon = 'Docente' AND situacion = 'Trabajando';
UPDATE `cargos_alfabetico` SET `cd_deddoc` = 3 WHERE clase LIKE '%X' AND escalafon = 'Docente' AND situacion = 'Trabajando'; 

UPDATE `cargos_alfabetico` SET `cd_cargo` = 1 WHERE clase LIKE '05%' AND escalafon = 'Docente' AND situacion = 'Trabajando';
UPDATE `cargos_alfabetico` SET `cd_cargo` = 2 WHERE clase LIKE '07%' AND escalafon = 'Docente' AND situacion = 'Trabajando';
UPDATE `cargos_alfabetico` SET `cd_cargo` = 3 WHERE clase LIKE '06%' AND escalafon = 'Docente' AND situacion = 'Trabajando';
UPDATE `cargos_alfabetico` SET `cd_cargo` = 4 WHERE clase LIKE '08%' AND escalafon = 'Docente' AND situacion = 'Trabajando';
UPDATE `cargos_alfabetico` SET `cd_cargo` = 5 WHERE clase LIKE '09%' AND escalafon = 'Docente' AND situacion = 'Trabajando';


####Cargos distintos
SELECT DISTINCT CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador, CONCAT(D.nu_precuil,'-',D.nu_documento,'-',D.nu_postcuil) as CUIL, cargo.ds_cargo as Cargo, DED.ds_deddoc as Ded_Doc, F.ds_facultad, C.*  
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto 
LEFT JOIN docente D ON I.cd_docente = D.cd_docente
LEFT JOIN cargo ON cargo.cd_cargo = D.cd_cargo
LEFT JOIN deddoc DED ON DED.cd_deddoc = D.cd_deddoc
INNER JOIN cargos_alfabetico C ON D.nu_documento = C.dni
LEFT JOIN facultad F ON D.cd_facultad = F.cd_facultad
JOIN
(SELECT C1.dni, C1.cd_deddoc, MIN( C1.`cd_cargo`) AS maxcargo  FROM cargos_alfabetico C1
JOIN
(SELECT C2.`dni`, MIN( C2.`cd_deddoc`) AS maxded
FROM cargos_alfabetico C2
WHERE C2.`cd_deddoc` IN ( 1, 2, 3 ) AND C2.escalafon = 'Docente'
GROUP BY C2.`dni`) AS dmax
ON C1.`dni` = dmax.`dni` AND C1.cd_deddoc = dmax.maxded
WHERE C1.`cd_cargo` IN ( 1, 2, 3,4,5,7,8,9,10,11,12,13 ) AND C1.escalafon = 'Docente'
GROUP BY C1.`dni`, C1.cd_deddoc) AS cmax
ON C.`dni` = cmax.`dni` AND C.cd_cargo = cmax.maxcargo AND C.cd_deddoc = cmax.cd_deddoc
WHERE P.dt_fin > '2019-12-31' AND C.escalafon = 'Docente' AND ((D.cd_cargo IN (1,7) AND C.cd_cargo != 1) OR (D.cd_cargo IN (2,8) 
AND C.cd_cargo != 2) OR (D.cd_cargo IN (3,9) AND C.cd_cargo != 3) OR (D.cd_cargo IN (4,10) AND C.cd_cargo != 4) OR (D.cd_cargo IN (5,11) 
AND C.cd_cargo != 5) OR D.cd_cargo = 6 OR D.cd_cargo IS NULL) 

#################Actualizar facultad con alfabético ############################
####Facultades no declaradas
SELECT DISTINCT CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador, CONCAT(D.nu_precuil,'-',D.nu_documento,'-',D.nu_postcuil) as CUIL, cargo.ds_cargo as Cargo, DED.ds_deddoc as Ded_Doc, F.ds_facultad, C.*  
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto 
LEFT JOIN docente D ON I.cd_docente = D.cd_docente
LEFT JOIN cargo ON cargo.cd_cargo = D.cd_cargo
LEFT JOIN deddoc DED ON DED.cd_deddoc = D.cd_deddoc
INNER JOIN cargos_alfabetico C ON D.nu_documento = C.dni
LEFT JOIN facultad F ON D.cd_facultad = F.cd_facultad
JOIN
(SELECT C1.dni, C1.cd_deddoc, MIN( C1.`cd_cargo`) AS maxcargo  FROM cargos_alfabetico C1
JOIN
(SELECT C2.`dni`, MIN( C2.`cd_deddoc`) AS maxded
FROM cargos_alfabetico C2
WHERE C2.`cd_deddoc` IN ( 1, 2, 3 ) AND C2.escalafon = 'Docente'
GROUP BY C2.`dni`) AS dmax
ON C1.`dni` = dmax.`dni` AND C1.cd_deddoc = dmax.maxded
WHERE C1.`cd_cargo` IN ( 1, 2, 3,4,5,7,8,9,10,11,12,13 ) AND C1.escalafon = 'Docente'
GROUP BY C1.`dni`, C1.cd_deddoc) AS cmax
ON C.`dni` = cmax.`dni` AND C.cd_cargo = cmax.maxcargo AND C.cd_deddoc = cmax.cd_deddoc
WHERE P.dt_fin > '2019-12-31' AND C.escalafon = 'Docente' AND (D.cd_facultad is null OR D.cd_facultad = 574 OR D.cd_facultad = 0 OR D.cd_facultad = "")

#################Se crea una tabla auxiliar  ############################

CREATE TABLE IF NOT EXISTS `facultad_a_actualizar` (
  `dni` varchar(255) DEFAULT NULL,
  `investigador` varchar(254) DEFAULT NULL,
  `cd_facultad` varchar(254) DEFAULT NULL,
  `nacimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

UPDATE 
docente  INNER JOIN facultad_a_actualizar  ON docente.nu_documento = facultad_a_actualizar.dni
SET docente.cd_facultad = facultad_a_actualizar.cd_facultad, docente.dt_nacimiento = facultad_a_actualizar.nacimiento;

UPDATE integrante I 
INNER JOIN proyecto AS P ON I.cd_proyecto = P.cd_proyecto
INNER JOIN docente AS D ON I.cd_docente = D.cd_docente
INNER JOIN facultad_a_actualizar  ON D.nu_documento = facultad_a_actualizar.dni
SET I.cd_facultad = facultad_a_actualizar.cd_facultad
WHERE P.dt_fin > '2019-12-31';

UPDATE cyt_integrante_estado E 
INNER JOIN integrante I ON E.integrante_oid = I.oid  
INNER JOIN docente AS D ON I.cd_docente = D.cd_docente
INNER JOIN proyecto AS P ON I.cd_proyecto = P.cd_proyecto
INNER JOIN facultad_a_actualizar  ON D.nu_documento = facultad_a_actualizar.dni
SET E.facultad_oid = facultad_a_actualizar.cd_facultad, E.motivo = CONCAT(motivo, '.\r\nFacultad actualizada el ',now())
WHERE P.dt_fin > '2019-12-31' AND E.fechaHasta IS NULL AND E.motivo IS NOT NULL;

UPDATE cyt_integrante_estado E 
INNER JOIN integrante I ON E.integrante_oid = I.oid  
INNER JOIN docente AS D ON I.cd_docente = D.cd_docente
INNER JOIN proyecto AS P ON I.cd_proyecto = P.cd_proyecto
INNER JOIN facultad_a_actualizar  ON D.nu_documento = facultad_a_actualizar.dni
SET E.facultad_oid = facultad_a_actualizar.cd_facultad, E.motivo = CONCAT('Facultad actualizada el ',now())
WHERE P.dt_fin > '2019-12-31' AND E.fechaHasta IS NULL AND E.motivo IS NULL;

#################Se crea una tabla auxiliar con una columna "concursado" booleana completada a mano ############################

CREATE TABLE IF NOT EXISTS `cargos_a_actualizar` (
  `dni` varchar(255) DEFAULT NULL,
  `investigador` varchar(254) DEFAULT NULL,
  `cd_facultad` varchar(254) DEFAULT NULL,
  `clase` varchar(254) DEFAULT NULL,
  `dt_fecha` date DEFAULT NULL,
  `nacimiento` date DEFAULT NULL,
  `cd_cargo` varchar(254) DEFAULT NULL,
  `cd_deddoc` varchar(254) DEFAULT NULL,
  concursado INT(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 


UPDATE `cargos_a_actualizar` SET `cd_cargo` = 7 WHERE cd_cargo = 1 AND concursado = 0;
UPDATE `cargos_a_actualizar` SET `cd_cargo` = 8 WHERE cd_cargo = 2 AND concursado = 0;
UPDATE `cargos_a_actualizar` SET `cd_cargo` = 9 WHERE cd_cargo = 3 AND concursado = 0;
UPDATE `cargos_a_actualizar` SET `cd_cargo` = 10 WHERE cd_cargo = 4 AND concursado = 0;
UPDATE `cargos_a_actualizar` SET `cd_cargo` = 11 WHERE cd_cargo = 5 AND concursado = 0;

UPDATE 
docente  INNER JOIN cargos_a_actualizar  ON docente.nu_documento = cargos_a_actualizar.dni
SET docente.cd_facultad = cargos_a_actualizar.cd_facultad, docente.dt_nacimiento = cargos_a_actualizar.nacimiento, 
docente.dt_cargo = cargos_a_actualizar.dt_fecha, docente.cd_cargo = cargos_a_actualizar.cd_cargo, 
docente.cd_deddoc = cargos_a_actualizar.cd_deddoc;

UPDATE integrante I 
INNER JOIN proyecto AS P ON I.cd_proyecto = P.cd_proyecto
INNER JOIN docente AS D ON I.cd_docente = D.cd_docente
INNER JOIN cargos_a_actualizar  ON D.nu_documento = cargos_a_actualizar.dni
SET I.cd_facultad = cargos_a_actualizar.cd_facultad,I.cd_cargo = cargos_a_actualizar.cd_cargo, I.cd_deddoc = cargos_a_actualizar.cd_deddoc, I.dt_cargo = cargos_a_actualizar.dt_fecha
WHERE P.dt_fin > '2019-12-31';

UPDATE cyt_integrante_estado E 
INNER JOIN integrante I ON E.integrante_oid = I.oid  
INNER JOIN docente AS D ON I.cd_docente = D.cd_docente
INNER JOIN proyecto AS P ON I.cd_proyecto = P.cd_proyecto
INNER JOIN cargos_a_actualizar  ON D.nu_documento = cargos_a_actualizar.dni
SET E.facultad_oid = cargos_a_actualizar.cd_facultad,E.cargo_oid = cargos_a_actualizar.cd_cargo, E.deddoc_oid = cargos_a_actualizar.cd_deddoc, E.motivo = CONCAT(motivo, '.\r\nCargo y ded actualizados el ',now())
WHERE P.dt_fin > '2019-12-31' AND E.fechaHasta IS NULL AND E.motivo IS NOT NULL;

UPDATE cyt_integrante_estado E 
INNER JOIN integrante I ON E.integrante_oid = I.oid  
INNER JOIN docente AS D ON I.cd_docente = D.cd_docente
INNER JOIN proyecto AS P ON I.cd_proyecto = P.cd_proyecto
INNER JOIN cargos_a_actualizar  ON D.nu_documento = cargos_a_actualizar.dni
SET E.facultad_oid = cargos_a_actualizar.cd_facultad,E.cargo_oid = cargos_a_actualizar.cd_cargo, E.deddoc_oid = cargos_a_actualizar.cd_deddoc, E.motivo = CONCAT('Cargo y ded actualizados el ',now())
WHERE P.dt_fin > '2019-12-31' AND E.fechaHasta IS NULL AND E.motivo IS NULL;

####Dedicaciones distintas 
SELECT CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador, CONCAT(D.nu_precuil,'-',D.nu_documento,'-',D.nu_postcuil) as CUIL, cargo.ds_cargo as Cargo, DED.ds_deddoc as Ded_Doc, C.*  
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto 
LEFT JOIN docente D ON I.cd_docente = D.cd_docente
LEFT JOIN cargo ON cargo.cd_cargo = D.cd_cargo
LEFT JOIN deddoc DED ON DED.cd_deddoc = D.cd_deddoc
INNER JOIN cargos_alfabetico C ON D.nu_documento = C.dni
JOIN
(SELECT C1.dni, C1.cd_deddoc, MIN( C1.`cd_cargo`) AS maxcargo  FROM cargos_alfabetico C1
JOIN
(SELECT C2.`dni`, MIN( C2.`cd_deddoc`) AS maxded
FROM cargos_alfabetico C2
WHERE C2.`cd_deddoc` IN ( 1, 2, 3 ) AND C2.escalafon = 'Docente'
GROUP BY C2.`dni`) AS dmax
ON C1.`dni` = dmax.`dni` AND C1.cd_deddoc = dmax.maxded
WHERE C1.`cd_cargo` IN ( 1, 2, 3,4,5,7,8,9,10,11,12,13 ) AND C1.escalafon = 'Docente'
GROUP BY C1.`dni`, C1.cd_deddoc) AS cmax
ON C.`dni` = cmax.`dni` AND C.cd_cargo = cmax.maxcargo AND C.cd_deddoc = cmax.cd_deddoc
WHERE P.dt_fin > '2019-12-31' AND C.escalafon = 'Docente' AND ((D.cd_cargo IN (1,7) AND C.cd_cargo = 1) OR (D.cd_cargo IN (2,8) 
AND C.cd_cargo = 2) OR (D.cd_cargo IN (3,9) AND C.cd_cargo = 3) OR (D.cd_cargo IN (4,10) AND C.cd_cargo = 4) OR (D.cd_cargo IN (5,11) 
AND C.cd_cargo = 5)) AND ((D.cd_deddoc = 1 AND C.cd_deddoc != 1) OR (D.cd_deddoc = 2 AND C.cd_deddoc != 2) 
OR (D.cd_deddoc = 3 AND C.cd_deddoc != 3) OR D.cd_deddoc = 4 OR D.cd_deddoc IS NULL) 

#################Se crea una tabla auxiliar ############################

CREATE TABLE IF NOT EXISTS `dedicaciones_a_actualizar` (
  `dni` varchar(255) DEFAULT NULL,
  `investigador` varchar(254) DEFAULT NULL,
  `cd_facultad` varchar(254) DEFAULT NULL,
  `clase` varchar(254) DEFAULT NULL,
  `dt_fecha` date DEFAULT NULL,
  `nacimiento` date DEFAULT NULL,
  `cd_cargo` varchar(254) DEFAULT NULL,
  `cd_deddoc` varchar(254) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

UPDATE 
docente  INNER JOIN dedicaciones_a_actualizar  ON docente.nu_documento = dedicaciones_a_actualizar.dni
SET docente.cd_facultad = dedicaciones_a_actualizar.cd_facultad, docente.dt_nacimiento = dedicaciones_a_actualizar.nacimiento, 
docente.cd_deddoc = dedicaciones_a_actualizar.cd_deddoc;

UPDATE integrante I 
INNER JOIN proyecto AS P ON I.cd_proyecto = P.cd_proyecto
INNER JOIN docente AS D ON I.cd_docente = D.cd_docente
INNER JOIN dedicaciones_a_actualizar  ON D.nu_documento = dedicaciones_a_actualizar.dni
SET I.cd_facultad = dedicaciones_a_actualizar.cd_facultad,I.cd_deddoc = dedicaciones_a_actualizar.cd_deddoc
WHERE P.dt_fin > '2019-12-31';

UPDATE cyt_integrante_estado E 
INNER JOIN integrante I ON E.integrante_oid = I.oid  
INNER JOIN docente AS D ON I.cd_docente = D.cd_docente
INNER JOIN proyecto AS P ON I.cd_proyecto = P.cd_proyecto
INNER JOIN dedicaciones_a_actualizar  ON D.nu_documento = dedicaciones_a_actualizar.dni
SET E.facultad_oid = dedicaciones_a_actualizar.cd_facultad,E.deddoc_oid = dedicaciones_a_actualizar.cd_deddoc, E.motivo = CONCAT(motivo, '.\r\nDedicación actualizada el ',now())
WHERE P.dt_fin > '2019-12-31' AND E.fechaHasta IS NULL AND E.motivo IS NOT NULL;

UPDATE cyt_integrante_estado E 
INNER JOIN integrante I ON E.integrante_oid = I.oid  
INNER JOIN docente AS D ON I.cd_docente = D.cd_docente
INNER JOIN proyecto AS P ON I.cd_proyecto = P.cd_proyecto
INNER JOIN dedicaciones_a_actualizar  ON D.nu_documento = dedicaciones_a_actualizar.dni
SET E.facultad_oid = dedicaciones_a_actualizar.cd_facultad,E.deddoc_oid = dedicaciones_a_actualizar.cd_deddoc, E.motivo = CONCAT('Dedicación actualizada el ',now())
WHERE P.dt_fin > '2019-12-31' AND E.fechaHasta IS NULL AND E.motivo IS NULL;


############################################ Actualizar carrera investigador desde SIGEVA ########################################## 
UPDATE `carreainv_sigeva` SET `cd_carrerainv` = 3 WHERE cd_carrerainv = 'Investigador independiente';
UPDATE `carreainv_sigeva` SET `cd_carrerainv` = 2 WHERE cd_carrerainv = 'Investigador principal';
UPDATE `carreainv_sigeva` SET `cd_carrerainv` = 12 WHERE cd_carrerainv = 'Investigador adjunto';
UPDATE `carreainv_sigeva` SET `cd_carrerainv` = 6 WHERE cd_carrerainv = 'Investigador asistente';
UPDATE `carreainv_sigeva` SET `cd_carrerainv` = 1 WHERE cd_carrerainv = 'Investigador superior';

UPDATE `carreainv_sigeva` SET `cd_organismo` = 1 WHERE cd_organismo = 'Carrera de investigador científico y tecnológico (CIC pcia. Bs. As.)';
UPDATE `carreainv_sigeva` SET `cd_organismo` = 2 WHERE cd_organismo = 'Carrera de investigador científico y tecnológico (CONICET)';

SELECT D.ds_nombre, D.ds_apellido, D.cd_carrerainv, C.cd_carrerainv, D.cd_organismo, C.cd_organismo
FROM docente D INNER JOIN carreainv_sigeva C ON D.nu_documento = C.dni
WHERE C.cd_carrerainv IN (1,2,3,4,5,6,10,12)


UPDATE docente AS D
JOIN
(SELECT C.* FROM carreainv_sigeva C
JOIN
(SELECT C1.dni, MIN( C1.`cd_carrerainv`) AS maxcargo  FROM carreainv_sigeva C1
WHERE C1.`cd_carrerainv` IN (1,2,3,4,5,6,10,12)
GROUP BY C1.`dni`) AS cmax
ON C.`dni` = cmax.`dni` AND C.cd_carrerainv = cmax.maxcargo) AS cargos_sigeva
ON D.nu_documento = cargos_sigeva.dni 
SET D.cd_carrerainv = cargos_sigeva.cd_carrerainv, D.cd_organismo = cargos_sigeva.cd_organismo;

UPDATE integrante I INNER JOIN docente AS D ON I.cd_docente = D.cd_docente
INNER JOIN proyecto AS P ON I.cd_proyecto = P.cd_proyecto
JOIN
(SELECT C.* FROM carreainv_sigeva C
JOIN
(SELECT C1.codigo, C1.dni, MIN( C1.`cd_carrerainv`) AS maxcargo  FROM carreainv_sigeva C1
WHERE C1.`cd_carrerainv` IN (1,2,3,4,5,6,10,12)
GROUP BY C1.codigo, C1.`dni`) AS cmax
ON C.`dni` = cmax.`dni` AND C.cd_carrerainv = cmax.maxcargo) AS cargos_sigeva
ON D.nu_documento = cargos_sigeva.dni AND P.ds_codigo = cargos_sigeva.codigo
SET I.cd_carrerainv = cargos_sigeva.cd_carrerainv, I.cd_organismo = cargos_sigeva.cd_organismo, I.dt_carrerainv = cargos_sigeva.fecha_inicio;

############################################ Actualizar carrera investigador desde EXCEL cruzado con alfabetico (lo envió Adriana) ########################################## 
SELECT CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador, CONCAT(D.nu_precuil,'-',D.nu_documento,'-',D.nu_postcuil) as CUIL, CONCAT(carrerainv.ds_carrerainv,' - ', organismo.ds_codigo) AS Carrera_WEB, CONCAT(c1.ds_carrerainv, ' - ',o1.ds_codigo) AS Carrera_excel,C.cd_carrerainv, C.cd_organismo  
FROM docente D 
LEFT JOIN carrerainv ON carrerainv.cd_carrerainv = D.cd_carrerainv
LEFT JOIN organismo ON organismo.cd_organismo = D.cd_organismo
INNER JOIN carrera_alfabetico C ON D.nu_documento = C.dni
LEFT JOIN facultad F ON D.cd_facultad = F.cd_facultad
LEFT JOIN carrerainv c1 ON c1.cd_carrerainv = C.cd_carrerainv
LEFT JOIN organismo o1 ON o1.cd_organismo = C.cd_organismo
WHERE (D.cd_carrerainv is null or D.cd_organismo is null or D.cd_carrerainv != C.cd_carrerainv OR D.cd_organismo != C.cd_organismo) AND C.cd_carrerainv IN (1,2,3,4,5,6,8,9,10,12,13)

UPDATE 
docente  INNER JOIN carrera_a_actualizar  ON docente.nu_documento = carrera_a_actualizar.dni
SET docente.cd_carrerainv = carrera_a_actualizar.cd_carrerainv, 
docente.cd_organismo = carrera_a_actualizar.cd_organismo;

UPDATE integrante I 
INNER JOIN proyecto AS P ON I.cd_proyecto = P.cd_proyecto
INNER JOIN docente AS D ON I.cd_docente = D.cd_docente
INNER JOIN carrera_a_actualizar  ON D.nu_documento = carrera_a_actualizar.dni
SET I.cd_carrerainv = carrera_a_actualizar.cd_carrerainv,I.cd_organismo = carrera_a_actualizar.cd_organismo
WHERE P.dt_fin > '2019-12-31';

UPDATE cyt_integrante_estado E 
INNER JOIN integrante I ON E.integrante_oid = I.oid  
INNER JOIN docente AS D ON I.cd_docente = D.cd_docente
INNER JOIN proyecto AS P ON I.cd_proyecto = P.cd_proyecto
INNER JOIN carrera_a_actualizar  ON D.nu_documento = carrera_a_actualizar.dni
SET E.carrerainv_oid = carrera_a_actualizar.cd_carrerainv,E.organismo_oid = carrera_a_actualizar.cd_organismo, E.motivo = CONCAT(motivo, '.\r\nCarrera actualizada el ',now())
WHERE P.dt_fin > '2019-12-31' AND E.fechaHasta IS NULL AND E.motivo IS NOT NULL;

UPDATE cyt_integrante_estado E 
INNER JOIN integrante I ON E.integrante_oid = I.oid  
INNER JOIN docente AS D ON I.cd_docente = D.cd_docente
INNER JOIN proyecto AS P ON I.cd_proyecto = P.cd_proyecto
INNER JOIN carrera_a_actualizar  ON D.nu_documento = carrera_a_actualizar.dni
SET E.carrerainv_oid = carrera_a_actualizar.cd_carrerainv,E.organismo_oid = carrera_a_actualizar.cd_organismo, E.motivo = CONCAT('Carrera actualizada el ',now())
WHERE P.dt_fin > '2019-12-31' AND E.fechaHasta IS NULL AND E.motivo IS NULL;





####################Listado de Proyectos Cargados############################
SELECT P.ds_codigo as Proyecto, TA.ds_tipoacreditacion as Tipo, ds_titulo as Titulo, 
CONCAT(SUBSTRING(dt_ini,9,2),'/',SUBSTRING(dt_ini,6,2),'/',SUBSTRING(dt_ini,1,4)) as Inicio,
CONCAT(SUBSTRING(dt_fin,9,2),'/',SUBSTRING(dt_fin,6,2),'/',SUBSTRING(dt_fin,1,4)) as Fin, CONCAT(unidad.ds_unidad,'-',unidad.ds_sigla) AS Unidad, E.ds_estado as Estado, 
CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador, CONCAT(D.nu_precuil,'-',D.nu_documento,'-',D.nu_postcuil) as CUIL, 
D.ds_mail As Mail, TI.ds_tipoinvestigador as Tipo, 
CONCAT(SUBSTRING(dt_alta,9,2),'/',SUBSTRING(dt_alta,6,2),'/',SUBSTRING(dt_alta,1,4)) as Alta, 
CONCAT(SUBSTRING(dt_baja,9,2),'/',SUBSTRING(dt_baja,6,2),'/',SUBSTRING(dt_baja,1,4)) as Baja, 
F.ds_facultad As Facultad, C.ds_cargo as Cargo, DED.ds_deddoc as Ded_Doc, CAT.ds_categoria as Categoria, D.nu_dedinv as Ded_Inv, 
CASE  WHEN beca.cd_beca IS NULL THEN (CASE D.bl_becario WHEN '1' THEN 
CONCAT(D.ds_tipobeca, '-', D.ds_orgbeca,' (',SUBSTRING(D.dt_beca,9,2),'/',SUBSTRING(D.dt_beca,6,2),'/',SUBSTRING(D.dt_beca,1,4),' - ',SUBSTRING(D.dt_becaHasta,9,2),'/',SUBSTRING(D.dt_becaHasta,6,2),'/',SUBSTRING(D.dt_becaHasta,1,4),')') ELSE (CASE D.bl_becaEstimulo WHEN '1' THEN 
CONCAT('EVC',' (',SUBSTRING(D.dt_becaEstimulo,9,2),'/',SUBSTRING(D.dt_becaEstimulo,6,2),'/',SUBSTRING(D.dt_becaEstimulo,1,4),' - ',SUBSTRING(D.dt_becaEstimuloHasta,9,2),'/',SUBSTRING(D.dt_becaEstimuloHasta,6,2),'/',SUBSTRING(D.dt_becaEstimuloHasta,1,4),')') ELSE '' END) END) ELSE 
CONCAT(beca.ds_tipobeca, '-UNLP',' (',SUBSTRING(beca.dt_desde,9,2),'/',SUBSTRING(beca.dt_desde,6,2),'/',SUBSTRING(beca.dt_desde,1,4),' - ',SUBSTRING(beca.dt_hasta,9,2),'/',SUBSTRING(beca.dt_hasta,6,2),'/',SUBSTRING(beca.dt_hasta,1,4),')') END as becario, 
CONCAT(CASE CI.cd_carrerainv WHEN '11' THEN '' ELSE CI.ds_carrerainv END,'-',CASE O.cd_organismo WHEN '7' THEN '' ELSE O.ds_codigo END) As Carr_Inv, 
 U.ds_universidad, 
FI.ds_facultad as Facultad_Int, TI.cd_tipoinvestigador, I.nu_horasinv 
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto 
LEFT JOIN tipoacreditacion TA ON P.cd_tipoacreditacion = TA.cd_tipoacreditacion
LEFT JOIN docente D ON I.cd_docente = D.cd_docente
LEFT JOIN estadoproyecto E ON E.cd_estado = P.cd_estado 
LEFT JOIN tipoinvestigador TI ON TI.cd_tipoinvestigador = I.cd_tipoinvestigador 
LEFT JOIN facultad F ON F.cd_facultad = P.cd_facultad
LEFT JOIN cargo C ON C.cd_cargo = D.cd_cargo
LEFT JOIN deddoc DED ON DED.cd_deddoc = D.cd_deddoc
LEFT JOIN categoria CAT ON CAT.cd_categoria = D.cd_categoria
LEFT JOIN carrerainv CI ON CI.cd_carrerainv = D.cd_carrerainv
LEFT JOIN organismo O ON O.cd_organismo = D.cd_organismo
LEFT JOIN universidad U ON U.cd_universidad = D.cd_universidad
LEFT JOIN facultad FI ON FI.cd_facultad = D.cd_facultad
LEFT JOIN beca ON D.cd_docente = beca.cd_docente AND beca.dt_hasta >= '2020-01-01' 
LEFT JOIN unidad ON P.cd_unidad = unidad.cd_unidad 
WHERE dt_ini = '2021-01-01'
ORDER BY P.ds_codigo

######################################### Listado de proyectos para codificar ###########################################
SELECT P.cd_proyecto,P.ds_codigo as Proyecto, ds_titulo as Titulo,CONCAT(D.ds_apellido,', ',D.ds_nombre) as Director, CONCAT(SUBSTRING(dt_ini,9,2),'/',SUBSTRING(dt_ini,6,2),'/',SUBSTRING(dt_ini,1,4)) as Inicio,CONCAT(SUBSTRING(dt_fin,9,2),'/',SUBSTRING(dt_fin,6,2),'/',SUBSTRING(dt_fin,1,4)) as Fin, EP.ds_estado as Estado, F.ds_facultad as Facultad
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto 
LEFT JOIN docente D ON I.cd_docente = D.cd_docente 
LEFT JOIN estadoproyecto EP ON P.cd_estado = EP.cd_estado
LEFT JOIN facultad F ON P.cd_facultad = F.cd_facultad
WHERE P.cd_tipoacreditacion = 1 AND dt_ini = '2020-01-01' AND I.cd_tipoinvestigador = 1
ORDER BY F.ds_facultad, P.ds_codigo

PPID
SELECT P.cd_proyecto,P.ds_codigo as Proyecto, ds_titulo as Titulo,CONCAT(D.ds_apellido,', ',D.ds_nombre) as Director, CONCAT(SUBSTRING(dt_ini,9,2),'/',SUBSTRING(dt_ini,6,2),'/',SUBSTRING(dt_ini,1,4)) as Inicio,CONCAT(SUBSTRING(dt_fin,9,2),'/',SUBSTRING(dt_fin,6,2),'/',SUBSTRING(dt_fin,1,4)) as Fin, EP.ds_estado as Estado, F.ds_facultad as Facultad
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto 
LEFT JOIN docente D ON I.cd_docente = D.cd_docente 
LEFT JOIN estadoproyecto EP ON P.cd_estado = EP.cd_estado
LEFT JOIN facultad F ON P.cd_facultad = F.cd_facultad
WHERE P.cd_tipoacreditacion = 2 AND dt_ini = '2020-01-01' AND I.cd_tipoinvestigador = 1
ORDER BY F.ds_facultad, P.ds_codigo

######################################### Actualizar codigos de proyectos ###########################################
UPDATE 
proyecto  INNER JOIN codigos_proyectos  ON proyecto.ds_codigoSIGEVA = codigos_proyectos.sigeva
SET proyecto.ds_codigo = codigos_proyectos.codigo, proyecto.cd_estado = 5

######################################## Exportar datos al SIPIWEB ######################################################

######################################## Exportar docentes ######################################################
SELECT D.nu_ident, D.ds_nombre, D.ds_apellido, D.nu_postcuil, D.nu_precuil, D.nu_documento, CONCAT(D.nu_precuil,'-',D.nu_documento,'-',D.nu_postcuil),D.dt_nacimiento,D.cd_universidad,2016,D.ds_sexo
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto 
LEFT JOIN docente D ON I.cd_docente = D.cd_docente
WHERE P.cd_estado = 5 AND dt_ini = '2016-01-01' AND I.cd_tipoinvestigador <> 6 AND P.cd_tipoacreditacion=1 AND D.nu_ident NOT LIKE '11%' AND NOT EXISTS (SELECT DS.identificador FROM `docentes_sipiweb` DS WHERE DS.documento=D.nu_documento)

######################################## Exportar Proyectos ######################################################
SELECT P.ds_codigo, '', P.ds_titulo, P.dt_ini, P.dt_fin, P.dt_ini, P.ds_linea, '', C.ds_codigo, CASE WHEN P.cd_especialidad IS NULL THEN DI.ds_codigo ELSE E.ds_codigo END, 'UNIV', P.ds_tipo, F.nu_codigo, '', U.ds_codigo, 11, 2016 	
FROM proyecto P 
LEFT JOIN campo C ON P.cd_campo = C.cd_campo
LEFT JOIN disciplina DI ON P.cd_disciplina = DI.cd_disciplina
LEFT JOIN especialidad E ON P.cd_especialidad = E.cd_especialidad
LEFT JOIN facultad F ON F.cd_facultad = P.cd_facultad
LEFT JOIN unidad U ON U.cd_unidad = P.cd_unidad
WHERE P.cd_estado = 5 AND dt_ini = '2016-01-01' AND P.cd_tipoacreditacion=1 

######################################## Exportar Integrantes ######################################################
SELECT I.dt_alta, CASE WHEN (I.cd_estado = 4 OR I.cd_estado = 5 OR I.dt_baja='0000-00-00') THEN NULL ELSE I.dt_baja END, CASE WHEN I.cd_tipoinvestigador = 1 THEN 1 ELSE 0 END, 11, 2016, CONCAT(D.nu_precuil,'-',D.nu_documento,'-',D.nu_postcuil),P.ds_codigo
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto 
LEFT JOIN docente D ON I.cd_docente = D.cd_docente
WHERE P.cd_estado = 5 AND dt_ini = '2016-01-01' AND I.cd_tipoinvestigador <> 6 AND P.cd_tipoacreditacion=1 AND (I.cd_estado = 3 OR I.cd_estado = 8 OR I.cd_estado = 9 OR I.cd_estado = 4 OR I.cd_estado = 5)