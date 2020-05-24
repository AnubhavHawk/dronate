<?php
	if(isset($_REQUEST['city']))
	{
		include("db_connection.php");
		$don_sql = "SELECT * FROM donate_info WHERE city = '".$_REQUEST['city']."' OR city = 'undefined' AND timestampdiff(HOUR, entry_time, now() ) < 18 ORDER BY city ASC";
		$result = $conn->query($don_sql);
		while($row = $result->fetch_assoc())
		{
			$out[] = $row;
		}
		print_r(json_encode($out));
	}
	else
	{
		echo "Failed";
	}

?>