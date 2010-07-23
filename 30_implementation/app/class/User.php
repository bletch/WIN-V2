<?php
require_once 'app/class/BaseObject.php';
require_once 'data/IStorable.php';

Class User extends BaseObject implements IStorable{
  
  const             XML_FILE      = 'app/xml/User.xml';
  private static    $instances    = array();
  
  public function __toString(){
    $returnString  = '';
    
    $returnString  = '<div class="user"><h1>User (table: '.$this->attributes()->table.')</h1>';
    $returnString .= parent::__toString();
    $returnString .= '</div>';
    return $returnString;
  }
  
  public static function getUser($i_id = -1){
    $returnUser = null;
    
    if(true == array_key_exists("$i_id", self::$instances)){
      $returnUser = self::$instances[$i_id];
    }
    else{
      $returnUser = new User(self::XML_FILE, 0, true);
      if(-1 != $i_id){
        $returnUser->setProperty('id', $i_id);
        parent::loadObjectData($returnUser);
      }
    }
    return $returnUser;
  }
}
?>
