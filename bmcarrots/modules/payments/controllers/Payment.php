<?php

	import('modules.payments.models.Payment');
	import('modules.payments.views.Payment');

	
	class PaymentController extends AppController{ 

	public function index(){


		$this->model->customer_id=$_SESSION['customer_id']; 
		$this->model->getUser(); 
		$datos=$_SESSION['completcar'];
		$this->model->date_sale=date('Y-m-d');
		$name_c= $this->model->name_c." ".$this->model->lastname_c;
		$address_c= $this->model->address_c;
		$date_sale=$this->model->date_sale;

		$subtotal=round($_SESSION['total']/1.16, 2);
		$iva=round($_SESSION['total']-$subtotal, 2); 
		$this->view->index($datos, $address_c,$name_c, $date_sale, $subtotal, $iva); 
	}

	public function type_p(){

		$typep=$_POST['tipo'];
		
			switch($typep){
					case 1: 
							$this->model->type_pay=1;
							$this->cash(); 
							break; 
					case 2:  	
							$this->model->type_pay=2;
							$this->cardinfo(); 
							break; 
			}

	}
	public function cash(){

	$cadena ="<p>Total a depositar: $".$_SESSION['total'].".00 <br/>Cuenta para depositar: #############<br/>
	 Dirección para recoger envío: ######<br/>
	 Nota:
	 <p> Una vez recibido su depósito, en  un lapso de 10 a 15 días su pedido será entregado. En caso contrario comúnicarse al teléfono  333-33-33.
	 <br/> ¡Gracias por su compra!</p>";
//--- Enviar correo al cliente--//
		$para      = $_SESSION['mail'];
		$titulo    = 'Datos de su compra';
		$mensaje   = $cadena; 
		$cabeceras = 'From: webmaster@bmcarrots.com' . "\r\n" .
    				'Reply-To: webmaster@bmcarrots.com' . "\r\n" ;
    				

		//mail($para, $titulo, $mensaje, $cabeceras);

	 $this->view->msgPay($cadena); 

	}

	public function cardinfo(){
		$bienvenida="Bienvenido " .$_SESSION['user']." agradecemos su información";
		$this->view->cardinfo($bienvenida); 
	}
public function credit(){
		$longitud=strlen($_POST['creditcard']); 
		if($longitud==16&&$_POST['creditcard']!='0000000000000000'){
			$cadena ="<p>¡Trasnsacción Exitosa!<br/>
				 	Pago Efectuado por: $".$_SESSION['total'].".00 <br/>
					En  un lapso de 6 días su pedido será entregado. En caso contrario comúnicarse al teléfono  333-33-33.
	 				<br/> <a href='/bmcarrots/receipts/receipt/index' target='_blank'>Receipt</a>   ¡Gracias por su compra!</p>";

	 				$para= $_SESSION['mail'];
					$titulo    = 'Datos de su compra';
					$mensaje   = $cadena; 
					$cabeceras = 'From: webmaster@bmcarrots.com' . "\r\n" .
    				'Reply-To: webmaster@bmcarrots.com' . "\r\n" ;
    				//mail($para, $titulo, $mensaje, $cabeceras);
			
			$this->view->msgPay($cadena); 

		}
		else {
			$cadena ="<p>¡Trasnsacción Fallida!<br/>
				 	  El pago no pudo ser completado";
	 				$this->view->msgPay($cadena); 
		}
	}
	}
	?>