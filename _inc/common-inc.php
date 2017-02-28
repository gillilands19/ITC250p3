<?php
//SEE: /include_0700/header_inc.php; Session started by header-inc.php

// make link to list page for specific feed
// used by index
function mk_link($feed, $feedID){

	//moved feed to main page calling to make function versitile/dynamic
	$xml = LoadFeed($feed);

	///git250-17q1/app/proj03newsfeed/feedView.php&feedType=syfy&feedID=0&feedTitle=firefly
	echo '<a href="./feedView.php?feedID=' . $feedID . '&feedType=syfy&feedTitle=' . $xml->channel->title .'">' . strtoupper($xml->channel->title) . '</a><br />';
}

// no comments?
function LoadCachedURL($url) {
	if(isset($_SESSION[$url]))
	{
		 return $_SESSION[$url];
	}
	$response = file_get_contents($url);
	$_SESSION[$url] = $response;
	return $response;
}

// no comments?
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













