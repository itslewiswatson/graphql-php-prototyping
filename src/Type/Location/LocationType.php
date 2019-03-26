<?php

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