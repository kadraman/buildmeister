<?php

include_once("common.inc");
include_once("header.inc");

// get site information 
$site_info = $database->getSiteInfo();
	
?>

<div id="toptitle">
	<h2>Welcome to <i><?php echo $site_info['title']; ?></i></h2>
</div>

<div id="block">
<?php echo $site_info['home_page_content'];?>
</div>

<?php

/**
* word-sensitive substring function with html tags awareness
* @param text The text to cut
* @param len The maximum length of the cut string
* @returns string
**/
function substrws( $text, $len=180 ) {
    if( (strlen($text) > $len) ) {
        $whitespaceposition = strpos($text," ",$len)-1;
        if( $whitespaceposition > 0 )
            $text = substr($text, 0, ($whitespaceposition+1));
        // close unclosed html tags
        if( preg_match_all("|<([a-zA-Z]+)>|",$text,$aBuffer) ) {
            if( !empty($aBuffer[1]) ) {
                preg_match_all("|</([a-zA-Z]+)>|",$text,$aBuffer2);
                if( count($aBuffer[1]) != count($aBuffer2[1]) ) {
                    foreach( $aBuffer[1] as $index => $tag ) {
                        if( empty($aBuffer2[1][$index]) || $aBuffer2[1][$index] != $tag)
                            $text .= '</'.$tag.'>';
                    }
                }
            }
        }
    }
    return $text;
} 

// show/hide latest article
if ($site_info['show_latest_article']) {
	echo "<div id='block'>\n";	
	// fetch latest articles
	$sql = "SELECT title, summary, content, posted_by, DATE_FORMAT(date_posted, \"%m-%y\")"
    	. " as newdate from " . TBL_ARTICLES 
		. " where state = " . PUBLISHED_STATE
    	. " ORDER BY date_posted DESC LIMIT 1;";
	if ($result = mysqli_query($database->getConnection(), $sql)) {
		if (mysqli_num_rows($result) != 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$atitle = strtolower(str_replace(" ", "_", $row['title']));
				echo "<table><tr><td width='50%'>";
				echo "<div id='boxedtitle'>" . substrws($row['title'], 40) . " ...</div>";
				$html = substrws($row['content'], 1000);
				echo htmlspecialchars_decode($html . " ... ");
				echo "<a href='/articles/" . $atitle . "'>Read more</a>";
				echo "</td>";
				echo "<td><img src='/images/bmg.jpg'></td></tr></table>";
			}
		}
		mysqli_free_result($result);
	}
	echo "</div>\n";
}

// show/hide recent articles
if ($site_info['show_recent_articles']) {
	echo "<div id='block'>\n";
	echo "<div id='boxedtitle'>Recently Added Articles</div>";
	// fetch latest articles
	$sql = "SELECT title, summary, DATE_FORMAT(date_posted, \"%m-%y\")"
    	. " as newdate from " . TBL_ARTICLES 
		. " where state = " . PUBLISHED_STATE
    	. " ORDER BY date_posted DESC LIMIT 5;";
	if ($result = mysqli_query($database->getConnection(), $sql)) {
		if (mysqli_num_rows($result) != 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$atitle = strtolower(str_replace(" ", "_", $row['title']));
				echo "<div id='splitlist'><strong><a href='"
					. "/articles/" . $atitle . "'>"
					. $row['title'] . "</a></strong>"
					. " (" . $row['newdate'] . ")<br/>" 
					. $row['summary'] . "</div>\n";
			}
		}
		mysqli_free_result($result);
	}
	echo "</div>\n";
}

// show/hide most popular articles
if ($site_info['show_popular_articles']) {
	echo "<div id='block'>\n";
	echo "<div id='boxedtitle'>Popular Articles</div>";
	// select articles with most views
	$sql = "SELECT * from " . TBL_ARTICLES 
		. " where state = " . PUBLISHED_STATE
    	. " ORDER BY views DESC LIMIT 5;";
	if ($result = mysqli_query($database->getConnection(), $sql)) {
		if (mysqli_num_rows($result) != 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$atitle = strtolower(str_replace(" ", "_", $row['title']));
				echo "<div id='splitlist'><strong><a href='"
					. "/articles/" . $atitle . "'>"
					. $row['title'] . "</a></strong> ("
					. $row['views'] . " views)<br/>" . $row['summary'] . "</div>\n";
			}
		}
		mysqli_free_result($result);
	}
	echo "</div>\n";
}

// show/hide recent comments block	
if ($site_info['show_recent_comments'] == "1") {
	echo "<div id='block'>\n";
	echo "<div id='boxedtitle'>Recent Comments</div>";
    // select recent comments
	$sql = "SELECT * from " . TBL_ARTCOM 
		. " where state = " . COMMENT_ACTIVE_STATE
    	. " ORDER BY date_posted DESC LIMIT 5;";
	if ($result = mysqli_query($database->getConnection(), $sql)) {
		if (mysqli_num_rows($result) != 0) {
			$current_row = 0;
			while ($row = mysqli_fetch_assoc($result)) {
				$atitle = strtolower(str_replace(" ", "_", $database->getArticleTitle($row['art_id'])));
				echo "<div id='splitlist'>";
				echo "<div class='comment'>";
				echo "<b>" . $row['posted_by'] . "</b> on <a href='"
					. "/articles/" . $atitle . "'>"
					. $database->getArticleTitle($row['art_id'])
					. "</a>:<br/>";
				echo htmlspecialchars_decode($row['comment']);
				echo "</div>";
				echo "</div>\n";
			}
		}
		mysqli_free_result($result);
	}
	echo "</div>\n";
}

include_once("footer.inc");
?>