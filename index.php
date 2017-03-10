<?php
/**
 * based of Demo_list.php, along with demo_view_pager.php
 * creates a list/view newsfeed experience.
 *
 *
 *
 * @package newsFeed
 * @author Lillian Haas <lilihaas29@gmail.com>, Max Steinmetz <monkeework@gmail.com>
 * @version 0.0.1 1702-27
 * @link http://www.monkeework.com/itc250/app/proj03
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see index.php
 * @see viewNews.php
 * @todo none
 */


require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db
require './_inc/common-inc.php'; #provides configuration, pathing, error handling, db


#Fills <title> tag. If left empty will default to $PageTitle in config_inc.php
$config->titleTag = 'P3: News Aggregator';

#Fills <meta> tags.  Currently we're adding to the existing meta tags in config_inc.php
$config->metaDescription = 'Seattle Central\'s ITC250 P3: News Aggregator ' . $config->metaDescription;


# END CONFIG AREA ----------------------------------------------------------

get_header(); #defaults to theme header or header_inc.php
?>
<h3 class="text-center">P3: Entertainment News Aggregator</h3>

<h4 class="text-center">News Syndication, Categorization and Caching </h4>
<p>Build a PHP application providing categorized news pages from syndicated RSS feeds. These pages must come from feed data stored in a database.  The feed data must be cached on a session level so news pages generated during a current session are stored so the data does not need to be retrieved from the remote survey beyond the first page hit.
</p>


<?php
  //sql statment to select individual item - categoryID and Category Title.
    $sql = "
        select
            CategoryID,
            CategoryTitle
        from
            p3_Categories
    ";
    #IDB::conn() creates a shareable database connection via a singleton class
	$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
    #there are records: process - present data
    if(mysqli_num_rows($result) > 0) {# process each row
        while ($row = mysqli_fetch_assoc($result)) {# pull data from associative array
          echo '<a class="btn btn-primary" role="button" href="./category_view.php?categoryID=' . $row['CategoryID'] . '">'
        . $row['CategoryTitle'] . '</a>&nbsp;';
        }
    }
    @mysqli_free_result($result);





	get_footer(); #defaults to theme footer or footer_inc.php

