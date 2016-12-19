<html>
<head>
	<title>Chat-History</title>
</head>
<body>

<?php
//SQL connect
$dsn  = 'mysql:dbname=webchat;host=127.0.0.1';
$user = 'root';
$pw   = 'H@chiouji1';
$dbh = new PDO($dsn, $user, $pw);  //connect

//chat log get
$chatlog = [];
$sql = "SELECT * FROM chat";
$sth = $dbh->prepare($sql);        //SQLstand by
$sth->execute();              //run
while( ($data = $sth->fetch()) !== false )
{
	$chatlog[] = $data;
}
?>

<h1>Chat History</h1>
	<button onclick="window.close()">Refresh</button>
	<br>

	<!--chat history-->
	<?php
		$texts = [];
		$count = count($chatlog);

		for($i = 0; $i < $count; $i++)
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
	?>
	
	<button onclick="window.close()">Refresh</button>
	<button onclick="window.close()">Close</button>
</body>
</html>
