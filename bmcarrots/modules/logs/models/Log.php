<?php


class Log extends AppModel{ 
        public $mail_u;
        public $pass_u;
        public $profile_id;
        public $name_c;
        public $lastname_c;
        public $adress_c;
        public $customer_id; 
   

    function __construct() {
        $this->mail_u= '';
        $this->pass_u = '';
        $this->profile_id=0;
        $this->name_c='';
        $this->lastname_c='';
        $this->adress_c='';
        $this->customer_id;
    }
 
      
    public function get(){
            
       $sql = "SELECT customer_id, name_c, lastname_c, address_c,  profile_id FROM customer WHERE mail_u=? and pass_u=?";
      $data = array("ss", "{$this->mail_u}","{$this->pass_u}");
      $fields = array(
                'CUSTOMER_ID'=>'',              
                'NAME_C' => '',
                'LASTNAME_C' => '',
                'ADRESS_C' => '', 
                'PROFILE_ID'=>'');

        DBModel::execute($sql, $data, $fields);
         $this->profile_id = $fields['PROFILE_ID'];
         $this->name_c=$fields['NAME_C'];
         $this->customer_id=$fields['CUSTOMER_ID'];
         return DBModel::$results; 
      

   }


}
?>