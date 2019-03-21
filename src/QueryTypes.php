<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\GraphQL;

class QueryRegistry
{
	private static $queryUser;
	private static $queryLocation;
}

class UserType extends ObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					'userid' => [
						'type' => CustomTypes::int(),
						'resolve' => function($user) {
							return $user["userid"];
						}
					],
					'fname' => [
						'type' => CustomTypes::string(),
						'resolve' => function($user) {
							return $user["fname"];
						}
					],
					'sname' => [
						'type' => CustomTypes::string(),
						'resolve' => function($user) {
							return $user["sname"];
						}
					],
					'email' => [
						'type' => CustomTypes::string(),
						'resolve' => function($user) {
							return $user["email"];
						}
					],
					'locations' => [
						'type' => CustomTypes::listOf(CustomTypes::location())
					],
					'fullname' => [
						'type' => CustomTypes::string(),
						'resolve' => function($user) {
							return $user["fname"] . " " . $user["sname"];

						}
					]
				];
			}
		];
		parent::__construct($params);
	}
}

class LocationType extends ObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					'locationid' => [
						'type' => CustomTypes::int(),
						'resolve' => function($location) {
							return $location["locationid"];
						}
					],
					'lname' => [
						'type' => CustomTypes::string(),
						'resolve' => function($location) {
							return $location["lname"];
						}
					],
					'users' => [
						'type' => CustomTypes::listOf(CustomTypes::user()),
						'args' => [
							'limit' => [
								'type' => CustomTypes::int(),
								'description' => 'Limit users whomst are in location',
								'defaultValue' => 10
							]
						],
						'resolve' => function($location, $args, $context) {
							$users = json_decode($location["users"], true);
							$userMap = [];
							for ($i = 0; $i < count($users); $i++) {
								$user = DB::getUserFromID($users[$i]);
								$userMap[$i] = $user;
							}
							return $userMap;
						}
					]
				];
			}
		];
		parent::__construct($params);
	}
}

class QueryType extends ObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					'location' => [ 
						'type' => CustomTypes::location(),
						'description' => 'Get a single location',
						'args' => [
							'id' => [
								'type' => CustomTypes::int(),
								'defaultValue' => 1
							]
						],
						'resolve' => function($obj, $args) {
							$result = DB::getLocationFromID($args["id"]);
							return $result;
						}
					],

					'locations' => [
						'type' => CustomTypes::listOf(CustomTypes::location()),
						'description' => 'Get multiple locations',
						'args' => [
							'limit' => [
								'type' => CustomTypes::int(),
								'defaultValue' => 10
							]
						],
						'resolve' => function($obj, $args) {
							$result = DB::getLocations($args["limit"]);
							return $result;
						}
					],

					'user' => [
						'type' => CustomTypes::user(),
						'description' => 'Get a single user',
						'args' => [
							'id' => [
								'type' => CustomTypes::int(),
								'defaultValue' => 1
							]
						],
						'resolve' => function($obj, $args) {
							$result = DB::getUserFromID($args["id"]);
							return $result;
						}
					],

					'users' => [
						'type' => CustomTypes::listOf(CustomTypes::user()),
						'description' => 'Get multiple users',
						'args' => [
							'limit' => [
								'type' => CustomTypes::int(),
								'defaultValue' => 10
							]
						],
						'resolve' => function($obj, $args) {
							$result = DB::getUsers($args["limit"]);
							return $result;
						}
					]
				];
			}
		];
		parent::__construct($params);
	}
}