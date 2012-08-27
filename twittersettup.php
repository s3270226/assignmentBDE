<?php
require_once('twitteroauth.php');
require_once('OAuth.php');

define('KEY','kRNu2SdFBbjW0RrLDufKkg');
define('SECRET','uNcMkQcFa5KPOMOhXPlUqyNtbijHkhdVcXkbM8LQIo');


function postTwitter($wineList){

	$tweeter=new TwitterOAuth(KEY, SECRET, '782108300-hqouT63bsybeovKmQfXWSxf02qGq2dyU8lmuqsQe','FJhiSDmQpSz6k1abgHZrJQRBn2vgQB0BUB5xfhIzk');
	$twit = "wine found:";
	if(count($wineList)>0){
		foreach($wineList as $wineName)
		{
			$twit = $twit.', '.$wineName;
		}
	}else{
		$twit=$twit. "nothing found ";
	}
	$twit=(strlen($twit) > 135) ? substr($twit, 0, 135).'...' :$twit;
	
	$tweeter->post('statuses/update',array('status'=>"$twit"));
}
?>