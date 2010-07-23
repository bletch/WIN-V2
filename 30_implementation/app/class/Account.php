<?php
require_once 'app/class/BaseObject.php';
require_once 'data/IStorable.php';

Class Account extends BaseObject implements IStorable{
  
  const             XML_FILE      = 'app/xml/Account.xml';
  private static    $instances    = array();
  
  public function __toString(){
    $returnString  = '';
    
    $returnString  = '<div class="account"><h1>Account (table: '.$this->attributes()->table.')</h1>';
    $returnString .= parent::__toString();
    $returnString .= '</div>';
    return $returnString;
  }
  
  public static function getAccount($i_id = -1){
    $returnAccount = null;
    
    if(true == array_key_exists("$i_id", self::$instances)){
      $returnAccount = self::$instances["$i_id"];
    }
    else{
      $returnAccount = new Account(self::XML_FILE, 0, true);
      if(-1 != $i_id){
        $returnAccount->setProperty('id', $i_id);
        parent::loadObjectData($returnAccount);
      }
    }
    return $returnAccount;
  }
}
?>
