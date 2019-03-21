<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\GraphQL;

class MutationRegistry
{
	private static $createUser;
	private static $createLocation;

	public static function createUser()
	{
		return self::$createUser ?: (self::$createUser = new CreateUserType());
	}

	public static function createLocation()
	{
		return self::$createLocation ?: (self::$createLocation = new CreateLocationType());
	}
}

class CreateUserType extends ObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					'createUser' => [
						'args' => [
							'fname' => CustomType::string(),
							'sname' => CustomType::string(),
							'email' => CustomType::string(),
							'locations' => CustomType::listOf(CustomType::location())
						],
						'type' => CustomType::user()
					],
					'updateUser' => [
						//'args' => 
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
							'users' => CusomType::listOf(CustomType::user())
						]
					]
				];
			}
		];
		parent::__construct($params);
	}
}

class MutationType extends ObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					'createUser' => [
						'type' => MutationRegistry::createUser()
					],
					'createLocation' => [
						'type' => MutationRegistry::createLocation()
					]
				];
			}
		];
		parent::__construct($params);
	}
}