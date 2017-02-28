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

require './_inc/aarFeeds-inc.php'; #arrays containing feeds


#note aliasing to make admin name using concat
$sql = "
 SELECT CONCAT(a.FirstName, ' ', a.LastName) AdminName,

 s.SurveyID, s.Title, s.Description,  date_format(s.DateAdded, '%W %D %M %Y %H:%i') 'DateAdded'

 FROM wn17_surveys AS s, wn17_Admin AS a
 WHERE s.AdminID=a.AdminID
 ORDER BY s.DateAdded DESC
 ";

#Fills <title> tag. If left empty will default to $PageTitle in config_inc.php
$config->titleTag = 'P3: News Aggregator';

#Fills <meta> tags.  Currently we're adding to the existing meta tags in config_inc.php
$config->metaDescription = 'Seattle Central\'s ITC250 P3: News Aggregator ' . $config->metaDescription;


# END CONFIG AREA ----------------------------------------------------------

get_header(); #defaults to theme header or header_inc.php
?>
<h3 class="text-center">P3: Entertainment News Aggregator</h3>

<h4 class="text-center">News Syndication, Categorization and Caching </h4>
Build a PHP application providing categorized news pages from syndicated RSS feeds. These pages must come from feed data stored in a database.  The feed data must be cached on a session level so news pages generated during a current session are stored so the data does not need to be retrieved from the remote survey beyond the first page hit.
</p>


<?php
// pager added for future reference

	#reference images for pager
	$prev = '<img src="' . VIRTUAL_PATH . 'images/arrow_prev.gif" border="0" />';
	$next = '<img src="' . VIRTUAL_PATH . 'images/arrow_next.gif" border="0" />';

	# Create instance of new 'pager' class
	$myPager = new Pager(2,'',$prev,$next,'');
	$sql = $myPager->loadSQL($sql);  #load SQL, add offset

	# connection comes first in mysqli (improved) function
	$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

	if(mysqli_num_rows($result) > 0)
	{#records exist - process
		#process via foreach loop

		#process the feeds
		$feedID = 0;
		foreach($syfyFeed as $feed){
			# test feeds inputting
			// echo $feed . '<br />';

			#call feed
			echo mk_link($feed, $feedID);
			#echo gt_FeedLnk($feed, $str='');

			$feedID++;

		}	#END foreach
	} #END if





/*
	if($myPager->showTotal()==1){$itemz = "survey";}else{$itemz = "surveys";}  //deal with plural
	echo '<div align="center">We have ' . $myPager->showTotal() . ' ' . $itemz . '!</div>';

		// loop to apply to all initial feeds...
		while($row = mysqli_fetch_assoc($result))
		{# process each row

			//collect survey data to create loaded query link with
			$surveyID    = (int)$row['SurveyID'];
			$surveyTitle = dbOut($row['Title']);
			$surveyAdded = dbOut($row['DateAdded']);

			$fullName    = dbOut($row['AdminName']); // name made in db via concatination

			#$dateCreated = number_format((float)$row['Price'],2);

			echo '
				<tr>
					<td align="center">' . $surveyID . '</td>
					<td><a href="' . VIRTUAL_PATH . 'surveys/survey_view.php?id=' . $surveyID . '">' . $surveyTitle . '</a></td>
					<td>' . $fullName . '</td>
					<td>' . $surveyAdded . '</td>
				</tr>
			';
		}

		#END table
		echo '
			</tbody>
		</table>
		';

				echo $myPager->showNAV(); # show paging nav, only if enough records
	}else{#no records
		echo "<div align=center>What! No surveys?  There must be a mistake!!</div>";
	}
*/




	@mysqli_free_result($result);

	get_footer(); #defaults to theme footer or footer_inc.php

