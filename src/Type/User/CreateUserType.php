<?php

namespace Prototype\GQL\Type\User;

use Prototype\GQL\Type\CustomType;
use GraphQL\Type\Definition\ObjectType;

class CreateUserType extends ObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					'getUser' => [
						'type' => CustomType::user(),
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