<?php
require('fpdf.php');

class PDF_MC_Table extends FPDF
{
	var $widths;
	var $aligns;
	var $HREF;

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



	function WriteHTML($html) {
	    //Interprete de HTML
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

	function Footer() {
		$fecha=date("d/m/Y");
		$hora= date("H:i:s");
		$this->SetXY(4,203);
		$this->WriteHTML(' Fecha de Impresion: ' . $fecha . ' ' . $hora . '');
		//	$this->Cell(0,5,'P�gina '.$this->PageNo().'/'.$this->cantidadPag,0,0,'R',0,0,'R');
		$this->SetX(268);
		$this->Cell(0,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
	}



}
?>
