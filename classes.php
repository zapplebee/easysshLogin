<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

set_include_path("phpseclib/phpseclib");
include("Net/SFTP.php");


class easysshLogin{

  private $address;
  private $port;
  private $secret;
  public $username;
  public $errors = array();
  private $connectionStatus = false;

  function __construct($server,$port,$secret){
  
    if(!isset($_SESSION['easysshLogin'])){
      $_SESSION['easysshLogin'] = array();
    }
    $this->address = $server;
    $this->port = $port;
    $this->secret = $secret;
  
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
    
      $this->username = $user;
      $this->connectionStatus = true;
      $_SESSION['easysshLogin'][$this->username] = openssl_encrypt(json_encode(array($user,$pass)), "bf-ecb", $this->secret);
      return true;
      
    }

  }
  
  private function getUserCreds(){
  
    if (!isset($_SESSION['easysshLogin'][$this->username])){
      return false;
    }
    $creds = json_decode(openssl_decrypt($_SESSION['easysshLogin'][$this->username], "bf-ecb", $this->secret),true);
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

?>