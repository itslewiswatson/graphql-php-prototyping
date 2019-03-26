<?php

namespace Prototype\GQL\Priv;

$config = json_decode(file_get_contents("../.config"), true);

global $mysqli;
@$mysqli = new mysqli('localhost', $config["usr"], $config["passwd"], $config["db"], 3306);
if ($mysqli->connect_errno) {
    die("Nope, not today");
}

class DB
{
	public static function getUsers($limit = 10)
	{
		global $mysqli;
		$query = $mysqli->query("SELECT * FROM users LIMIT " . $limit);
		$result = $query->fetch_all(MYSQLI_ASSOC);
		return $result;
	}

	public static function getUserFromID($userid)
	{
		global $mysqli;
		$query = $mysqli->query("SELECT * FROM users WHERE userid = " . $userid);
		$result = $query->fetch_array();
		return $result;
	}

	public static function getLocations($limit = 10)
	{
		global $mysqli;
		$query = $mysqli->query("SELECT * FROM locations LIMIT " . $limit);
		$result = $query->fetch_all(MYSQLI_ASSOC);
		return $result;
	}

	public static function getLocationFromID($locationid)
	{
		global $mysqli;
		$query = $mysqli->query("SELECT * FROM locations WHERE locationid = " . $locationid);
		$result = $query->fetch_array();
		return $result;
	}
}