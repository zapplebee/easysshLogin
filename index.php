<!DOCTYPE html>
<html>
<head>
<title>easysshLogin Demo</title>
</head>
<body>
<h1>easysshLogin Demo</h1>
<h3>Set your server details & test cases.</h3>
<pre>
  $sshServer = array(
    "address" => "YOUR SERVER ADDRESS",
    "port"    => "YOUR SERVER PORT",
    "secret"  => "YOUR SECRET ENCRYPTION PHRASE",
  );
  
  $testCase = array("user","pass");
</pre>
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


  $user = new easysshLogin($sshServer);

 // $user->login($testCase[0],$testCase[1]);
 // $conn = $user->sshConnection();
 // echo $conn->exec("date");
 // echo "\n";
  

?>
</pre>
<h3>The easysshLogin object public attributes and functions</h3>

<h4>$user->login($user,$pass)</h4>
<p>Returns a boolean value indicating the login success or failure. This must be executed first.</p> 
<pre>
echo $user->login($testCase[0],$testCase[1]);

<b>Output:</b>
<?php echo $user->login($testCase[0],$testCase[1]);?>
</pre>
<hr>


<h4>$conn = $user->sshConnection()</h4>
<p>Returns a logged in phpseclib Net_SSH object</p>
<pre>
$conn = $user->sshConnection();
echo $conn->exec("date");

<b>Output:</b>
<?php
$conn = $user->sshConnection();
echo $conn->exec("date");
?>
</pre>
<hr>

<h4>$conn = $user->sftpConnection()</h4>
<p>Returns a logged in phpseclib Net_SFTP object</p>
<pre>
$conn = $user->sftpConnection();
print_r($conn->nlist("."));

<b>Output:</b>
<?php
$conn = $user->sftpConnection();
print_r($conn->nlist("."));
?>
</pre>
<hr>

<h4>$user->username</h4>
<p>Returns the username</p>
<pre>
echo $user->username;

<b>Output:</b>
<?php echo $user->username;?></pre>
<hr>

<h4>$user->errors</h4>
<p>Returns an array of errors</p>
<pre>
print_r($user->errors);

<b>Output</b>
<?php print_r($user->errors);?></pre>


</body>
</html>