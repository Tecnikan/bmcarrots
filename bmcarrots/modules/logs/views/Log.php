<?php

class LogView extends AppView{
	
	public function index(){
		$pagina=file_get_contents(WEB_ROOT."Log.html"); 
		
		if(isset($_SESSION['accum'])&& isset($_SESSION['total'])){
			$paginafinal=str_replace('{TOTAL}', "$ ".$_SESSION['total'].".00", $pagina);
		}
		else{
			$paginafinal=str_replace('{TOTAL}', "Add products", $paginafinal);
		}
		$paginafinal=str_replace('{TOTAL}', "Add products", $paginafinal);
		$paginafinal = str_replace('{MENSAJE}', '', $paginafinal);
		$paginafinal = str_replace('{WEB_DIR}', WEB_DIR, $paginafinal);
		print($paginafinal);

	}
	public function notFound(){
		$pagina=file_get_contents(WEB_ROOT."Log.html"); 
		if(isset($_SESSION['accum'])&& isset($_SESSION['total'])){
			$paginafinal=str_replace('{TOTAL}', "$ ".$_SESSION['total'].".00", $pagina);

		}
		else
		{$paginafinal=str_replace('{TOTAL}', "Add products", $paginafinal);}
		$paginafinal = str_replace('{MENSAJE}', 'NO EXISTE EL USUARIO, O LOS DATOS ESTAN MAL, INTENTE DE NUEVO', $paginafinal);
		$paginafinal = str_replace('{WEB_DIR}', WEB_DIR, $paginafinal);
		print($paginafinal);

	}
}
	?>