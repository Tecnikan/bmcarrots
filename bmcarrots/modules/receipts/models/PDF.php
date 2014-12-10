<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
   //Cabecera de página
   function Header()
   {

   		$fecha=date('m/d/Y');
   		$hora=date('H:i:s');
   		//echo $fecha;

      //$this->Image('/bmcarrots/modules/receipts/models/fpdf/logo.png',20,25,15,0,'PNG');
      $this->Ln();
      $this->SetFont('Arial','B',11);
      $this->Cell(230);
      $this->Cell(40,5,'Fecha: '.$fecha,0,1,'L','');
      $this->Ln();
      $this->Cell(230);
      $this->Cell(40,-5,'Hora:   '.$hora,0,1,'L');   
   }


}
?>