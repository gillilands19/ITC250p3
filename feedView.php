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


spl_autoload_register('MyAutoLoader::NamespaceLoader');//required to load SurveySez namespace objects
$config->metaRobots = 'no index, no follow';#never index survey pages

$feed=$type=$title=$feed=$url=0;

#dumpDie($url);
#we will need to call the feed value from #session
$id = $_GET['feedID']; #cast to string
// call array with feed data for xml obj

$url = null;
if(isset($id)){#proper data must be on querystring
    	# connection comes first in mysqli (improved) function
    
    //sql statment to select individual item  - FeedRSS. Inner join.
    $sql = "
    
    select FeedRSS
        from p3_feeds f
        inner join p3_Categories c
            on f.categoryID = c.categoryID
        where FeedID = " . $id;
    
    //  #IDB::conn() creates a shareable database connection via a singleton class
	$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
    #there are records: process - present data
    if(mysqli_num_rows($result) > 0) {#process each row
        while ($row = mysqli_fetch_assoc($result)) {
            $url = $row['FeedRSS'];
        }
    }
    @mysqli_free_result($result);


}else{
	myRedirect(VIRTUAL_PATH . "./P3/index.php");
}

#END CONFIG AREA ----------------------------------------------------------

get_header(); #defaults to theme header or header_inc.php
?>
<h3 class="text-center"><? echo $title; ?></h3>

<hr />

<?php
#dumpDie($url);

if(!empty($url))
{
    echo mk_feed($url);

}else{
	echo "Sorry, no such feed!";
}

get_footer(); #defaults to theme footer or footer_inc.php


