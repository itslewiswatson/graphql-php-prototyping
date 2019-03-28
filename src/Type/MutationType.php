<?php

namespace Prototype\GQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\GraphQL;
use Prototype\GQL\Registry\MutationRegistry;
use Prototype\GQL\Type\CustomType;

class CreateUserType extends ObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					'getUser' => [
						'type' => CustomType::user(),
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
						'type' => CustomType::user()
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
							'lname' => CustomType::string(),
							'users' => CustomType::listOf(CustomType::user())
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
							'fname' => ['type' => CustomType::string()],
							'sname' => ['type' => CustomType::string()],
							'email' => ['type' => CustomType::string()],
							'locations' => ['type' => CustomType::string()] //CustomType::listOf(CustomType::location())
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