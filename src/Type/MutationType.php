<?php
/*
namespace Prototype\GQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\GraphQL;
use Prototype\GQL\Registry\MutationRegistry;
use Prototype\GQL\Type\CustomType;
use Prototype\GQL\Type\Location\CreateLocationType;
use Prototype\GQL\Type\User\CreateUserType;

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
							return "goo goo";
						}
					]
				];
			}
		];
		parent::__construct($params);
	}
}
*/