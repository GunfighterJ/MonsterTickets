<?php
include "config.php";

if(!loggedIn()){
	header('refresh: 3; url=login.php');
	echo "You must log in to view any tickets";
}
?>