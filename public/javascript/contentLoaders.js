/*
 * 
 *
 */

function loadHome() {
	var contentPane = dijit.byId("loadedContent");	
	contentPane.setHref("include/load_home.php");
}

function loadEntry() {
	var postid = loadEntry.arguments[0];
	var contentPane = dijit.byId("loadedContent");	
	contentPane.setHref("include/load_entry.php?id=" + postid);
}

function loadCategory() {
	var catid = loadCategory.arguments[0];
	var contentPane = dijit.byId("loadedContent");
	contentPane.setHref("include/load_category.php?id=" + catid);
}

function loadAccountAdmin() {
	var username = loadAccountAdmin.arguments[0];
	var contentPane = dijit.byId("loadedContent");
	//contentPane.setHref("include/load_category.php?id=" + catid);
}

function loadPostAdmin() {
	var username = loadPostAdmin.arguments[0];
	var contentPane = dijit.byId("loadedContent");
	//contentPane.setHref("include/load_category.php?id=" + catid);
}