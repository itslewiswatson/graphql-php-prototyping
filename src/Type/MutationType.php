<?php

namespace Prototype\GQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\GraphQL;

class CreateUserType extends ObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					'getUser' => [
						'type' => CustomTypes::user(),
						//'resolve' => function() {
							//var_dump("i look like sid from toy story");
							//return "1oppa gangnam style";
						//}
						// This is the first point of resolution
						'resolve' => function() {
							return "aaa bbb";
						}
					],
					'updateUser' => [
						'type' => CustomTypes::user()
					]
				];
			}
		];
		parent::__construct($params);
	}
}

class CreateLocationType extends ObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					'createLocation' => [
						'args' => [
							'lname' => CustomTypes::string(),
							'users' => CustomTypes::listOf(CustomTypes::user())
						]
					]
				];
			}
		];
		//parent::__construct($params);
	}
}

class MutationType extends ObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					// Function -> mutation { `function` }
					'createUser' => [
						'type' => MutationRegistry::createUser(),
						'args' => [
							// Arguments -> mutation { function(`args`) }
							'fname' => ['type' => CustomTypes::string()],
							'sname' => ['type' => CustomTypes::string()],
							'email' => ['type' => CustomTypes::string()],
							'locations' => ['type' => CustomTypes::string()] //CustomTypes::listOf(CustomTypes::location())
						],
						// This one gets hit first?
						'resolve' => function() {
						//	var_dump("do the stanky leg");
							return "goo goo";
						}
						//'type' => new ObjectType(['name' => 'yung money', 'type' => Type::string()])
					]/*,
					'createLocation' => [
						//'type' => MutationRegistry::createLocation()
					]*/
				];
			}
		];
		parent::__construct($params);
	}
}