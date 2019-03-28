<?php

namespace Prototype\GQL\Type\Location;

use GraphQL\Type\Definition\ObjectType;
use Prototype\GQL\Type\CustomType;

class LocationType extends ObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					'locationid' => [
						'type' => CustomType::int(),
						'resolve' => function($location) {
							return $location["locationid"];
						}
					],
					'lname' => [
						'type' => CustomType::string(),
						'resolve' => function($location) {
							return $location["lname"];
						}
					],
					'users' => [
						'type' => CustomType::listOf(CustomType::user()),
						'args' => [
							'limit' => [
								'type' => CustomType::int(),
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