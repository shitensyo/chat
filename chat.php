<html>
<head>
	<title>Chat</title>
	<meta http-equiv="refresh" content="5" >
	<script type="text/javascript">

	</script>
</head>

<?php

$username = $_REQUEST["username"];


//名前が入力されていなければ、エラー画面へ移行
if(empty($username))
{
	header("Location: ./name_error.php");
}
//bodyの中身を実行
else
{

//書き込み用ボタンが押されている場合はログに追記
if(isset($_POST["submitbutton"]))
{
	$text = $_POST["textbox"];

	$fp = fopen('chat_log.csv', 'a');
	fwrite($fp, implode(",",
	[
		$username, $text ,"(".date('Y-m-d H:i:s').")"
	]));
	fwrite($fp,"\n");
	
	fclose($fp);
}
?>

<body>
	<p> <?php print $username; ?>	</p>
	
	<!--書き込む-->
	<form method="post">
	<input type="hidden" name="username" value="<?php print $username;?>">
	<input type="text" name="textbox">
	<input type="submit" name="submitbutton" value="Write" >
	</form>
	<hr>
	<!--書き込む-->

	<!--更新-->
	<br>
	<!--更新-->

	<?php 
		//=========最新15件のログを表示=========
		$texts = [];
		$fp = fopen('chat_log.csv','r');
		while ( ($data = fgets($fp) ) !== false ) 
		{
			$data = rtrim($data);
		 	$buff = explode(',',$data);
		 	$texts[] = $buff;		
		}			
		$count = count($texts);
		$maxCount = 15;
		
		for($i = 0; $i < $maxCount; $i++)
		{
			$r = $count - $i - 1;
			if($r >= 0)
			{
				for($j = 0; $j < 3; $j++)
				{
					print $texts[$r][$j] . " ";
				}
	?>
	<br>
	<hr>
	<?php
			}
		}
		//=========最新15件のログを表示=========
	?>
	
<?php
}
?>

	<a href="./chat_history.php" target="_blank">History</a>
	<input type="button" onclick="location.href='./name.php'"value="Logout">
</body>
</html>



