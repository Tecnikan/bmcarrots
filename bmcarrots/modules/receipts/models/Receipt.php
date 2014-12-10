<?php
 import('modules.receipts.models.PDF');

class Receipt extends AppModel{ 
        
    public function index(){
        $datos=$_SESSION['completcar'];

        $user=$_SESSION['user'];
        $pdf=new PDF('P', 'mm', 'A4');
        $pdf->AddPage();
        //$pdf->Image();
        $pdf->Cell(80,5,'Tienda  Online BMCARROTS S.A de C.V.',0,1,'C');
         $pdf->Ln();
        $pdf->Cell(80,5,$user,0,1,'L');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(40,4,'Cantidad',0,0,'C');
        $pdf->Cell(40,4,'Nombre',0,0,'C');
        $pdf->Cell(40,4,'Precio',0,0,'C');  
        $pdf->Cell(40,4,'Importe',0,0,'C'); 
         $pdf->Ln();
        foreach($datos as $i=>$dict){
         $pdf->Cell(40,4,$dict['{QUANTY}'],0,0,'C'); 
         $pdf->Cell(40,4,$dict['{NAME_P}'],0,0,'C');
         $pdf->Cell(40,4,$dict['{PRICE_P}'],0,0,'C'); 
         $pdf->Cell(40,4,$dict['{COST}'],0,0,'C');
         $pdf->Ln();
          } 
           $pdf->Cell(40,4,'_______________________________________________________________________________________________________________________________________',0,1,'C'); 
         $pdf->Cell(40,4,'TOTAL: ',0,0,'C');    
        $pdf->Cell(110,4,'$ '.$_SESSION['total'].'.00',0,0,'R');
        $pdf->Ln();
        $pdf->Cell(40,4,'',0,0,'C');
        $pdf->Cell(40,4,'________________________________________________________________________________________________________',0,1,'C');
        $pdf->Cell(200,4,'DATOS CFDI',0,0,'C');
        $pdf->Ln();
        $pdf->Cell(80,5,'ESTA ES UNA REPRESENTACION IMPRESA DE UN CFDI',0,0,'L');
        $pdf->Ln();
        $pdf->Cell(70,4,'REGIMEN DE PERSONAS MORALES',0,0,'L');
        $pdf->Ln();
        $pdf->Cell(70,4,'FORMA DE PAGO EN UNA EXHIBICION',0,0,'L');
        $pdf->Ln();
        $pdf->Cell(70,4,'PAGO CON TARJETA DE CREDITO',0,0,'L');
        $pdf->Ln();
        $pdf->Cell(40,4,'',0,0,'C');
       

        //Aquí escribimos lo que deseamos mostrar...
        $pdf->Output();
    }
}
?>