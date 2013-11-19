window.addEvent('domready', function() {

    new FilterTable($('filterTable'), '_users.select.php', 'username',
        [
            {id: "username", caption: "Username", sortable: true, searchable: true},
            {id: "userlevel", caption: "User Level", sortable: true, searchable: false},
            {id: "firstname", caption: "First name", sortable: true, searchable: true},
            {id: "lastname", caption: "Last name", sortable: true, searchable: true},
            {id: "email", caption: "Email", sortable: true, searchable: true},
            {id: "active", caption: "Active", sortable: true, searchable: false}
        ],
        {
            addurl: "/pages/admin/users/add.php",
            editurl: "/pages/admin/users/edit.php",
            deleteurl: "/pages/admin/users/_user.delete.php"
        }
    );
		
});