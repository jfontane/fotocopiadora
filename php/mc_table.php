<?php
require('fpdf.php');

class PDF_MC_Table extends FPDF
{
var $widths;
var $aligns;

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

function Row($data)
{
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
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
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

//Cabecera de pagina

function Header($valor=0)
                                {

                                    $this->SetLeftMargin(15);
                                    //$this->Image('../images/logo.jpg',15,4,139,13);
                                    $this->Ln(15);
                                    //Arial bold 15
                                    $this->SetFont('Times','B',16);
                                    //Movernos a la derecha
                                   //   $this->Cell(80);
                                    //T�tulo

                                    $this->SetFillColor(255,255,255);
                                    $this->Cell(85,10,'FOTOCOPIAS "EL ORIGINAL"',0,0,'L',true);

                                    $this->SetFont('Times','B',12);
                                    $this->Cell(58,10,'ORDEN DE COMPRA',0,0,'R',true);

                                    $this->SetFont('Times','B',12);
                                    $this->Cell(40,10,'No. 0001-000000'.$valor,0,1,'L',true);

                                    $this->SetFont('Times','',10);
                                    $this->Cell(58,5,'Direccion: Espora 2278',0,1,'L',true);
                                    $this->SetFont('Times','',10);
                                    $this->Cell(58,5,'Codigo Postal: 3000',0,1,'L',true);
                                    $this->SetFont('Times','',10);
                                    $this->Cell(58,5,'Localidad: Santa Fe (Capital)',0,1,'L',true);
                                    $this->Cell(58,5,'',0,1,'L',true);
                                    //$this->Cell(85,10,'',1,0,'L',true);


                                }



//Pie de p�gina
function FooterMio()
                                {
                                    //Posici�n: a 1,5 cm del final
                                    $this->SetY(-32);
                                    $this->SetX(25);
                                    //Arial italic 8

                                    //Numero de pagina
                                    $fechaHora=date("d-m-Y");
                                    $fecha=date("d-m-Y");
                                    $cod='usuario'.$fecha;
                                    $str=base64_encode($cod);

                                    $this->SetFont('Arial','I',10);
                                    $transaccion=utf8_decode('Transacción');
                                    $this->Cell(40,10,'Fecha de '.$transaccion.': ',0,0,'C');
                                    $this->SetFont('courier','B',10);
                                    $this->Cell(80,10,$fechaHora,0,0,'L');

                                    $this->SetX(90);
                                    //$this->Cell(40,10,$transaccion.': ',0,0,'C');
                                    $this->SetFont('courier','B',14);
                                    $this->Cell(180,10,$str,0,0,'L');

                                 }




}
?>
