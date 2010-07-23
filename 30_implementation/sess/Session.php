<?php
class Session{
  
  public function __construct($i_time){
    $isSessionActive = false;
    
    session_set_cookie_params($i_time);
    $isSessionActive = session_start();
    
    if(false == $isSessionActive){
      throw new Exception('Session: Session could not be initialized');
    }
    return;
  }
  
  public function closeSession(){
    session_unset();
    session_destroy();
    return;
  }
  
  public function getValue($i_key, &$o_value){
    $isKeyExisting = false;
    
    $isKeyExisting = array_key_exists($i_key, $_SESSION);
    if(false == $isKeyExisting){
      throw new Exception('Session: Key not existing');
    }
    else{
      $o_value = $_SESSION[$i_key];
    }
    return $isKeyExisting;
  }
  
  public function setValue($i_key, $i_value){
    $_SESSION[$i_key] = $i_value;
    return;
  }
  
  public function deleteValue($i_key){
    $isKeyExisting = false;
    
    $isKeyExisting = array_key_exists($i_key, $_SESSION);
    if(false == $isKeyExisting){
      throw new Exception('Session: Key not existing');
    }
    else{
      unset($_SESSION[$i_key]);
    }
    return;
  }
}

?>