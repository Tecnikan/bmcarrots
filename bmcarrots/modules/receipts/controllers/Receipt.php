<?php

	import('modules.receipts.models.Receipt');
	import('modules.receipts.views.Receipt');
	

	
	class ReceiptController extends AppController{  

						
   				public function index(){
							$this->model->index(); 				
				}
	}


?>