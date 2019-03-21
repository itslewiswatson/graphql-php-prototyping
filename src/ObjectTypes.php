<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\GraphQL;

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
							$u = [];
							for ($i = 0; $i < count($users); $i++) {
								$userid = $users[$i];
								$user = DB::getUserFromID($userid);
								$u[$i] = $user;
							}
							return $u;
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
					'user' => [
						'type' => CustomTypes::user(),
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
					]
				];
			}
		];
		parent::__construct($params);
	}
}