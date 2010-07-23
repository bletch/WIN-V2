<?php
interface IStorable {
  public function getTable();
  public function getProperty($i_property);
  public function setProperty($i_property, $i_value);
}
?>
