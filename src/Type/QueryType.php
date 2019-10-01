<?php

namespace Prototype\GQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\GraphQL;
use Prototype\GQL\Type\CustomType;

class QueryType extends ObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					'location' => [ 
						'type' => CustomType::location(),
						'description' => 'Get a single location',
						'args' => [
							'id' => [
								'type' => CustomType::int(),
								'defaultValue' => 1
							]
						],
						'resolve' => function($obj, $args) {
							$result = DB::getLocationFromID($args["id"]);
							return $result;
						}
					],

					'locations' => [
						'type' => CustomType::listOf(CustomType::location()),
						'description' => 'Get multiple locations',
						'args' => [
							'limit' => [
								'type' => CustomType::int(),
								'defaultValue' => 10
							]
						],
						'resolve' => function($obj, $args) {
							$result = DB::getLocations($args["limit"]);
							return $result;
						}
					],

					'user' => [
						'type' => CustomType::user(),
						'description' => 'Get a single user',
						'args' => [
							'id' => [
								'type' => CustomType::int(),
								'defaultValue' => 1
							]
						],
						'resolve' => function($obj, $args) {
							$result = DB::getUserFromID($args["id"]);
							return $result;
						}
					],

					'users' => [
						'type' => CustomType::listOf(CustomType::user()),
						'description' => 'Get multiple users',
						'args' => [
							'limit' => [
								'type' => CustomType::int(),
								'defaultValue' => 10
							]
						],
						'resolve' => function($obj, $args) {
							$result = DB::getUsers($args["limit"]);
							//var_dump($result);
							return $result;
						}
					]
				];
			}
		];
		parent::__construct($params);
	}
}