<!DOCTYPE HTML PUBLIC
"-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html401/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Explore Wines in a Region</title>
</head>
<body bgcolor="white">
	<?php
	//connect to database;
		require_once("connect.php");
	?>
	<form action="resultView.php" method="GET">
		<br>Wine Name:
		<input type="text" name="wineName">
		<br>Winery Name:
		<input type="text" name="wineryName">
		<?php
		//region select
			echo '<br>Region:';
			$query = "SELECT * FROM region";
			$result = mysql_query($query, $dbconn);
			echo '<select name="Region">';
			while($row=mysql_fetch_array($result))
			{
				echo '<option value="' . htmlspecialchars($row['region_name']) . '">' 
				. $row['region_name'] . '</option>';
			}
			echo '</select>';
		
		//grape variety select
			echo '<br>Grape Variety:';
			$query = "SELECT * FROM grape_variety";
			$result = mysql_query($query, $dbconn);
			echo '<select name="grapeVariety">';
			echo '<Option value="All">All</Option>';
			while($row=mysql_fetch_array($result))
			{
				echo '<option value="' . htmlspecialchars($row['variety']) . '">' 
				. $row['variety'] . '</option>';
			}
			echo '</select>';

		//year select
			echo '<br>Year';
			echo '<br>Lower bound:';
			$query = "SELECT year FROM wine  group by year order by year";
			$result = mysql_query($query, $dbconn);
			echo '<select name="yearLowerBound">';
			while($row=mysql_fetch_array($result))
			{
				echo '<option value="' . htmlspecialchars($row['year']) . '">' 
				. $row['year'] . '</option>';
			}
			echo '</select>';
			
			$query = "SELECT year FROM wine group by year order by year desc";
			$result = mysql_query($query, $dbconn);
			echo 'Upper bound:';
			echo '<select name="yearUpperBound">';
			while($row=mysql_fetch_array($result))
			{
				echo '<option value="' . htmlspecialchars($row['year']) . '">' 
				. $row['year'] . '</option>';
			}
			echo '</select>';
		?>
		<br>Minimum number of wine in stock:
		<input type="text" name="minimumNumberOfWineInStock">
		<br>Minimum number of wine ordered:
		<input type="text" name="minimumNumberOfWineOrdered">
		<br>Minimum cost:
		<input type="text" name="minimumCost">
		<br>Maximum cost:
		<input type="text" name="maximumCost">
		<br><input type="submit" value="Search ^^">
	</form>
</body>
</html>