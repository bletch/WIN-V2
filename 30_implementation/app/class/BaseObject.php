<?php
require_once 'data/Storage.php';

class BaseObject extends SimpleXMLElement {
  
  private static    $storage      = NULL;
  
  public function __toString(){
    $returnString = '';
    
    foreach($this as $member){
      $returnString .= $member->getName().' ('.$member->attributes()->type.') : '.(string)$member;
      $returnString .= '<br />';
    }
    return $returnString;    
  }
  
  static protected function loadObjectData($b_Object){
    self::$storage  = Storage::getInstance();
    self::$storage->loadObject($b_Object);
    return;
  }
  
  public function getProperty($i_property){
    $returnValue = '';
    
    if(false == $this->xpath($i_property)){
      throw new Exception('getProperty: Unknown property.');
    }
    else{
      $returnValue = (string)$this->$i_property;
    }
    return $returnValue;
  }
  
  public function getTable(){
    return $this->attributes()->table;
  }
  
  public function setProperty($i_property, $i_value){
    if(false == $this->xpath($i_property)){
      throw new Exception('setProperty: Unknown property.');
    }
    else{
      $this->$i_property = $i_value;
    }
    return;
  }
  
  public function store(){
    self::$storage->storeObject($this);
    return;
  }
}