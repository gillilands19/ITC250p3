<?php




/**
 * Feedview.php, based of list_view.php is a view page listing selected feed.
 *
 * Objects in this version are the Survey, Question & Answer objects
 *
 * @package SurveySez
 * @author William Newman
 * @version 2.12 2015/06/04
 * @link http://newmanix.com/
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @see Question.php
 * @see Answer.php
 * @see Response.php
 * @see Choice.php
 */



require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db
require './_inc/common-inc.php'; #provides configuration, pathing, error handling, db
require './_inc/aarFeeds-inc.php'; #arrays containing feeds


spl_autoload_register('MyAutoLoader::NamespaceLoader');//required to load SurveySez namespace objects
$config->metaRobots = 'no index, no follow';#never index survey pages

$feed=$type=$title=$feed=$url=0;

#dumpDie($url);
#we will need to call the feed value from #session
$id = $_GET['feedID']; #cast to string
$type  = $_GET['feedType'];
$title = $_GET['feedTitle'];
// call array with feed data for xml obj

# check variable valid? If false redirect back
if(isset($id) && isset($type)){#proper data must be on querystring

	switch ($type) {
		case 'drama':
				$url = $dramaFeed[$id];
				break;
		case 'fantasy':
				$url = $fantasyFeed[$id];
				break;
		case 'horror':
				$url = $horrorFeed[$id];
				break;
		case 'syfy':
				$url = $syfyFeed[$id];
				break;

		default:
				"Sorry, newsfeed unavailable";
	}
}else{
	myRedirect(VIRTUAL_PATH . "./proj03newsfeed/index.php");
}


#END CONFIG AREA ----------------------------------------------------------

get_header(); #defaults to theme header or header_inc.php
?>
<h3 class="text-center"><? echo $title; ?></h3>

<hr />

<?php
#dumpDie($url);

if(!empty($url))
{ #call obj build feed
	#dumpDie($url);
	#gt_FeedLnk($url);
	echo 'URL GIVEN :: ' . $url . '<br /><br />';

	echo mk_feed($url);

}else{
	echo "Sorry, no such feed!";
}

get_footer(); #defaults to theme footer or footer_inc.php


