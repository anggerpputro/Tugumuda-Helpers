<?php
namespace Tugumuda\Helpers;

use rizalafani\fpdflaravel\Fpdf as FPDFS;

use Traits\PdfBarcode;
use Traits\PdfAutoPrint;

class FPDF extends FPDFS {

	use PdfBarcode;
	use PdfAutoPrint;

    var $widths;
    var $aligns;
    var $judul;

	var $default_cell_w = 200;
	var $default_cell_h = 7;

	var $p_width = 210;
	var $p_height = 297;

	var $m_left = 5;
	var $m_right = 5;
	var $m_top = 5;
	var $m_bottom = 5;

	var $cont_width = 0;
	var $cont_height = 0;


	function __construct($orientation='P', $unit='mm', $format='A4') {
		parent::__construct($orientation,$unit,$format);
	}


	function SetWidths($w){
        $this->widths=$w;
    }

    function SetAligns($a){
        $this->aligns=$a;
    }

	function PrintCell($txt='', $border=0, $ln=1, $align='', $fill=false, $link='')
	{
		return $this->Cell(
			$this->default_cell_w,
			$this->default_cell_h,
			$txt,
			$border,
			$ln,
			$align,
			$fill,
			$link
		);
	}

	function TabbedCell($tab_width, $w=0, $h=0, $txt='', $border=0, $ln=0, $align='L', $fill=false, $link='')
	{
		$this->Cell($tab_width, $h);
		$this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
	}

    function Row($data, $lebar=8, $header = []){
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=$lebar*$nb;
        //Issue a page break first if needed
		if($this->CheckPageBreak($h) && !empty($header)) {
			$this->Row($header, $lebar);
		}
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
            $this->MultiCell($w,$lebar,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function RowNoLines($data, $lebar=8, $header = []){
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=$lebar*$nb;
        //Issue a page break first if needed
        if($this->CheckPageBreak($h) && !empty($header)) {
			$this->RowNoLines($data, $lebar);
		}
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
//            $this->Rect($x,$y,$w,$h);
            //Print the text
            $this->MultiCell($w,$lebar,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h){
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger) {
			$this->AddPage($this->CurOrientation);
			return true; // means page added
		}
		return false; // means no need to add new page
    }

    function NbLines($w,$txt){
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
        while($i<$nb){
            $c=$s[$i];
            if($c=="\n"){
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
            if($l>$wmax){
                if($sep==-1){
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

	/**
	 * Gambar Dash
	 *
	 * @param int $black: panjang garis hitam in mm, ex: 5 (berarti 5mm)
	 * @param int $black: panjang garis putih in mm, ex: 5 (berarti 5mm)
	 */
	function SetDash($black=null, $white=null)
    {
        if($black!==null)
            $s=sprintf('[%.3F %.3F] 0 d',$black*$this->k,$white*$this->k);
        else
            $s='[] 0 d';
        $this->_out($s);
    }
}
