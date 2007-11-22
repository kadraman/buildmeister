<?php

# home page is selected
session_register("SESS_NAVITEM");
$_SESSION['SESS_NAVITEM'] = 0;

include("include/header.php");
?>

<div id="toptitle"><h2>Welcome to <i>The Buildmeister</i></h2></div>

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

<div id="boxedtitle">Selected Articles</div>
<?php
# fetch latest articles
$sql = "SELECT * from " . TBL_ARTICLES . " where active = 1 ORDER BY date_posted DESC;";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);

if ($numrows != 0) {
    while ($row = mysql_fetch_assoc($result)) {
        echo "<div id='splitlist'><strong><a href='viewarticle.php?id=" . $row['id'] . "'>" . $row['title'] . "</a></strong><br/>"
		. $row['summary'] . "</div>";
    }
}   

?>

<?php
include("include/footer.php");
?>
