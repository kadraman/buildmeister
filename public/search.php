<?php

include("include/header.php");

echo"<div width='700px' align=\"center\">\n";
echo "\n<!-- Google Search Result Snippet Begins -->\n";
echo "<div id=\"googleSearchUnitIframe\"></div>\n";
echo "<script type=\"text/javascript\">\n";
echo "   var googleSearchIframeName = \"googleSearchUnitIframe\";\n";
echo "   var googleSearchFrameWidth = 700;\n";
echo "   var googleSearchFrameborder = 0 ;\n";
echo "   var googleSearchDomain = \"www.google.com\";\n";
echo "</script>\n";
echo "<script type=\"text/javascript\"\n";
echo "         src=\"http://www.google.com/afsonline/show_afs_search.js\">\n";
echo "</script>\n";
echo "<!-- Google Search Result Snippet Ends -->\n";
echo "</div>";

include("include/footer.php");

?>
