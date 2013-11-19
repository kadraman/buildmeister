Example httpd-vhosts.conf:

NameVirtualHost *:80

<Directory "/Users/kevinalee/IdeaProjects/buildmeister/public/">
Allow From All
AllowOverride All
</Directory>
<VirtualHost *:80>
        ServerName "buildmeister.dev"
        ServerAlias "www.buildmeister.dev"
        DocumentRoot "/Users/kevinalee/IdeaProjects/buildmeister/public"
</VirtualHost>
