<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrgUser2 extends Model
{

    public $total = 0;

    public $name;
    public $id;
    
    public $date;

    public $stack = array();
    
    function __construct($id,$name,$date){
        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
        
    }
    
    function say(){
        echo $this->id . "<BR>";
    }
    
    function add($item){
        
        $this->stack[] = $item;
    }
    
    
    function insert($code,$item,$item2){
        
        switch ($code){
            
        case 1:
        case 9:
        case 7:
            $this->total += $item;
            break;
            
        case 3:
        case 10:    
        case 8:    
            $this->total -= $item;
            break;
            
        case 6:
            $this->total -= $item2;
            break;    
            
        }
    }
    
    
    function say2(){
         //echo "<BR>" . "This is MY ID" . " " . $this->id . "<BR>";
        var_dump($this->stack) . "<BR>";
    }
    
    function say3(){
         echo "<BR>" . "This is MY ID" . " " . $this->id . "<BR>";
        if ($this->total < 0 ){
            echo "NEGA" . " " . $this->total . "<BR>";
        } else {
            echo $this->total . "<BR>";
        }
        
    }
    
    function sayAmount(){
        return $this->nformat($this->total);
    }

    function say4(){
         echo $this->nameformat($this->name) . " - " . $this->id . " - " . $this->nformat($this->total) . "<BR>";
        
        
    }
    
    function say5(){
        
        
        
         return array($this->nameformat($this->name),$this->nformat($this->total),$this->date);
        
        
    }
    
    
    function nformat($num){
        //return $num;
        
         if ($num == 0){
        return intval("0.00");
        } else {
            return $num;
        }
        
    }
    
    function nameformat($name){
        
        return ucwords(strtolower($name));
    }
    
}
