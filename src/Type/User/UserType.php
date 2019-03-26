<?php

class UserType extends ObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					'userid' => [
						'type' => CustomTypes::int(),
						'resolve' => function($user) {
							return $user["userid"];
						}
					],
					'fname' => [
						'type' => CustomTypes::string(),
						'resolve' => function($user) {
							return $user["fname"];
						}
					],
					'sname' => [
						'type' => CustomTypes::string(),
						'resolve' => function($user) {
							return $user["sname"];
						}
					],
					'email' => [
						'type' => CustomTypes::string(),
						'resolve' => function($user) {
							return $user["email"];
						}
					],
					'locations' => [
						'type' => CustomTypes::listOf(CustomTypes::location())
					],
					'fullname' => [
						'type' => CustomTypes::string(),
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
