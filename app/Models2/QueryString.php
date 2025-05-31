<?php

namespace App;

 

class QueryString 
{
   
   public $qstring;
   public $first;
   public $empty;
    
   
   public function __construct(){
       
       $this->qstring .= "?";
       $this->first = true;
       $this->empty = true;
       
   }
   
   public function addParam($param,$value){
       
       if ($this->first){
             $this->qstring .= $param . "=" . $value;
             $this->empty = false;
             $this->first = false;
       }else{
             $this->qstring .= "&";
             $this->qstring .= $param . "=" . $value;
       }
       
       
   }
   
   public function getQString(){
       return $this->qstring;
   }
   
}
