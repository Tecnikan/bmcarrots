<?php

class CartView extends AppView{
	
	public function index($datos){
		$_SESSION['completcar']=$datos; 
		$pagina=file_get_contents(WEB_ROOT."Cart.html"); 
		$pos1 = strpos($pagina,'<!--CART-->');
		$pos2 = strrpos($pagina,'<!--CART-->'); 
		$length = $pos2-$pos1;
    	$match = substr($pagina,$pos1,$length);
		$render='';
		
		foreach($datos as $i=>$dict){
			$render.=str_replace(array_keys($dict),array_values($dict), $match);
					
		}

		$paginafinal=str_replace($match, $render, $pagina);
		 
		if(isset($_SESSION['accum'])&& isset($_SESSION['total'])){
			$paginafinal=str_replace('{TOTAL}', "$ ".$_SESSION['total'].".00", $paginafinal);

		}
		else
		{$paginafinal=str_replace('{TOTAL}', "Add products", $paginafinal);}
		$paginafinal = str_replace('{WEB_DIR}', WEB_DIR, $paginafinal);
		print($paginafinal);
		

		
	}



}
?>