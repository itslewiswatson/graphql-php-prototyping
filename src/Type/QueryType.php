<?php

namespace Prototype\GQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\GraphQL;

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