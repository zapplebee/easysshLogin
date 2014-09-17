<pre>
<?php

include("../../credentials.php");
set_include_path("phpseclib/phpseclib");
include("Net/SFTP.php");

/*
  Set your server details. In this case it has been included in "../../credentials.php".;

  $sshServer = array(
    "address" => "YOUR SERVER ADDRESS",
    "port"    => "YOUR SERVER PORT",
  );

  Set test cases. In this case it has been included in "../../credentials.php".
  
  $testCases = array("user" => "pass");
*/

class user{
  private $address;
  private $port;

  function __construct($creds){
  
    $this->address = $creds['address'];
    $this->port = $creds['port'];
  
  }


  public function login($user, $pass){
  
    $pattern ="#[^A-Za-z0-9\._-]#";
    preg_match($pattern, $user, $results);
    if(!empty($results) || $user[0] == "-" || strlen($user) > 8 || strlen($user) == 0){
      return "Bad Username";
    }

    $pattern ="#[\n\t\r]#";
    preg_match($pattern, $pass, $results);
    if(!empty($results)){
      return "Bad Password";
    }
  
    $SSH = new Net_SSH2($this->address, $this->port);
    if (!$SSH->login($user, $pass)) {
      return ("Connection to server failed.");
    }
    else {
      return "Good connection and credentials";
    }

  }

}



$user = new user($sshServer);

foreach ($testCases as $key => $pass){
  echo "<h3>$key</h3>";
  echo "<h3>$pass</h3>";
  echo $user->login($key,$pass);
  echo "<HR>";

}

?>
</pre>