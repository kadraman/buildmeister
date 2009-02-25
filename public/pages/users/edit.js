window.addEvent('domready', function() {

	new FormValidator($('userEditForm'), "Successfully updated user information, redirecting to home page...",
		{
			redirect: true,
			redirectURL: config['site_prefix'] + "/pages/users/view.php"
		}
	);
	
});	
