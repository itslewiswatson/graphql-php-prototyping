<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\GraphQL;

// Input type
// To go to new file

// End

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

class MutationType extends ObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					''
				];
			}
		];
		parent::__construct($params);
	}
}