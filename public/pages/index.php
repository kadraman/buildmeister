<?php

include_once("common.inc");
include_once("header.php");

?>

<div id="toptitle">
	<h2>Welcome to <i>The Buildmeister</i></h2>
</div>

<div id="introductory">
<table width="100%">
	<tbody>
		<tr>
			<td><img alt="[WelcomeMan]" hspace="10" 
				src="<?php echo SITE_PREFIX;?>/images/WelcomeManS.jpg"
				vspace="30" /></td>
			<td>
			<p>In todays ever more competitive and globalized
			world, software development organizations are being squeezed with
			ever increasing time-to-market, cost reduction and compliance
			pressures. To address these pressures many are changing their release
			cycles - delivering frequently, with smaller sets of functionality.
			In parallel they are striving to make their overriding development
			lifecycle more transparent, visible and auditable. The build process
			sits at the heart of this effort. To improve, organzations will need
			to systematically revisit the build process, to understand its value
			and improve their practices.</p>
			<p>The aim of this site is therefore to educate and
			inform on any topic related to the build process and the tools that
			can be used to implement it. In particular, the aim of this site is
			to raise the technical capability and skill level of the implementer
			of the build process - <i>The Buildmeister</i>.</p>
			<hr>
			<p align="justify">If you enjoy this site then please <a
				href="users/register.php">register</a> and contribute.</p>
			</td>

		</tr>

</table>
</div>

<div id="boxedtitle">The Buildmeister's Guide</div>
<table style="width: 100%;">
	<tbody>
		<tr>
			<td width="75%" style="vertical-align: top;">
			<div align="center"><img alt="[Buildmeister Books]"
				src="<?php echo SITE_PREFIX;?>/images/buildmeisterbookslogo_small.gif"></div>
			<p>If you enjoy this site then you can help keep it going by
			purchasing a copy of <a href="http://www.lulu.com/content/409652">The
			Buildmeister's Guide - Achieving Agile Software Delivery</a> - the
			book of this website, which contains a collection of the best
			articles and information from this site together with some
			significant and new unpublished content. A hardcopy version of the
			book is also available from <a
				href="http://www.lulu.com/items/volume_63/4152000/4152376/1/print/AgileSCMInTheEnterprise.pdf">stores.lulu.com/buildmeisterbooks</a>.&nbsp;</p>
			</td>
			<td>
			<div align="center"><a href="http://www.lulu.com/content/409652"> <img
				style="border: 0px;" alt="[The Buildmeister's Guide]"
				src="<?php echo SITE_PREFIX;?>/images/bmg.jpg" hspace="5" vspace="5"></a><br>
			</td>
		</tr>
	</tbody>
</table>

<div id="block">
	<div id='boxedtitle'>Latest Articles</div>
<?php
	// fetch latest articles
	$sql = "SELECT * from " . TBL_ARTICLES .
    	" where state = " . PUBLISHED_STATE . 
    	" ORDER BY date_posted DESC LIMIT 5;";
	if ($result = mysqli_query($database->getConnection(), $sql)) {
		if (mysqli_num_rows($result) != 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<div id='splitlist'><strong><a href='viewarticle.php?id=" . $row['id'] .
            		"'>" . $row['title'] . "</a></strong><br/>" . $row['summary'] . "</div>\n";
			}
		}
	}

?>
</div>

<?php 
include_once("footer.php");
?>
