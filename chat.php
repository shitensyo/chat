<html>
<head>
	<title>Chat</title>
	<script type="text/javascript">

	</script>
</head>

<body>

<?php

$loginid = $_REQUEST["loginid"];
$password = $_REQUEST["password"];
	
//SQL connect
$dsn  = 'mysql:dbname=webchat;host=127.0.0.1';
$user = 'root';
$pw   = 'H@chiouji1';
$dbh = new PDO($dsn, $user, $pw);  //connect

//user get
$sql = "SELECT * FROM user WHERE loginid = '$loginid'";
$sth = $dbh->prepare($sql);        //SQLstand by
$sth->execute();              //run
$row = $sth->fetch();
$userid = $row["id"];
$dispname = $row["dispname"];
$loginpass = $row["password"];
$del_flag = $row["del_flag"];

//chat log get
$chatlog = [];
$sql = "SELECT * FROM chat";
$sth = $dbh->prepare($sql);        //SQLstand by
$sth->execute();              //run
while( ($data = $sth->fetch()) !== false )
{
	$chatlog[] = $data;
}	

//================id or password not input================
if(empty($loginid) || empty($password))
{
?>
	<font color="red">
	<h2>Error</h2>
	<p>Please input your id and password.</p>
	</font>
	<form action="name.php">
	<input type="submit" value="Back">
	</form>
<?php
}
//================not found id================
else if(empty($dispname))
{
?>
	<font color="red">
	<h2>Error</h2>
	<p>Not found id.</p>
	</font>
	<form action="name.php">
	<input type="submit" value="Back">
	</form>
<?php
}
//================id deleted================
else if($del_flag == true)
{
?>
	<font color="red">
	<h2>Error</h2>
	<p>Not found id.</p>
	</font>
	<form action="name.php">
	<input type="submit" value="Back">
	</form>
<?php
}
//================mistaken password================
else if($password != $loginpass)
{
?>
	<font color="red">
	<h2>Error</h2>
	<p>Mistaken password.</p>
	</font>
	<form action="name.php">
	<input type="submit" value="Back">
	</form>
<?php
}
//================chat================
else
{
//last login date update
$current_date = date('Y-m-d H:i:s');
$sql = "UPDATE user SET lastlogin_date = '$current_date' WHERE id = '$userid '";
$sth = $dbh->prepare($sql);
$sth->execute();

//writting comment
if(isset($_POST["submitbutton"]))
{
	$text = $_POST["textbox"];
	$sql = "INSERT INTO chat Values('$userid', '$dispname','$text','$current_date')";
	$sth = $dbh->prepare($sql);
	$sth->execute();
}
?>

	<!--show name-->
	<p><?php print $dispname; ?></p>
	
	<!--textbox-->
	<form method="post">
	<input type="hidden" name="username" value="<?php print $dispname;?>">
	<input type="text" name="textbox">
	<input type="submit" name="submitbutton" value="Write" >
	</form>
	
	<!--stamp button-->
	<input type="image" src="./res/01.png" width="32" height="32">
	<input type="image" src="./res/02.png" width="32" height="32">
	<input type="image" src="./res/03.png" width="32" height="32">
	<input type="image" src="./res/04.png" width="32" height="32">
	<input type="image" src="./res/05.png" width="32" height="32">
	
	<hr>
	
	<!--chat log-->	
	<?php 
		//=========show 15 new logs=========
		$count = count($chatlog);
		$maxCount = 15;
		
		for($i = 0; $i < $maxCount; $i++)
		{
			$j = $count - $i - 1;
			if($j >= 0)
			{
				$r = $chatlog[$j];
				print $r["dispname"].' '.$r["comment"].' ('.$r["date"].')';
	?>
	<br>
	<hr>
	<?php
			}
		}
		//=========show 15 new logs=========	
	?>
	
	<!--history-->	
	<a href="./chat_history.php" target="_blank">History</a>
	<!--logout-->	
	<input type="button" onclick="location.href='./name.php'"value="Logout">
<?php
}
?>

</body>

</html>



