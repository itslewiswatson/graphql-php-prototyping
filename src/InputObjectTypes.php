<?php


use GraphQL\Type\Definition\InputObjectType;
use GraphQL\GraphQL;

class CreateUserInputType extends InputObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					'fname' => [
						'type' => CustomType::string(),
						'description' => 'A user\'\s first name'
					],
					'sname' => [
						'type' => CustomType::string(),
						'description' => 'A user\'\s surname'
					],
					'email' => [
						'type' => CustomType::string(),
						'description' => 'A user\'\s email address'
					],
					'location' => [
						'type' => CustomType::listOf(CustomType::location()),
						'description' => 'A list containing locations a user is part of',
						'defaultValue' => [1]
					]
				];
			}
		];
		parent::__construct($params);
	}
}