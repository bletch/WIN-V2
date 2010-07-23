<?php

class Map{
  
  private     $v_xSize              = 0;
  private     $v_ySize              = 0;
  private     $v_displayedMapSize   = 0;
  
  public function __construct(){
    $this->v_xSize              = 40;
    $this->v_ySize              = 40;
    $this->v_displayedMapSize   = 9;       /* must be an odd number */
  }
  
  public function buildMap($i_xPos, $i_yPos){
    $range        = 0;
    $xStart       = 0;
    $yStart       = 0;
    $returnString = '';
    
    $range = ($this->v_displayedMapSize - 1) / 2;
    
    if($range > $i_xPos){
      $i_xPos = $range;
    }
    elseif(($this->v_xSize - $range) <= $i_xPos){
      $i_xPos = $this->v_xSize - ($range + 1);
    }
    else{
      /* $i_xPos is in range */
    }
    
    if($range > $i_yPos){
      $i_yPos = $range;
    }
    elseif(($this->v_ySize - $range) <= $i_yPos){
      $i_yPos = $this->v_ySize - ($range + 1);
    }
    else{
      /* $i_yPos is in range */
    }
    
    $xStart = $i_xPos - $range;
    $xEnd   = $i_xPos + $range;
    $yStart = $i_yPos - $range;
    $yEnd   = $i_yPos + $range;
    
    for($i = $yStart; $i <= $yEnd; $i++){
      for($j = $xStart; $j <= $xEnd; $j++){
        $returnString .= '<img src="images_map/map_'.$i.'_'.$j.'.jpg" />';
      }
    }
    
    return $returnString;
  }
}

?>