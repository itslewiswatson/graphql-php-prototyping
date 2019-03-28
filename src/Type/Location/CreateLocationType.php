<?php

namespace Prototype\GQL\Type\Location;

use Prototype\GQL\Type\CustomType;
use GraphQL\Type\Definition\ObjectType;

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
		parent::__construct($params);
	}
}
