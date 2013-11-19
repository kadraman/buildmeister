window.addEvent('domready', function() {

    new FormValidator($('userEditForm'), "Successfully updated user information, redirecting to user administration...",
        {
            redirect: true,
            redirectURL: "/pages/admin/users/"
        }
    );

    // go back to the article
    $('cancel').addEvent('click', function(e) {
        e.preventDefault();
        new StickyWinModal({
            content: StickyWin.ui('Cancel changes',
                "Are you sure you want to cancel, any changes you have not saved will be lost?", {
                    width: '400px',
                    buttons: [
                        {
                            text: 'Yes',
                            onClick: function() {
                                window.location = "/pages/admin/users";
                            }
                        },
                        {
                            text: 'No',
                            onClick: function() {
                                // ignore
                            }
                        }
                    ]
                })
        });
    });

});	