<?php
require_once 'conf/MySQLConfig.php';

class MySQLConnection {
  private     $Connection       = false;
  private     $DBSelectResult   = false;
  
  public function openConnection() {
    $this->Connection = new mysqli(MySQLConfig::$DBHost,
                                   MySQLConfig::$DBUser,
                                   MySQLConfig::$DBPassword,
                                   MySQLConfig::$DBName);
                                   
    if ($this->Connection->connect_error) {
      /*TODO: log ERROR DB connection */
      throw new Exception('Error: Connect Error ('. $this->Connection->connect_errno .'): '.$this->Connection->connect_error);
    }
    $this->Connection->autocommit(FALSE);
    return;
  }
  
  public function closeConnection() {
    $this->Connection->commit();
    $this->Connection->close();
    return;
  }
  
  public function selectRowById($i_id, $i_tableName){
    $result       = '';
    $queryString  = 'SELECT * 
                     FROM `'.$i_tableName.'` 
                     WHERE `id` = '.$i_id.';';
    $result = $this->Connection->query($queryString);
    if(false == $result){
      throw new Exception('Error: Could not load object from database');
    }
    return $result->fetch_object();
  }
  
  public function insertRowIntoTable($i_tableName, $i_values){
    $queryString  = '';
    $result       = '';
    
    $queryString = 'INSERT `'.$i_tableName.'` 
                    SET ';
    foreach($i_values as $column => $value){
      if('id' != $column){
        $queryString  .= '`'.$column.'` = \''.$this->Connection->real_escape_string($value).'\', ';
      }
    }
    /* remove last comma*/
    $queryString  = substr($queryString, 0, strlen($queryString)-2);
    
    $result = $this->Connection->query($queryString);
    if(false == $result){
      throw new Exception('Error: Could not insert object to database');
    }
    return;
  }
  
  public function updateRowById($i_id, $i_tableName, $i_values){
    $queryString      = '';
    $result           = '';
    $numberOfEntries  = 0;
    
    $queryString = 'UPDATE `'.$i_tableName.'` 
                    SET ';
    
    foreach($i_values as $column => $value){
      $queryString  .= '`'.$column.'` = \''.$this->Connection->real_escape_string($value).'\', ';
    }
    /* remove last comma */
    $queryString   = substr($queryString, 0, strlen($queryString)-2);
    $queryString  .= 'WHERE `id` = '.$i_id;
    
    $result = $this->Connection->query($queryString);
    if(false == $result){
      throw new Exception('Error: Could not update object to database');
    }
    return;
  }
  
  public function IsIdExistingInTable($i_id, $i_tableName){
    $queryString        = '';
    $result             = '';
    $numberOfEntries    = 0;
    $returnValue        = false;
    
    $queryString      = 'SELECT * 
                         FROM `'.$i_tableName.'` 
                         WHERE `id` = '.$i_id;
    $result           = $this->Connection->query($queryString);
    $numberOfEntries  = $result->num_rows;
    
    if(1 == $numberOfEntries){
      $returnValue = true;
    }
    elseif(0 == $numberOfEntries){
      $returnValue = false;
    }
    else{
      throw new Exception('Error: Database error');
    }
    return $returnValue;
  }
}
?>
