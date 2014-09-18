<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../../credentials.php");
set_include_path("phpseclib/phpseclib");
include("Net/SFTP.php");

/*
  Set your server details & test cases. In this case it has been included in "../../credentials.php".;

  $sshServer = array(
    "address" => "YOUR SERVER ADDRESS",
    "port"    => "YOUR SERVER PORT",
    "secret"  => "YOUR SECRET ENCRYPTION PHRASE",
  );
  
  $testCases = array("user" => "pass");
*/

class user{

  private $address;
  private $port;
  private $secret;
  public $user;
  public $errors = array();
  private $connectionStatus = false;

  function __construct($creds){
  
    if(!isset($_SESSION['easysshLogin'])){
      $_SESSION['easysshLogin'] = array();
    }
    $this->address = $creds['address'];
    $this->port = $creds['port'];
    $this->secret = $creds['secret'];
  
  }



  public function login($user, $pass){
  
    $pattern ="#[^A-Za-z0-9\._-]#";
    preg_match($pattern, $user, $results);
    if(!empty($results) || $user[0] == "-" || strlen($user) > 8 || strlen($user) == 0){
      $this->errors[] = "Bad Username.";
      return false;
      
    }

    $pattern ="#[\n\t\r]#";
    preg_match($pattern, $pass, $results);
    if(!empty($results)){
      $this->errors[] = "Bad Password.";
      return false;
      
    }
  
    $SSH = new Net_SSH2($this->address, $this->port);
    if (!$SSH->login($user, $pass)) {
      $this->errors[] = "Bad connection or incorrect credentials.";
      return false;
      
    }
    else {
    
      $this->user = $user;
      $this->connectionStatus = true;
      $_SESSION['easysshLogin'][$this->user] = openssl_encrypt(json_encode(array($user,$pass)), "bf-ecb", $this->secret);
      return true;
      
    }

  }
  
  private function getUserCreds(){
  
    if (!isset($_SESSION['easysshLogin'][$this->user])){
      return false;
    }
    $creds = json_decode(openssl_decrypt($_SESSION['easysshLogin'][$this->user], "bf-ecb", $this->secret),true);
    return $creds;
  
  }
  
  
  
  public function sshConnection(){
    
    $creds = $this->getUserCreds();
  
    
    if (!$this->connectionStatus){
      return false;
    }
    
    $SSH = new Net_SSH2($this->address, $this->port);
    if (!$SSH->login($creds[0], $creds[1])) {
      $this->errors[] = "Bad connection or incorrect credentials.";
      return false;
    }
    
    return $SSH;

  }
  
  public function sftpConnection(){
    
    $creds = $this->getUserCreds();
  
    
    if (!$this->connectionStatus){
      return false;
    }
    
    $SFTP = new Net_SFTP($this->address, $this->port);
    if (!$SFTP->login($creds[0], $creds[1])) {
      $this->errors[] = "Bad connection or incorrect credentials.";
      return false;
    }
    
    return $SFTP;

  }

}



$user = new user($sshServer);

foreach ($testCases as $key => $pass){

  $user->login($key,$pass);
  $conn = $user->sshConnection();
  echo $conn->exec("date\n");
  echo "<HR>";

}

?>