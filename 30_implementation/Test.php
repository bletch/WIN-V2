<?php
require_once 'sess/Session.php';
require_once 'app/class/Factory.php';

try{
  $session = new Session(3600);
}catch(Exception $e){
  echo $e->getMessage();
}

?>
<style>
  .account, .user{
    width:192px;
    height:92px;
    font:10px arial;
    border:2px dashed #B0ADAD;
    background-color: #D9D7D7;
    padding: 2px;
  }
  .account h1, .user h1{
    font:bold 12px arial;
  }
</style>

<?php
try{
  $testAccount = Factory::get('Account',1);
  
  echo$testAccount;
  echo '<br>';
  
  $testUserId = $testAccount->getProperty('user');
  echo Factory::get('User',$testUserId);
}
catch(Exception $e){
  echo $e->getMessage();
}
?>