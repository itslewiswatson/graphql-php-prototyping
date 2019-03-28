<?php

namespace Prototype\GQL\Type\User;

use GraphQL\Type\Definition\ObjectType;
use Prototype\GQL\Type\CustomType;

class UserType extends ObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					'userid' => [
						'type' => CustomType::int(),
						'resolve' => function($user) {
							return $user["userid"];
						}
					],
					'fname' => [
						'type' => CustomType::string(),
						'resolve' => function($user) {
							return $user["fname"];
						}
					],
					'sname' => [
						'type' => CustomType::string(),
						'resolve' => function($user) {
							return $user["sname"];
						}
					],
					'email' => [
						'type' => CustomType::string(),
						'resolve' => function($user) {
							return $user["email"];
						}
					],
					'locations' => [
						'type' => CustomType::listOf(CustomType::location())
					],
					'fullname' => [
						'type' => CustomType::string(),
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
