<?php
class ReceiptView extends AppView{
	
	public function index($datos2,$address_c,$name_c,$date_sale,$subtotal,$iva){
		
		$pagina=file_get_contents(WEB_ROOT."Payment.html"); 
		$pos1 = strpos($pagina,'<!--TICKET-->');
		$pos2 = strrpos($pagina,'<!--TICKET-->'); 
		$length = $pos2-$pos1;
    	$match = substr($pagina,$pos1,$length);
    	$render='';
		
		foreach($datos2 as $i=>$dict){
			$render.=str_replace(array_keys($dict),array_values($dict), $match);
					
		}

		$paginafinal=str_replace($match, $render, $pagina);

		 
		if(isset($_SESSION['accum'])&& isset($_SESSION['total'])){
			$paginafinal=str_replace('{TOTAL}', "$ ".$_SESSION['total'].".00", $paginafinal);
		}
		else
		{
			$paginafinal=str_replace('{TOTAL}', "Add products", $paginafinal);
		}
		//Sustitución de todos los datos del ticket

			$paginafinal = str_replace('{NAME_C}', $name_c, $paginafinal);
			$paginafinal = str_replace('{ADRESS_C}',$address_c, $paginafinal);
			$paginafinal = str_replace('{FECHA}', $date_sale, $paginafinal);
			$paginafinal = str_replace('{SUBTOTAL}', $subtotal, $paginafinal);
			$paginafinal = str_replace('{IVA}', $iva, $paginafinal);
			$paginafinal = str_replace('{WEB_DIR}', WEB_DIR, $paginafinal);
		print($paginafinal);
		}

		public function msgPay($cadena){
			$pagina=file_get_contents(WEB_ROOT."MsgPay.html"); 
			$paginafinal = str_replace('{MESSAGE}', $cadena, $pagina);
			$paginafinal=str_replace('{TOTAL}', "Add", $paginafinal);
			$paginafinal = str_replace('{WEB_DIR}', WEB_DIR, $paginafinal);
			print($paginafinal);

		}

		public function cardinfo($bienvenida){
			$pagina=file_get_contents(WEB_ROOT."CardInfo.html"); 
			$paginafinal=str_replace('{TOTAL}', "$ ".$_SESSION['total'].".00", $pagina);
			$paginafinal=str_replace('{BIENVENIDA}', $bienvenida, $paginafinal);
			$paginafinal = str_replace('{WEB_DIR}', WEB_DIR, $paginafinal);
			print($paginafinal);

		}

	}

	?>