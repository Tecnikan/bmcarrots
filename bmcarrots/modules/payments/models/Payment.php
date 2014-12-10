<?php


class Payment extends AppModel{ 
    public $customer_id; 
    public $name_c; 
    public $lastname_c;
    public $address_c;
    public $date_sale;
    public $type_pay; 
    public $receipt; 

    function __construct() {
       
        $this->customer_id=0; 
        $this->name_c=''; 
        $this->lastname_c='';
        $this->address_c='';
        $this->date_sale='';
        $this->type_pay=0; 
        $this->receipt=0; 
    }
 
      
    public function getUser(){

        $sql ="SELECT name_c,lastname_c,  address_c, customer_id FROM customer 
        WHERE customer_id =?";
        $data =array("i","{$this->customer_id}");
        $fields = array(
                'NAME_C' => '',
                'LASTNAME_C' => '',
                'ADDRESS_C' => '',
                'CUSTOMER_ID' => ''); 
         DBModel::execute($sql, $data, $fields);
          
         $this->name_c = $fields['NAME_C'];
         $this->lastname_c=$fields['LASTNAME_C'];
         $this->address_c=$fields['ADDRESS_C'];
         $this->customer_id=['CUSTOMER_ID'];
        
   }
   public function getreceipt(){

        $venta= "SELECT COUNT( DISTINCT(receipt)) as factura FROM detail_sail where detail_sale_id>?";
        $data =array("i",0);
        $fields = array(
                'RECEIPT' => '');
        DBModel::execute($sql, $data, $fields);
        $this->receipt=$fields['RECEIPT'];
        
   }
   


  

}
?>