<?php

$config = json_decode(file_get_contents(".config"), true);

$mysqli = new mysqli('localhost', $config["usr"], $config["passwd"], $config["db"], 3306);
if ($mysqli->connect_errno) {
    die("Nope, not today");
}

