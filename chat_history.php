<html>
<head>
	<title>Chat-History</title>
</head>
<body>

<h1>Chat History</h1>
	<button onclick="window.close()">Refresh</button>
	<br>

	<?php 
		$texts = [];
		$fp = fopen('chat_log.csv','r');
		while ( ($data = fgets($fp) ) !== false ) 
		{
			$data = rtrim($data);
		 	$buff = explode(',',$data);
		 	$texts[] = $buff;		
		}			
		$count = count($texts);
		
		for($i = 0; $i < $count; $i++)
		{
			for($j = 0; $j < 3; $j++)
			{
				print $texts[$i][$j] . " ";
			}
	?>
	<br>
	<hr>
	<?php
		}
	?>
	
	<button onclick="window.close()">Refresh</button>
	<button onclick="window.close()">Close</button>
</body>
</html>
