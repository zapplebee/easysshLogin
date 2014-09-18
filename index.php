<!DOCTYPE html>
<html>
<head>
<title>easysshLogin Demo</title>
</head>
<body>
<h1>easysshLogin Demo</h1>
<pre>
<?php
include("../../credentials.php");
include('classes.php');
/*
  Set your server details & test cases. In this case it has been included in "../../credentials.php".;

  $sshServer = array(
    "address" => "YOUR SERVER ADDRESS",
    "port"    => "YOUR SERVER PORT",
    "secret"  => "YOUR SECRET ENCRYPTION PHRASE",
  );
  
  $testCase = array("user","pass");
*/

$user = new user($sshServer);


  $user->login($testCase[0],$testCase[1]);
  $conn = $user->sshConnection();
  echo $conn->exec("date");
  echo "\n";
  

?>
</pre>
</body>
</html>