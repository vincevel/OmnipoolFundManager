<?php

namespace App;

 use App\UserParent;

class SQueue 
{
   
  public $count = 0; 
  public $storage1 = array();  
   
  public function __construct(){
      
       
   }
   
   public function push(UserParent $value){
       
       $this->storage1[] = $value;
       
       
   }
   
   public function pop(){
        
        $counter = $this->count;
        $this->count++;
        if (isset($this->storage1[$counter])){
          return $this->storage1[$counter];
        }else{
          return NULL;
        }
   }
   
   public function clear(){

      $this->storage1 = array();
      $this->count = 0;
   }

   public function getArr(){
      return $this->storage1;

   }

}
