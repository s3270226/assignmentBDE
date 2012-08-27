<?php 
require_once("connect.php");
?>

<?php
	//function declaration
		function IsNullOrEmptyString($question){
			return (!isset($question) || trim($question)==='');
		}
	//end of function declaration	
	
	//variable assign
		$wineName=$_GET["wineName"];
		$grapeVariety=$_GET["grapeVariety"];
		$yearLowerBound=$_GET["yearLowerBound"];
		$yearUpperBound=$_GET["yearUpperBound"];
		$wineryName=$_GET["wineryName"];
		$region=$_GET["Region"];
		$minimumCost=$_GET["minimumCost"];
		$maximumCost=$_GET["maximumCost"];
		$minimumNumberOfWineInStock=$_GET["minimumNumberOfWineInStock"];
		$minimumNumberOfWineOrdered=$_GET["minimumNumberOfWineOrdered"];
		
		$validInput=true;
		$inputError;
	//end of variable assign
		
	//input validation
		if($yearLowerBound>$yearUpperBound){
			$inputError= 'Year lower bound should be less than or equal to year upper bound <br>';
			$validInput=false;
		}
		if($minimumCost>$maximumCost){
			$inputError.='Minimum cost should be less than or equal to maximum cost<br>';
			$validInput=false;
		}
	//end of input validation
		
	if($validInput==true)
	{
	//query preparation
		if(IsNullOrEmptyString($wineName)){
			$wineName="";
		}
		if($grapeVariety=="All"){
			$grapeVariety="";
		}
		if($region=="All"){
			$region="";
		}
		if(IsNullOrEmptyString($wineryName)){
			$wineryName="";
		}
		if(IsNullOrEmptyString($minimumCost)){
			$minimumCostCondition="";
		}else{
			$minimumCostCondition=" and cost >= {$minimumCost}";
		}

		if(IsNullOrEmptyString($maximumCost)){
			$maximumCostCondition="";
		}else{
			$maximumCostCondition=" and cost <= {$maximumCost}";
		}

		if(IsNullOrEmptyString($minimumNumberOfWineInStock)){
			$minimumNumberOfWineInstockCondition="";
		}else{
			$minimumNumberOfWineInstockCondition=" and on_hand >= {$minimumNumberOfWineInStock}";
		}
		if(IsNullOrEmptyString($minimumNumberOfWineOrdered)){
			$minimumNumberOfWineOrderedCondition="";
		}else{
			$minimumNumberOfWineOrderedCondition=" and amount_sold >= {$minimumNumberOfWineOrdered}";
		}
	}else{
		echo "BIG ERROR!! PLEASE GO BACK AND FIX YOUR INPUT!!<br>";
		echo $inputError;
	}
	//end of query preparation
	
	if($validInput==true)
	{
		echo '<h1>Winestore ore ore ore!!!<h1>';
		//querry with wines that have order recorded
		$query = "select * from final_print_with_order_view 
		where wine_name like '%{$wineName}%' 
		and variety like '%{$grapeVariety}%'
		and year >= {$yearLowerBound} and year <= {$yearUpperBound}
		and winery_name like '%{$wineryName}%'
		and region_name like '%{$region}%'
		{$minimumCostCondition} {$maximumCostCondition}
		{$minimumNumberOfWineInstockCondition}
		{$minimumNumberOfWineOrderedCondition}
		";
		
		//echo $query;
		echo '<br>';
		echo '<h3>Listing of wine with ordered recorded</h3>';
		
		$result = mysql_query($query, $dbconn);
		
		if(mysql_num_rows($result)>0)
		{
			echo '
			<table border="1">
			<tr>
				<td>wine id</td>
				<td>wine name</td>
				<td>grape variety</td>
				<td>year</td>
				<td>winery name</td>
				<td>region name</td>
				<td>cost</td>
				<td>on hand</td>
				<td>amount sold</td>
				<td>revenue</td>
			</tr>';
			while($row=mysql_fetch_array($result))
			{
				echo '
				<tr>
					<td>'.$row['wine_id'].'</td>
					<td>'.$row['wine_name'].'</td>
					<td>'.$row['variety'].'</td>
					<td>'.$row['year'].'</td>
					<td>'.$row['winery_name'].'</td>
					<td>'.$row['region_name'].'</td>
					<td>'.$row['cost'].'</td>
					<td>'.$row['on_hand'].'</td>
					<td>'.$row['amount_sold'].'</td>
					<td>'.$row['revenue'].'</td>
				</tr>';
			}
			echo '</table>';
		}else{
			echo 'no result found';
		}
		
	//querry to get wines with no order yet
		$query = "select * from final_print_no_order_view 
		where wine_name like '%{$wineName}%' 
		and variety like '%{$grapeVariety}%'
		and year >= {$yearLowerBound} and year <= {$yearUpperBound}
		and winery_name like '%{$wineryName}%'
		and region_name like '%{$region}%'
		{$minimumCostCondition} {$maximumCostCondition}
		{$minimumNumberOfWineInstockCondition}
		";
		echo '<h3>Listing of wine that have no order recorded</h3>';
		
		//echo $query . '<br>';

		$result = mysql_query($query, $dbconn);
		if(mysql_num_rows($result)>0)
		{
			echo '
			<table border="1">
			<tr>
				<td>wine id</td>
				<td>wine name</td>
				<td>grape variety</td>
				<td>year</td>
				<td>winery name</td>
				<td>region name</td>
				<td>cost</td>
				<td>on hand</td>
			</tr>';
			
			while($row=mysql_fetch_array($result))
			{
				echo '
				<tr>
					<td>'.$row['wine_id'].'</td>
					<td>'.$row['wine_name'].'</td>
					<td>'.$row['variety'].'</td>
					<td>'.$row['year'].'</td>
					<td>'.$row['winery_name'].'</td>
					<td>'.$row['region_name'].'</td>
					<td>'.$row['cost'].'</td>
					<td>'.$row['on_hand'].'</td>
				</tr>';
			}
			echo '</table>';
		}else{
			echo 'no result found';
		}
	}
?>



