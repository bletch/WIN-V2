<?php
class Factory{
  
  const CLASS_PATH = 'app/class/';
  
  private function __construct(){
  }
  
  private function __clone(){
  }
  
  public static function get($i_className, $i_params = null){
    $file         = '';
    $className    = '';
    $tmp          = array();
    $returnObject = NULL;
    
    if(   (false == is_string($i_className))
       || (false == trim($i_className))
      ){
      throw new Exception('ERROR: Factory: Invalid class name');
    }
    
    $file = self::CLASS_PATH.str_replace('.', DIRECTORY_SEPARATOR, $i_className).'.php';
    if(false == file_exists($file)){
      throw new Exception('ERROR: Factroy: File not found.');
    }
    require_once $file;
    
    try{
      $tmp          = explode('::', $i_className);
      $className    = array_pop($tmp);
      eval('$returnObject = '.$className.'::get'.$className.'('.$i_params.');');
    }catch( Exception $e ){
      throw new Exception('ERROR: Facorry: '.$e->getMessage());
    }
    return $returnObject;
  }
}