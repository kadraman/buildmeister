Advanced Login System Patch
System: Advanced Login System v0.02 Beta , Advanced Login System v0.03B Preview
Release Files: ALS v0.02 Beta/config.php,ALS v0.02 Beta/register.php,ALS v0.03 Beta Preview/config.php,ALS v0.03 Beta Preview/register.php
Release Date: 20/7/07

Status: VERY IMPORTANT - ALL USERS ARE ADVISED TO PATCH THEIR VERSION OF Advanced Login System

Description:
This is the first patch for Advanced Login System. It fixes a very important security bug in the script's register area. 

Bug Description:
When user registration is disabled, register.php will be disabled unless a admin logs in with the MySQL username and password to create a new user. However, unpatched versions of Advanced Login System allows any visitor to login, without having to enter the correct username and password. This patch fixes this problem.

File Description:
register.php - Fixes security bug
config.php -Tells update server your new script version

Installation:
Replace both the corresponding register.php and config.php with the one in the folder. Ensure that you are patching the correct version. If you are unsure of your script version, just check the original config.php.

Footnotes:
All ALS v0.02B users are also recommended to upgrade to v0.03 Beta Preview.

END
Wu Xiao Tian
Developer of Advanced Login System