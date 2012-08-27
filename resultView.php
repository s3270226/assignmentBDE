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
		$region=$_GET["region"];
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
	if($minimumCost>$maximumCost && $minimumCost!="" && $maximumCost!=""){
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
		if(IsNullOrEmptyString($wineryName)){
			$wineryName="";
		}
		if($region=="All"){
			$region="";
		}
		if(IsNullOrEmptyString($minimumCost)){
			$minimumCost="";
		}

		if(IsNullOrEmptyString($maximumCost)){
			$maximumCost="";
		}

		if(IsNullOrEmptyString($minimumNumberOfWineInStock)){
			$minimumNumberOfWineInstock="";
		}
		if(IsNullOrEmptyString($minimumNumberOfWineOrdered)){
			$minimumNumberOfWineOrdered="";
		}
	}else{
		echo "BIG ERROR!! PLEASE GO BACK AND FIX YOUR INPUT IMMEDIATELY!!<br>";
		echo $inputError;
	}
	//end of query preparation
	
	if($validInput==true)
	{
		echo '<h1>Winestore ore ore ore!!!<h1>';
		
		$statement = $db->prepare("select * from final_print_with_order_view 
		where wine_name like :wineName
		and variety like :grapeVariety
		and year >= :yearLowerBound and year <= :yearUpperBound
		and winery_name like :wineryName
		and region_name like :region
		and (cost >= :costLowerBound or :costLowerBound='') and (cost <= :costUpperBound or :costUpperBound ='')
		and (on_hand >= :minimumNumberOfWineInStock or :minimumNumberOfWineInStock='') 
		and (amount_sold >= :minimumNumberOfWineOrdered or :minimumNumberOfWineOrdered='')
		");

		$statement->execute(array(':wineName' => '%'.$wineName.'%',
		':grapeVariety'=>'%'.$grapeVariety.'%',
		':yearLowerBound' => $yearLowerBound,
		':yearUpperBound' => $yearUpperBound,
		':wineryName' => '%'.$wineryName.'%',
		':region'=>'%'.$region.'%',
		':costLowerBound' => $minimumCost,
		':costUpperBound' => $maximumCost,
		':minimumNumberOfWineInStock'=>$minimumNumberOfWineInStock,
		':minimumNumberOfWineOrdered'=>$minimumNumberOfWineOrdered
		));
		//querry with wines that have order recorded
		
		$rowCount=0;
		echo '<br>';
		echo '<h3>Listing of wine with ordered recorded</h3>';
		
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
			foreach($statement->fetchAll(PDO::FETCH_ASSOC) as $row)
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
				$rowCount=$rowCount+1;
			}
			echo '</table>';
		if($rowCount==0){
			echo 'No Result found <br>';
		}
		
		//querry to get wines with no order yet
		
		$statement = $db->prepare("select * from final_print_no_order_view 
		where wine_name like :wineName
		and variety like :grapeVariety
		and year >= :yearLowerBound and year <= :yearUpperBound
		and winery_name like :wineryName
		and region_name like :region
		and (cost >= :costLowerBound or :costLowerBound='') and (cost <= :costUpperBound or :costUpperBound ='')
		and (on_hand >= :minimumNumberOfWineInStock or :minimumNumberOfWineInStock='') 
		");

		$statement->execute(array(':wineName' => '%'.$wineName.'%',
		':grapeVariety'=>'%'.$grapeVariety.'%',
		':yearLowerBound' => $yearLowerBound,
		':yearUpperBound' => $yearUpperBound,
		':wineryName' => '%'.$wineryName.'%',
		':region'=>'%'.$region.'%',
		':costLowerBound' => $minimumCost,
		':costUpperBound' => $maximumCost,
		':minimumNumberOfWineInStock'=>$minimumNumberOfWineInStock,
		));
		
		
		echo '<h3>Listing of wine that have no order recorded</h3>';
		

		$rowCount=0;
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
			
			foreach($statement->fetchAll(PDO::FETCH_ASSOC) as $row)
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
					<td>null</td>
					<td>null</td>
				</tr>';
				$rowCount=$rowCount+1;
			}
			echo '</table>';
		if($rowCount==0){
			echo 'No Result found <br>';
		}
	}
	$db=null;
?>
