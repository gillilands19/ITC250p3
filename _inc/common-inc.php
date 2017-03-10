<?php

//206 334 1192 Max
// datetime_diff use
//SEE: /include_0700/header_inc.php; Session started by header-inc.php

// make link to list page for specific feed
// used by index
function mk_link($feedURL, $feedID){

	//moved feed to main page calling to make function versitile/dynamic
	$xml = LoadFeed($feedURL);

	///git250-17q1/app/proj03newsfeed/feedView.php&feedType=syfy&feedID=0&feedTitle=firefly
	echo '<a class="btn btn-primary btn-sm" role="button" href="./feedView.php?feedID=' . $feedID . '">' 
        . strtoupper($xml->channel->title) . '</a><br />';
}

//$url receives the address
//the function LoadCacheURL uploads and returns the content of the URL
function LoadCachedURL($url) {
    //if the object is in the cache and not expirared, it will be used
    if(isset($_SESSION[$url]) && $_SESSION[$url][1] > time() - 60 * 10) { #[1] is time()
		 return $_SESSION[$url][0];#[0] is $response
	}
	$response = file_get_contents($url);
	$_SESSION[$url] = array($response, time());
    return $response;
}

//The function LoadFeed
//searches the content from the address and return to the content in xml format
function LoadFeed($url){
	$contents = LoadCachedURL($url);
	$xml = simplexml_load_string($contents);
	return $xml;
}


// Take url given, return xml feed expected
function mk_feed($url, $str=''){
	// take url given, return xml for interigation
	$xml = LoadFeed($url);

	//title of xml stream
	$str .= '<h1>' . $xml->channel->title . '</h1>';

	#buil each story, one by one.
	foreach($xml->channel->item as $story)
	{
		$str .= '<a href="' . $story->link . '">' . $story->title . '</a><br />';
		$str .= '<p>' . $story->description . '</p><br /><br />';
	}

	return $str ;

}













