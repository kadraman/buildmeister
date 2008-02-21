<?php

# home page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 0;

include("include/header.php");
?>

<div id="toptitle">
<h2>Welcome to <i>The Buildmeister</i></h2>
</div>

<div id="introductory">
<table width="100%">
	<tbody>
		<tr>
			<td><img alt="[WelcomeMan]" hspace="10" src="images/WelcomeManS.jpg"
				vspace="30" /></td>
			<td>
			<p align="justify">In todays ever more competitive and globalized
			world, software development organizations are being squeezed with
			ever increasing time-to-market, cost reduction and compliance
			pressures. To address these pressures many are changing their release
			cycles - delivering frequently, with smaller sets of functionality.
			In parallel they are striving to make their overriding development
			lifecycle more transparent, visible and auditable. The build process
			sits at the heart of this effort. To improve, organzations will need
			to systematically revisit the build process, to understand its value
			and improve their practices.</p>
			<p align="justify">The aim of this site is therefore to educate and
			inform on any topic related to the build process and the tools that
			can be used to implement it. In particular, the aim of this site is
			to raise the technical capability and skill level of the implementer
			of the build process - <span style="FONT-STYLE: italic">The
			Buildmeister</span>.</p>
			<hr>
			<p align="justify">If you enjoy this site then please <a
				href="register.php">register</a> and contribute.</p>

			</td>

		</tr>

</table>
</div>

<div id="boxedtitle">The Buildmeister's Guide</div>
<table style="width: 100%;">
	<tbody>
		<tr>
			<td width="60%" style="vertical-align: top;">
			<div align="center">
			<p style="align: center"><img alt="[Buildmeister Books]"
                             src="images/buildmeisterbookslogo_small.gif"
                             vspace="5">
			</p>
			</div>
			<p>If you enjoy this site then you can help to keep it going by
			purchasing a copy of <a
				href="http://www.lulu.com/content/409652">The
			Buildmeister's Guide - Achieving Agile Software Delivery</a> - the book of this website, which contains a
			collection of the best articles and information from this site
			together with some significant and new unpublished content. Printed
			and electronic copies of this and other books in the <i>Buildmeister Books</i> series are available
			from&nbsp;<a href="http://stores.lulu.com/buildmeisterbooks">stores.lulu.com/buildmeisterbooks</a>.&nbsp;</p>
			<br/>
			</td>
			<td>
			<div align="center">
			<a href="http://www.lulu.com/content/409652">
            <img style="border: 0px;"
				alt="[The Buildmeister's Guide]"
				src="images/The_Buildmeisters_Guide_cover_small.jpg" hspace="5"
				vspace="5"></a><br>
			<div style="text-align: center;"><a
				href="http://www.lulu.com/content/409652"> <img
				src="http://www.lulu.com/services/buy_now_buttons/images/book_blue2.gif"
				alt="Buy now" border="0"></a></div>
			</div>
			</td>
			<td>
			<div align="center">
            <a href="http://www.lulu.com/commerce/index.php?fBuyContent=436259">
			<img style="border: 0px;"
				alt="[Apache Ant - The Buildmeister's Guide]"
				src="images/Apache_Ant_TBG_cover_small.jpg" hspace="5"
				vspace="5"></a><br>
			<div style="text-align: center;"><a
				href="http://www.lulu.com/commerce/index.php?fBuyContent=436259"> <img
				src="http://www.lulu.com/services/buy_now_buttons/images/book_blue2.gif"
				alt="Buy now" border="0"></a></div>
			</div>
			</td>
		</tr>
	</tbody>
</table>

<div id="boxedtitle">Selected Articles</div>
<?php
# fetch latest articles
$sql = "SELECT * from " . TBL_ARTICLES . " where active = 1 ORDER BY date_posted DESC LIMIT 5;";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);

if ($numrows != 0) {
    while ($row = mysql_fetch_assoc($result)) {
        echo "<div id='splitlist'><strong><a href='viewarticle.php?id=" . $row['id'] . "'>" . $row['title'] . "</a></strong><br/>"
        . $row['summary'] . "</div>";
    }
}

?>

<div id="dashed-spacer"></div>

<?php
include("include/footer.php");
?>
