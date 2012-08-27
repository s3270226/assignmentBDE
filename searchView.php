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
			$sql="SELECT * FROM region";
			echo '<select name="region">';
			$statement=$db->prepare($sql);
			$statement->execute();
			foreach($statement->fetchAll(PDO::FETCH_ASSOC) as $row){
				echo '<option value="' . htmlspecialchars($row['region_name']) . '">' 
				. $row['region_name'] . '</option>';
			}
			echo '</select>';
		
		//grape variety select
			echo '<br>Grape Variety:';		
			$sql="SELECT * FROM grape_variety";
			echo '<select name="grapeVariety">';
			echo '<Option value="All">All</Option>';
			$statement=$db->prepare($sql);
			$statement->execute();
			foreach($statement->fetchAll(PDO::FETCH_ASSOC) as $row){
				echo '<option value="' . htmlspecialchars($row['variety']) . '">' 
				. $row['variety'] . '</option>';
			}
			echo '</select>';
			
			echo '<br>Year';
			echo '<br>Lower bound:';
			$sql="SELECT year FROM wine GROUP BY year ORDER BY year";
			echo '<select name="yearLowerBound">';
			$statement=$db->prepare($sql);
			$statement->execute();
			foreach($statement->fetchAll(PDO::FETCH_ASSOC) as $row){
				echo '<option value="'.htmlspecialchars($row['year']).'">'
				.$row['year'].'</option>';
			}
			echo '</select>';
			
			echo 'Upper bound:';
			$sql="SELECT year FROM wine GROUP BY year ORDER BY year DESC";
			echo '<select name="yearUpperBound">';
			$statement=$db->prepare($sql);
			$statement->execute();
			foreach($statement->fetchAll(PDO::FETCH_ASSOC) as $row){
				echo '<option value="'.htmlspecialchars($row['year']).'">'
				.$row['year'].'</option>';
			}
			echo '</select>';
			$db=null;
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
