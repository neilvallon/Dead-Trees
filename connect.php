<?php
if (!mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)) {
    die('Could not connect: ' . mysql_error());
}

if (!mysql_select_db("network")) {
	die('Could not connect: ' . mysql_error());
}
?>