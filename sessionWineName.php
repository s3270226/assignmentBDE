<?php
	session_start();
	require_once('twittersettup.php');
	echo '<a href="?submit=share">post to twitter</a>&nbsp;';
	if($_GET['submit']=='share'){
		postTwitter($_SESSION['wineName']);
	}
	
	echo '<a href="searchView.php">Go back to Search page</a></br>';
	if(!$_SESSION['wineName']){
		echo 'No wine name recorded</br>';
	}else{
		echo '<table>';
		echo '<tr><td><h3>Wine Name</h3></td></tr>';
		foreach($_SESSION['wineName'] as $key =>&$value)
		{
			echo '
			<tr>
				<td>'.$value.'</td>
			</tr>';
		}
		echo '</table>';
	}
?>