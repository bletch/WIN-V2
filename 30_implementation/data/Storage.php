<?php
require_once 'MySQLConnection.php';

class Storage {
  
  private         $DBConnection   = NULL;
  static private  $instance       = NULL;
  
  private function __construct(){
  }
  
  private function __clone(){
  }
  
  static public function getInstance(){
    if(NULL == self::$instance){
      self::$instance               = new self;
      self::$instance->DBConnection = new MySQLConnection();
    }
    return self::$instance;
  }
  
  public function storeObject(IStorable $i_objToStore){
    $properties      = array();
    
    try{
      $this->DBConnection->openConnection();
    }
    catch(Exception $e){
      echo $e->getMessage();
    }
    
    foreach($i_objToStore as $member){
      if('primaryKey' != $member->attributes()->type){
        $properties[$member->getName()] = (string)$member;
      }
    }
    
    if(true == $this->DBConnection->isIdExistingInTable($i_objToStore->getProperty('id'), $i_objToStore->getTable())){
      $this->DBConnection->updateRowById($i_objToStore->getProperty('id'), $i_objToStore->getTable(),$properties);
    }
    else{
      $this->DBConnection->insertRowIntoTable($i_objToStore->getTable(),$properties);
    }
    
    $this->DBConnection->closeConnection();
    return;
  }
  
  public function loadObject(IStorable $b_objToLoad) {
    $result       = '';
    $property     = '';
    
    try{
      $this->DBConnection->openConnection();
    }
    catch(Exception $e){
      echo $e->getMessage();
    }
    
    if(true == $this->DBConnection->isIdExistingInTable(($b_objToLoad->getProperty('id')), $b_objToLoad->getTable())){
      $result = $this->DBConnection->selectRowById($b_objToLoad->getProperty('id'), $b_objToLoad->getTable());
      foreach($b_objToLoad as $member){
        $property               = $member->getName();
        $b_objToLoad->$property = $result->$property;
      }
    }
    else{
      throw new Exception('loadObject: Object does not exist');
    }
    $this->DBConnection->closeConnection();
    return;
  }
  
  public function searchObjectByAttribute(IStorable $i_ObjToSearch ){
    
  }
}
?>
