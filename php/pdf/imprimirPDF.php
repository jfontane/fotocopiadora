<?php
session_start();
require('fpdf.php');
//class PDF***********************************************************************
class PDF extends FPDF {
var $B;
var $I;
var $U;
var $HREF;
var $ver;
var $query;
var $titulo;
var $dptoAnt;
var $rubroAnt;
var $SubrubroAnt;
var $cantidadPag;
var $nombreUbicacionAnt;
var $nombreResponsableAnt;
var $cantidadReg;
//funciones PDF***********************************************************************
function Header(){
	$x = $this->getX();
	$y = $this->getY();
	$this->SetFont('Arial','B',10);
	$this->Cell(280,10,'LISTADO DE BIENES DE USO',0,0,'C');
//	$this->Ln(2);
//   Cantidad de registros

	$this->SetXY(55,15);
	$this->SetFont('Arial','B',10);
	$this->Cell(45,10,'Cantidad de Registros:',0,0,'C');
	$this->SetXY(100,15);
	$this->SetFont('Arial','',10);
	$this->Cell(10,10,$this->cantidadReg);

	$this->SetXY(180,15);
	$this->SetFont('Arial','B',10);
	$this->Cell(45,10,'Filtro de Busqueda por:',0,0,'C');
	$this->SetXY(225,15);
	$this->SetFont('Arial','',10);
	$this->Cell(10,10,$this->titulo);

	$x = $this->getX();
	$y = $this->getY();

	if($this->titulo == 'Todos Los Departamentos'){
		$this->SetXY(5,30);
		$this->Cell(14,5,'Nro.Inv.',1,0,'C');
		$this->Cell(48,5,'RUBRO',1,0,'C');
		$this->Cell(50,5,'SUBRUBRO',1,0,'C');
		$this->Cell(50,5,'ITEM',1,0,'C');
		$this->Cell(45,5,'OFICINA',1,0,'C');
		$this->Cell(45,5,'RESPONSABLE',1,0,'C');
		$this->Cell(35,5,'UBICACION',1,0,'C');
		$this->SetXY(5,35);

		}
	else{
		$this->SetXY(27,30);
		$this->Cell(14,5,'Nro.Inv.',1,0,'C');
		$this->Cell(48,5,'RUBRO',1,0,'C');
		$this->Cell(50,5,'SUBRUBRO',1,0,'C');
		$this->Cell(50,5,'ITEM',1,0,'C');
		$this->Cell(45,5,'RESPONSABLE',1,0,'C');
		$this->Cell(35,5,'UBICACION',1,0,'C');
		$this->SetXY(27,35);
		}



////////se asignan a dos variables a rubro y Subrubro para mostrar al comienzo en las p�ginas siguientes.

	$this->rubroAnt = $row['nombreRubro'];
	$this->SubrubroAnt = $row['nombreSubrubro'];
	$this->nombreUbicacionAnt = $row['nombreUbicacion'];
 	$this->nombreResponsableAnt = $row['nombreResponsable'];
 	$this->dptoAnt = $row['nombreOficina'];
/////// Fin de asignar.|

//   imprime las lineas horizontales
//	$this->Line(5,30,280,30);
//	$this->Line(5,35,280,35);


}

function WriteHTML($html) {
    //Int�rprete de HTML
    $html=str_replace("\n",' ',$html);
    $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e) {
        if($i%2==0) {
            //Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        } else {
            //Etiqueta
            if($e{0}=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else {
                //Extraer atributos
                $a2=explode(' ',$e);
                $tag=strtoupper(array_shift($a2));
                $attr=array();
                foreach($a2 as $v)
                    if(ereg('^([^=]*)=["\']?([^"\']*)["\']?$',$v,$a3))
                        $attr[strtoupper($a3[1])]=$a3[2];
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag,$attr) {
    //Etiqueta de apertura
    if($tag=='B' or $tag=='I' or $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF=$attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}
function CloseTag($tag) {
    //Etiqueta de cierre
    if($tag=='B' or $tag=='I' or $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF='';
}
function SetStyle($tag,$enable) {
    //Modificar estilo y escoger la fuente correspondiente
    $this->$tag+=($enable ? 1 : -1);
    $style='';
    foreach(array('B','I','U') as $s)
        if($this->$s>0)
            $style.=$s;
    $this->SetFont('',$style);
}
function PutLink($URL,$txt) {
    //Escribir un hiper-enlace
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}
function Footer() {
	$fecha=date("d/m/Y");
	$hora= date("H:i:s");
	$this->SetXY(4,203);
	$this->WriteHTML(' Fecha de Impresion: ' . $fecha . ' ' . $hora . '');
//	$this->Cell(0,5,'P�gina '.$this->PageNo().'/'.$this->cantidadPag,0,0,'R',0,0,'R');
	$this->SetX(268);
	$this->Cell(0,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
	}
function PDF($orientation='P',$unit='mm',$format='A4') {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    //Iniciaci�n de variables
    //$this->B=0;
    $this->I=0;
    $this->U=0;
    $this->HREF='';
}

function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function fill($f)
{
	//juego de arreglos de relleno
	$this->fill=$f;
}
/*
* function getAlto
* descripcion: obtiene al alto de una celda multicell
* @return integer: el alto de la celda
*/
function getAlto($row){
    $nb=0;
    $iterando = 0;

	    for($i=0;$i<count($row);$i++) {
	        $nb=max($nb,$this->NbLines($this->widths[$i],$row[$i]));
	        $iterando++;
		}
	$h=$iterando*$nb;
    return $h;
}

function Row($data){
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h,$style);
        //Print the text
        $this->MultiCell($w,5,$data[$i],'LTR',$a,$fill);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}



function verImpresion($query){

	    $pagina = $this->PageNo();
	    $bandera =1;

			if ($query->rowCount() == 0){
				$_SESSION[VAL_ARRAY]['err_descripcion']='No existe Informaci�n';
				return false;
				}
			else{
				$_SESSION[VAL_ARRAY]['cantidadRegistros']=$query->rowCount();
				}

			while ($row = $query->fetch()) {

////////////////////// se imprime cada campo con recuadro y orintado a la Izquierda.


				if($this->titulo == 'Todos Los Departamentos'){

					$this->SetX(5);

					$this->SetWidths(array(14,48,50,50,45,45,35));
					$this->SetFont('Arial','',10);

					if($this->rubroAnt == $row['nombreRubro']){
						$alineaRubro='C';
						$nombre_rubro='"';
						}
					else {
						$alineaRubro='L';
						$nombre_rubro=$row['nombreRubro'];
						}

					if($this->SubrubroAnt == $row['nombreSubrubro']){
							$alineaSubrubro='C';
							$nombre_Subrubro='"';
						}
					else {
						$alineaSubrubro='L';
						$nombre_Subrubro=$row['nombreSubrubro'];
						}

					if($this->nombreOficinaAnt == $row['nombreOficina']){
						$alineaOficina='C';
						$nombre_oficina='"';
						}
					else{
						$alineaOficina='L';
						$nombre_oficina = $row['nombreOficina'];
						}

					if($this->nombreResponsableAnt == $row['nombreResponsable']){
						$alineaNombreResponsable='C';
						$nombre_responsable='"';
						}
					else{
						$alineaNombreResponsable='L';
						$nombre_responsable = $row['nombreResponsable'];
						}

					if($this->nombreUbicacionAnt == $row['nombreUbicacion']){
						$alineaNombreUbicacion='C';
						$nombre_ubicacion='"';
						}
					else{
						$alineaNombreUbicacion='L';
						$nombre_ubicacion = $row['nombreUbicacion'];
						}

					$h= $this->getAlto($row);

					  //si me estoy pasando de pagina
					 if($this->GetY()+$h>$this->PageBreakTrigger){

						 $this->AddPage($this->CurOrientation);

						$this->SetAligns(array('L','L','L','L','L','L','L'));
						$this->Row(array($row["numero"],$row['nombreRubro'],$row['nombreSubrubro'],$row['nombreItem'],$row['nombreOficina'],$row['nombreResponsable'],$row['nombreUbicacion'] ));
					}

					else{

						$this->SetAligns(array('L',$alineaRubro,$alineaSubrubro,'L',$alineaOficina,$alineaNombreResponsable,$alineaNombreUbicacion));

						$this->Row(array($row["numero"]." ".$row["codigoAnterior"],$nombre_rubro,$nombre_Subrubro,$row['nombreItem'],$nombre_oficina,$nombre_responsable,$nombre_ubicacion));

						}

					$this->rubroAnt = $row['nombreRubro'];
					$this->SubrubroAnt = $row['nombreSubrubro'];
					$this->nombreOficinaAnt = $row['nombreOficina'];
					$this->nombreResponsableAnt = $row['nombreResponsable'];
					$this->nombreUbicacionAnt = $row['nombreUbicacion'];


					}

				else{

					$this->SetX(27);

					$this->SetWidths(array(14,48,50,50,45,35));
					$this->SetFont('Arial','',10);

					if($this->rubroAnt == $row['nombreRubro']){
						$alineaRubro='C';
						$nombre_rubro='"';
						}
					else {
						$alineaRubro='L';
						$nombre_rubro=$row['nombreRubro'];
						}

					if($this->SubrubroAnt == $row['nombreSubrubro']){
							$alineaSubrubro='C';
							$nombre_Subrubro='"';
						}
					else {
						$alineaSubrubro='L';
						$nombre_Subrubro=$row['nombreSubrubro'];
						}


					if($this->nombreResponsableAnt == $row['nombreResponsable']){
						$alineaNombreResponsable='C';
						$nombre_responsable='"';
						}
					else{
						$alineaNombreResponsable='L';
						$nombre_responsable = $row['nombreResponsable'];
						}

					if($this->nombreUbicacionAnt == $row['nombreUbicacion']){
						$alineaNombreUbicacion='C';
						$nombre_ubicacion='"';
						}
					else{
						$alineaNombreUbicacion='L';
						$nombre_ubicacion = $row['nombreUbicacion'];
						}

					$h= $this->getAlto($row);

					  //si me estoy pasando de pagina
					 if($this->GetY()+$h>$this->PageBreakTrigger){

						 $this->AddPage($this->CurOrientation);

						$this->SetAligns(array('L','L','L','L','L','L'));
						$this->Row(array($row["numero"],$row['nombreRubro'],$row['nombreSubrubro'],$row['nombreItem'],$row['nombreResponsable'],$row['nombreUbicacion'] ));
					}

					else{

						$this->SetAligns(array('L',$alineaRubro,$alineaSubrubro,'L',$alineaNombreResponsable,$alineaNombreUbicacion));

						$this->Row(array($row["numero"],$nombre_rubro,$nombre_Subrubro,$row['nombreItem'],$nombre_responsable,$nombre_ubicacion));

						}

					$this->rubroAnt = $row['nombreRubro'];
					$this->SubrubroAnt = $row['nombreSubrubro'];
				//	$this->nombreOficinaAnt = $row['nombreOficina'];
					$this->nombreResponsableAnt = $row['nombreResponsable'];
					$this->nombreUbicacionAnt = $row['nombreUbicacion'];
					}

				}

		}
// fin funciones PDF*****************************************************************
}
// fin class PDF*****************************************************************
include("../includes/php/funciones.php");
if (!isset($_POST['accion'])) {
	$_POST['accion'] = 'inicio';
	}

define("VAL_ARRAY", "valConsultaBienes");
define("CANTXPAGINA",30);
$smarty = new Smarty();

try  {
	//echo $_POST['accion'];
        switch ($_POST['accion']) {

		case "inicio":
			inicializar();
			mostrarPantConsulta($smarty);
			break;

		case "versubrugro":
			buscarSubrubro($smarty);
			mostrarPantConsulta($smarty);
			break;
		case "veritem":
			buscarItem($smarty);
			mostrarPantConsulta($smarty);
			break;

		case "pantalla":
			$_SESSION[VAL_ARRAY]['err_descripcion']='';
			$_SESSION[VAL_ARRAY]['habilitar'] = 'pantalla';
			if(controlDeBusqueda()==false){
				mostrarPantConsulta($smarty);
				}
			else {
				cargarArrayBusqueda();
				mostrarBienes($smarty);
				}
			break;

		case "imprimir":
                        //echo "entroooo  imprimir";
                        //die("entroooo  imprimir");
			if(controlDeBusqueda()==false){
				mostrarPantConsulta($smarty);
				}
			else{
				cargarArrayBusqueda();
				imprimir($query,$smarty);
				}
			break;

		case "principio":
			primeraPag();
			mostrarBienes($smarty);
			break;

		case "final":
			ultimaPag();
			mostrarBienes($smarty);
			break;

		case "anterior":
			$_SESSION[VAL_ARRAY]['habilitar'] = 'anterior';
			paginadoAnt($smarty);
			mostrarBienes($smarty);
			break;

		case "siguiente":
			$_SESSION[VAL_ARRAY]['habilitar'] = 'siguiente';
			paginadoSig($smarty);
			mostrarBienes($smarty);
			break;

		case "volver":
			inicializar();
			volverPantConsulta($smarty);
			break;

		case "archivo":
			if(controlDeBusqueda()==false){
				mostrarPantConsulta($smarty);
				}
			else{
				cargarArrayBusqueda();
				pasarArchivo($query,$smarty);
				}
			break;

		case "salir":
			inicializar();
			salirPantConsulta($smarty);
			break;

		default:
			errorGrave();
			break;
		}
	}
catch (Exception $e) {

	errorGrave($e);
	}
// funciones  ***********************************************
function inicializar() {
	$_SESSION[VAL_ARRAY] = array(
							'operacion'=>"",
                                                        'codigoAnterior'=>"",
							'numero'=>"",
							'idOficina'=>"",
							'nombreOficina'=>"",
							'idUbicacion'=>"",
							'idResponsable'=>"",
							'idRubro'=>"",
							'idSubrubro'=>"",
							'fechaAlta'=>"",
							'fechaBaja'=>"",
							'descripcion'=>"",
							'estado'=>"",
							'observacion'=>"",
							'operador'=>"",
							'habilitar'=>"",
							'fechaModif'=>"",
							'accion'=>"",
							'pagina'=>0,
							'cantidadRegistros'=>"",
							'totalCantidadRegistros'=>"",
							'tipoTitulo'=>"",
							'ultimosReg'=>"",
							'nroPag'=>"",
							'total_paginas'=>"",
							'err_descripcion'=>"");

	}

function mostrarPantConsulta($smarty) {

	cargarArrayBusqueda();
	$smarty->assign('idOficina', $_SESSION[VAL_ARRAY]['idOficina']);
	$smarty->assign('idUbicacion', $_SESSION[VAL_ARRAY]['idUbicacion']);
	$smarty->assign('idResponsable', $_SESSION[VAL_ARRAY]['idResponsable']);
	$smarty->assign('idRubro', $_SESSION[VAL_ARRAY]['idRubro']);
	$smarty->assign('idSubrubro', $_SESSION[VAL_ARRAY]['idSubrubro']);
	$smarty->assign('idItem', $_SESSION[VAL_ARRAY]['idItem']);
	$smarty->assign('err_descripcion', $_SESSION[VAL_ARRAY]['err_descripcion']);

	buscarListas($smarty);

	buscarSubrubro($smarty);
	buscarItem($smarty);

	//$smarty->display('consultaBienes.html');
	}

function volverPantConsulta($smarty) {

	buscarListas($smarty);
	$smarty->assign('err_descripcion', '');
	$smarty->display('consultaBienes.html');
	}


function buscarListas($smarty) {


	$oficinas = obtenerLista('idOficina','nombreOficina', "select * from oficina where idOficina <> 'X' order by nombreOficina ", array());
	$smarty->assign('oficinas', $oficinas);

	$ubicacion = obtenerLista('idUbicacion','nombreUbicacion', "select * from ubicacion where idUbicacion <> 'X' order by nombreUbicacion ", array());
	$smarty->assign('ubicacion', $ubicacion);

	$responsable = obtenerLista('idResponsable','nombreResponsable', "select * from responsable where idResponsable <> '0' order by nombreResponsable ", array());
	$smarty->assign('responsable', $responsable);


	$rubro = obtenerLista('idRubro','nombreRubro', "select * from rubro where idRubro <> 'X' order by nombreRubro ", array());

	$beginning = array(0=>'Todos los Rubros');
	$resultRubro = $beginning + $rubro;


	$smarty->assign('rubro', $resultRubro);

	$subrubro = obtenerLista('idSubrubro','nombreSubrubro', "select * from subrubro where subrubro.idRubro <> 'X' order by nombreSubrubro", array());

//	array_unshift($subrubro, "Todos los Subrubros");

	$beginning1 = array(0=>'Todos los Subrubros');
	$resultSubrubro = $beginning1 + $subrubro;

	$smarty->assign('subrubro', $resultSubrubro);

	$item = obtenerLista('idItem','nombreItem', "select * from item where item.idSubrubro <> 'X' order by nombreItem", array());

//	array_unshift($item, "Todos los Item");

	$beginning2 = array(0=>'Todos los Item');
	$resultItem = $beginning2 + $item;

	$smarty->assign('itemDep', $resultItem);

	}

function cargarArrayBusqueda() {
		$_SESSION[VAL_ARRAY]['idOficina']= $_POST['idOficina'];
		$_SESSION[VAL_ARRAY]['idUbicacion']= $_POST['idUbicacion'];
		$_SESSION[VAL_ARRAY]['idResponsable']= $_POST['idResponsable'];
		$_SESSION[VAL_ARRAY]['idRubro']= $_POST['idRubro'];
		$_SESSION[VAL_ARRAY]['idSubrubro']= $_POST['textSubrubro'];
		$_SESSION[VAL_ARRAY]['idItem']= $_POST['textItem'];
                $_SESSION[VAL_ARRAY]['numero']= $_POST['idBien'];
                //var_dump($_SESSION[VAL_ARRAY]);
	}

function primeraPag(){
		$_SESSION[VAL_ARRAY]['operacion'] = '';
		$_SESSION[VAL_ARRAY]['nroPag']= 1;
		$_SESSION[VAL_ARRAY]['habilitar'] = 'principio';
		$_SESSION[VAL_ARRAY]['pagina'] = 0;

	}

function nroPagina($smarty){

		if ($_SESSION[VAL_ARRAY]['pagina']== 0){
			$_SESSION[VAL_ARRAY]['nroPag']= 1;
		}
		if ($_SESSION[VAL_ARRAY]['operacion'] == 'sumar' and $_SESSION[VAL_ARRAY]['nroPag'] < $_SESSION[VAL_ARRAY]['total_paginas']){
			$_SESSION[VAL_ARRAY]['nroPag']=$_SESSION[VAL_ARRAY]['nroPag'] + 1;
		}

		if ($_SESSION[VAL_ARRAY]['operacion']=='restar' and $_SESSION[VAL_ARRAY]['nroPag'] > 1 ){
				$_SESSION[VAL_ARRAY]['nroPag'] = $_SESSION[VAL_ARRAY]['nroPag'] - 1;
		}

	$smarty->assign('nroPag', $_SESSION[VAL_ARRAY]['nroPag']);
	}

function ultimaPag(){

		$_SESSION[VAL_ARRAY]['operacion'] = '';
		$_SESSION[VAL_ARRAY]['nroPag'] = $_SESSION[VAL_ARRAY]['total_paginas'];
		$_SESSION[VAL_ARRAY]['habilitar'] = 'final';
		$_SESSION[VAL_ARRAY]['pagina'] = $_SESSION[VAL_ARRAY]['ultimosReg'];
		$_SESSION[VAL_ARRAY]['err_descripcion']='';

	}
function mostrarBienes($smarty) {

    $query = buscarPorSeleccion();

   	if(verPantalla($query,$smarty)== true){

			nroPagina($smarty);
			visualizar($smarty);

			$smarty->assign('toltalPaginas', $_SESSION[VAL_ARRAY]['total_paginas']);
			$smarty->assign('Bienes', $_SESSION[VAL_ARRAY]['ver']);

			$smarty->assign('nombreDep', $_SESSION[VAL_ARRAY]['tipoTitulo']);
			$smarty->assign('cantidadRegistros', $_SESSION[VAL_ARRAY]['totalCantidadRegistros']);
			$smarty->assign('err_descripcion', $_SESSION[VAL_ARRAY]['err_descripcion']);

			$smarty->display('mostrarBienes.html');
			}


	}

function visualizar($smarty) {

	if ($_SESSION[VAL_ARRAY]['habilitar']  == 'principio'){
		$smarty->assign('habilitarP', disabled);
		$_SESSION[VAL_ARRAY]['err_descripcion']= 'Principio de registros';
		}

	if ($_SESSION[VAL_ARRAY]['habilitar']  == 'pantalla')	{
		$smarty->assign('habilitarP', disabled);
		}
	if ($_SESSION[VAL_ARRAY]['totalCantidadRegistros'] <=30) {
		$smarty->assign('habilitarS', disabled);
		}

	if ($_SESSION[VAL_ARRAY]['nroPag'] == $_SESSION[VAL_ARRAY]['total_paginas']) {
		$smarty->assign('habilitarS', disabled);
		$_SESSION[VAL_ARRAY]['err_descripcion']= 'No Existen mas registros';
		}

	if ($_SESSION[VAL_ARRAY]['habilitar']  == 'siguiente'){
		$smarty->assign('habilitarP', enabled);
		}

	if ($_SESSION[VAL_ARRAY]['habilitar']  == 'final'){
		$smarty->assign('habilitarS', disabled);
		$_SESSION[VAL_ARRAY]['err_descripcion']= 'No Existen mas registros';
		}

	if ($_SESSION[VAL_ARRAY]['habilitar']  == 'anterior'){
		$smarty->assign('habilitarS', enabled);
		}

	}

function buscarPorSeleccion($limites=true){

    $Ofi=' and bien.idOficina ='. $_POST['idOficina'];
    $Rub=' and bien.idRubro ='. $_POST['idRubro'];
    $Subr=' and bien.idSubrubro ='. $_POST['textSubrubro'];
    $Item=' and bien.idItem ='. $_POST['textItem'];
    $Bien=' and bien.numero ='. $_POST['idBien'];
    $fechaAlta=' and SUBSTRING(bien.fechaAlta,1,4) = '. $_POST['fechaAlta'];
    //echo '*'.$_POST['idOficina'].'*'.$_POST['idRubro'].'*'.$_POST['textSubrubro'].'*'.$_POST['textItem'].'*'.$_POST['idBien'].'*';


    if ($_POST['idOficina']=='X' && $_POST['idRubro']=='X' && ($_POST['textSubrubro']=='X' || $_POST['textSubrubro']=='') && ($_POST['textItem']=='X' || $_POST['textItem']=='') && $_POST['idBien']=='') {
        echo "<tr align=center>
                <th colspan=\"8\">No hay Valores para Consultar</th>
             </tr>";
    } else {
            if ($_POST['idOficina']=='X' || $_POST['idOficina']=='-1')  $Ofi='';
            if ($_POST['idRubro']=='X' || $_POST['idRubro']=='')  $Rub='';
            if ($_POST['textSubrubro']=='X' || $_POST['textSubrubro']=='') $Subr='';
            if ($_POST['textItem']=='X' || $_POST['textItem']=='')  $Item='';
            if ($_POST['idBien']=='')  $Bien='';
            if ($_POST['fechaAlta']=='')  $fechaAlta='';







            $sql = 'SELECT bien.numero, bien.idOficina as bienO, bien.idUbicacion as bienU, bien.idResponsable as bienR, bien.idRubro as bienRu, bien.idSubrubro as bienSubRu, bien.idItem as bienItem, bien.fechaAlta as fechaAlta, bien.estado as bienEstado,
                                                oficina.nombreOficina,
                                                rubro.nombreRubro,
                                                responsable.nombreResponsable,
                                                ubicacion.nombreUbicacion,
                                                subrubro.nombreSubrubro,
                                                item.nombreItem,bien.codigoAnterior
                                                FROM bien
                                                JOIN oficina
                                                ON oficina.idOficina = bien.idOficina
                                                JOIN rubro
                                                ON rubro.idRubro = bien.idRubro
                                                JOIN responsable
                                                ON responsable.idResponsable = bien.idResponsable
                                                JOIN ubicacion
                                                ON ubicacion.idUbicacion = bien.idUbicacion
                                                JOIN subrubro
                                                ON subrubro.idSubrubro = bien.idSubrubro
                                                LEFT JOIN item
                                                ON item.idItem = bien.idItem WHERE 1=1 '.$Ofi . $Rub. $Subr. $Item. $Bien. $fechaAlta.' ORDER BY bien.numero';




                              //  $_SESSION[VAL_ARRAY]['tipoTitulo']= 'Todos Los Departamentos';




				//echo $sql;
				$query = ejecutarQuery($sql, array());

/////////////////// Se realiza esta busqueda para saber el total de registros a mostrar.

				$sql2 = 'SELECT count(*)
                                        FROM bien
                                        JOIN oficina
                                        ON oficina.idOficina = bien.idOficina
                                        JOIN rubro
                                        ON rubro.idRubro = bien.idRubro
                                        JOIN responsable
                                        ON responsable.idResponsable = bien.idResponsable
                                        JOIN ubicacion
                                        ON ubicacion.idUbicacion = bien.idUbicacion
                                        JOIN subrubro
                                        ON subrubro.idSubrubro = bien.idSubrubro
                                        LEFT JOIN item
                                        ON item.idItem = bien.idItem WHERE 1=1 '.$Ofi . $Rub. $Subr. $Item. $Bien.' ';

					$query2 = ejecutarQuery($sql2, array());
					$row = $query2->fetch();

/////////////////// Se pasa a una variable de sesi�n el total de registros para mostrar.

					$_SESSION[VAL_ARRAY]['totalCantidadRegistros'] = $row['total'];

/////////////////// Dividimos la cantidad total de registros por la cantidad m�xima de mostrar por p�gina.

					$ultimosReg = ($_SESSION[VAL_ARRAY]['totalCantidadRegistros'] - 1)/ CANTXPAGINA;

///////////////////	Extraemos la parte entera y multiplicamos por la cantidad m�xima de mostrar por p�gina.
					$parteEntera = floor($ultimosReg);

///////////////////	Multiplicamos por la cantidad m�xima de mostrar por pagina a la parte entera y se pasa a una variable de sesi�n,
///////////////////	para mostrar los ultimos registros.

					$_SESSION[VAL_ARRAY]['ultimosReg'] = $parteEntera * CANTXPAGINA;
					//calculo el total de p�ginas
					$_SESSION[VAL_ARRAY]['total_paginas'] = floor($_SESSION[VAL_ARRAY]['totalCantidadRegistros'] / CANTXPAGINA);

					$paginas = fmod($_SESSION[VAL_ARRAY]['totalCantidadRegistros'], CANTXPAGINA);

					if ($paginas>0){
						$_SESSION[VAL_ARRAY]['total_paginas']=$_SESSION[VAL_ARRAY]['total_paginas']+1;
						}

				return ($query);


    }
}

function buscarSubrubro($smarty) {

	cargarArrayBusqueda();

	$_SESSION[VAL_ARRAY]['err_descripcion'] ='';

	if (!isset($_POST['idRubro']) or $_POST['idRubro'] == 'X' or $_POST['idRubro'] == '0'){

		$_SESSION[VAL_ARRAY]['idRubro'] = $_POST['idRubro'];

		$subrubro = obtenerLista('idSubrubro','nombreSubrubro', "select * from subrubro where subrubro.idRubro = '0' order by nombreSubrubro", array());

		$smarty->assign('Subrubro', $subrubro);
		}
	else{
		$_SESSION[VAL_ARRAY]['idRubro'] = $_POST['idRubro'];
		$subrubro = obtenerLista('idSubrubro','nombreSubrubro', "select * from subrubro where subrubro.idRubro = ? order by nombreSubrubro", array($_SESSION[VAL_ARRAY]['idRubro']));
		$smarty->assign('subrubro', $subrubro);

		}

	}

function buscarItem($smarty) {

	cargarArrayBusqueda();

	$_SESSION[VAL_ARRAY]['err_descripcion'] ='';

	if (!isset($_POST['textSubrubro']) or $_POST['textSubrubro'] == '0' or $_POST['textSubrubro'] == 'X'){

		$_SESSION[VAL_ARRAY]['idSubrubro'] = $_POST['idSubrubro'];

		$item = obtenerLista('idItem','nombreItem', "select * from item where item.idSubrubro <> '0' order by nombreItem", array());

		$smarty->assign('item', $item);
		}
	else{

		$_SESSION[VAL_ARRAY]['idSubrubro'] = $_POST['idSubrubro'];

		$item = obtenerLista('idItem','nombreItem', "select * from item where item.idSubrubro = ? order by nombreItem", array($_SESSION[VAL_ARRAY]['idSubrubro']));

		$smarty->assign('item', $item);
		}


	}

function pasarArchivo($query,$smarty){

	$query = buscarPorSeleccion();

	if (!$query->rowCount() or $query->rowCount() == 0){
		buscarListas($smarty);


		$_SESSION[VAL_ARRAY]['err_descripcion']='No existe Informaci�n';

		$smarty->assign('idOficina', $_SESSION[VAL_ARRAY]['idOficina']);
		$smarty->assign('idUbicacion', $_SESSION[VAL_ARRAY]['idUbicacion']);
		$smarty->assign('idResponsable', $_SESSION[VAL_ARRAY]['idResponsable']);
		$smarty->assign('idRubro', $_SESSION[VAL_ARRAY]['idRubro']);
		$smarty->assign('idSubrubro', $_SESSION[VAL_ARRAY]['idSubrubro']);
		$smarty->assign('idItem', $_SESSION[VAL_ARRAY]['idItem']);
		$smarty->assign('err_descripcion', $_SESSION[VAL_ARRAY]['err_descripcion']);

		$smarty->display('consultaBienes.html');
		return false;
		}

	else{

		$query = buscarPorSeleccion(false);

			header('Content-Type:text/csv');
			header('Content-Disposition: attachment; filename="bienes.csv"');

		$str = "Nombre de Departamento:  ". $_SESSION[VAL_ARRAY]['tipoTitulo'] . chr(13);

		$str .= "Nro.Inv.;Rubro;Subrubro;Item;Oficina;Responsable;Ubicacion" . chr(13);

		while($row = $query->fetch())
	    		{
		    	$str .=$row['numero'].';'.$row['nombreRubro'].';'.$row['nombreSubrubro'].';'.$row['nombreItem'].';'.$row['nombreOficina'].';'.$row['nombreResponsable'].';'.$row['nombreUbicacion'] .chr(13);
	 		}
		echo $str;
		}
	}

function verPantalla($query,$smarty){

		if (!$query->rowCount() or $query->rowCount() == 0){

		buscarListas($smarty);
		cargarArrayBusqueda();

		$_SESSION[VAL_ARRAY]['err_descripcion']='No existe Informaci�n';

		$smarty->assign('idOficina', $_SESSION[VAL_ARRAY]['idOficina']);
		$smarty->assign('idUbicacion', $_SESSION[VAL_ARRAY]['idUbicacion']);
		$smarty->assign('idResponsable', $_SESSION[VAL_ARRAY]['idResponsable']);
		$smarty->assign('idRubro', $_SESSION[VAL_ARRAY]['idRubro']);
		$smarty->assign('idSubrubro', $_SESSION[VAL_ARRAY]['idSubrubro']);
		$smarty->assign('idItem', $_SESSION[VAL_ARRAY]['idItem']);
		$smarty->assign('err_descripcion', $_SESSION[VAL_ARRAY]['err_descripcion']);
		$smarty->display('consultaBienes.html');
		return false;
		}

	else{

		$_SESSION[VAL_ARRAY]['cantidadRegistrosDep']=$query->rowCount();
		$_SESSION[VAL_ARRAY]['ver'] = array();

		while ($row = $query->fetch()) {

			$_SESSION[VAL_ARRAY]['ver'][$row['numero']]['idOficina'] = $row['nombreOficina'];
			$_SESSION[VAL_ARRAY]['ver'][$row['numero']]['idUbicacion'] = $row['nombreUbicacion'];
			$_SESSION[VAL_ARRAY]['ver'][$row['numero']]['idResponsable'] = $row['nombreResponsable'];
			$_SESSION[VAL_ARRAY]['ver'][$row['numero']]['idRubro'] = $row['nombreRubro'];
			$_SESSION[VAL_ARRAY]['ver'][$row['numero']]['idSubrubro'] = $row['nombreSubrubro'];
			$_SESSION[VAL_ARRAY]['ver'][$row['numero']]['idItem'] = $row['nombreItem'];
                        //esto agregue yo
                        $_SESSION[VAL_ARRAY]['ver'][$row['numero']]['codigoAnterior'] = $row['codigoAnterior'];
                        $_SESSION[VAL_ARRAY]['ver'][$row['numero']]['fechaAlta'] = $row['fechaAlta'];
                        $_SESSION[VAL_ARRAY]['ver'][$row['numero']]['bienEstado'] = $row['bienEstado'];


			}
		return true;
		}

	}

function paginadoAnt($smarty) {

		$_SESSION[VAL_ARRAY]['operacion'] = 'restar';

		$_SESSION[VAL_ARRAY]['err_descripcion']='';

		if ( $_SESSION[VAL_ARRAY]['pagina'] >= CANTXPAGINA ){

			$_SESSION[VAL_ARRAY]['pagina']= $_SESSION[VAL_ARRAY]['pagina'] - CANTXPAGINA ;

			}

		if ( $_SESSION[VAL_ARRAY]['pagina'] <= 0 ){

			$_SESSION[VAL_ARRAY]['pagina'] = 0;

			$smarty->assign('habilitarP', 'disabled');

			$_SESSION[VAL_ARRAY]['err_descripcion']='No hay registro anteriores';
			}

	}

function paginadoSig($smarty) {

		if($_SESSION[VAL_ARRAY]['nroPag'] < $_SESSION[VAL_ARRAY]['total_paginas']){
			$_SESSION[VAL_ARRAY]['operacion'] = 'sumar';
			$_SESSION[VAL_ARRAY]['err_descripcion']='';
			$smarty->assign('habilitarP', 'enabled');
			$_SESSION[VAL_ARRAY]['pagina']= $_SESSION[VAL_ARRAY]['pagina'] + CANTXPAGINA ;
		}
	}


function controlDeBusqueda() {

	if($_POST['idOficina']=='X' and $_POST['idUbicacion']== 'X' and $_POST['idResponsable']== 'X' and $_POST['idRubro']== 'X' and $_POST['idSubrubro']== 'X' and $_POST['idItem']== 'X' and $_POST['idBien']== ''){
		$_SESSION[VAL_ARRAY]['err_descripcion'] = 'Debe seleccionar correctamente el tipo de busqueda';
		return false;
		}
	else{
		return true;
		}
	}

function imprimir($query,$smarty){

	cargarArrayBusqueda();
	$query = buscarPorSeleccion();

	//buscarListas($smarty);

//	if (!$query->rowCount() or $query->rowCount() == 0){
//
//		$_SESSION[VAL_ARRAY]['err_descripcion']='No existe Informacion';
//
//		$smarty->assign('idOficina', $_SESSION[VAL_ARRAY]['idOficina']);
//		$smarty->assign('idUbicacion', $_SESSION[VAL_ARRAY]['idUbicacion']);
//		$smarty->assign('idResponsable', $_SESSION[VAL_ARRAY]['idResponsable']);
//		$smarty->assign('idRubro', $_SESSION[VAL_ARRAY]['idRubro']);
//		$smarty->assign('idSubrubro', $_SESSION[VAL_ARRAY]['idSubrubro']);
//		$smarty->assign('idItem', $_SESSION[VAL_ARRAY]['idItem']);
//		$smarty->assign('err_descripcion', $_SESSION[VAL_ARRAY]['err_descripcion']);
//
//		$smarty->display('consultaBienes.html');
//		return false;
//		}
//	else{
                //$query = ejecutarQuery("select idRubro, nombreRubro from rubro", array());

                $pdf=new PDF('L','mm','A4');
		$pdf->AliasNbPages();
		$pdf->setTopMargin(5);
		//$pdf->query = buscarPorSeleccion(false);
                $pdf->query = $query;
		$pdf->titulo = $_SESSION[VAL_ARRAY]['tipoTitulo'];
		$pdf->cantidadReg = $_SESSION[VAL_ARRAY]['totalCantidadRegistros'];
		$pdf->AddPage();
		$pdf->verImpresion($pdf->query);
		$pdf->Output();
//		}
	}

function salirPantConsulta($smarty) {
	$smarty->display('principal.html');
	}
?>
