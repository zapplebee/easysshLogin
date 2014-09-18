<!DOCTYPE html>
<html>
<head>
<title>easysshLogin Demo</title>
</head>
<body>
<h1>easysshLogin Demo</h1>
<h2>Set your server and user details.</h2>
<form action="" method="POST">
<pre>
  $sshServer = array(
    "address" => <input type="text" name="address" value="<?php if(isset($_POST['address'])){echo $_POST['address'];}?>" placeholder="Your Server Address">, <span style="color:red"></span>
    "port"    => <input type="text" name="port" value="<?php if(isset($_POST['port'])){echo $_POST['port'];}?>" placeholder="Your Server Port">,
    "secret"  => <input type="password" name="secret" value="<?php if(isset($_POST['secret'])){echo $_POST['secret'];}?>" placeholder="An encryption key">,
  );
  
  $credentials = array(
    "user"    => <input type="text" name="user" value="<?php if(isset($_POST['user'])){echo $_POST['user'];}?>" placeholder="Your Username">, <span style="color:red">// Must fit the regex [^A-Za-z0-9\._-], cannot start with "-", cannot be longer than 8 characters.</span>
    "pass"    => <input type="password" name="pass" value="<?php if(isset($_POST['pass'])){echo $_POST['pass'];}?>" placeholder="Your Password">, <span style="color:red">// Must fit the regex [\n\t\r]</span>
    
   );
</pre>
<input type="submit" value="Submit">
</form>

<?php
include('classes.php');

 if(!isset($_POST['address']) || !isset($_POST['port']) || !isset($_POST['secret']) || !isset($_POST['user']) || !isset($_POST['pass'])){
 echo "</body></html>";
 exit;
 }

  $user = new easysshLogin($_POST['address'],$_POST['port'],$_POST['secret']);



?>
<h2>The easysshLogin object public attributes and functions</h2>

<h3>$user->login($user,$pass)</h3>
<p>Returns a boolean value indicating the login success or failure. This must be executed first.</p> 
<pre>
echo $user->login("username","password");

<b>Output:</b>
<?php echo $user->login($_POST['user'],$_POST['pass']);?>
</pre>
<hr>


<h3>$conn = $user->sshConnection()</h3>
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

<h3>$conn = $user->sftpConnection()</h3>
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

<h3>$user->username</h3>
<p>Returns the username</p>
<pre>
echo $user->username;

<b>Output:</b>
<?php echo $user->username;?></pre>
<hr>

<h3>$user->errors</h3>
<p>Returns an array of errors</p>
<pre>
print_r($user->errors);

<b>Output</b>
<?php print_r($user->errors);?></pre>


</body>
</html>