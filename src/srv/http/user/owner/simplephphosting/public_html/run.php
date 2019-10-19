<?php
include "../SimplePhpHostingActions.class.php";

/*
$user_name = "hiperesp";
$project_name = "sandbox";
$email = "gabrielramos149@gmail.com";
$domain = "sand.box";

echo SimplePhpHostingUsers::createUser($user_name);
echo SimplePhpHostingUsers::createProject($user_name, $project_name);
echo SimplePhpHostingUsers::updateVirtualHosts($user_name, $project_name, $email, $domain);
/*
echo SimplePhpHostingUsers::removeProject($user_name, $project_name);
/*
echo SimplePhpHostingUsers::removeUser($user_name);
/*
print_r(SimplePhpHostingUsers::getAllUsers());
print_r(SimplePhpHostingUsers::getUserProjects($user_name));
print_r(SimplePhpHostingUsers::getAllProjects());
*/
echo SimplePhpHostingUsers::updateVirtualHosts("default",     "default"             , "gabrielramos149@gmail.com",          "default")."<br>\n";
echo SimplePhpHostingUsers::updateVirtualHosts("owner",       "simplephphosting"    , "gabrielramos149@gmail.com",          "simplephphosting.development")."<br>\n";
