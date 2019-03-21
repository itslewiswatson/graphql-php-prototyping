<?php

use GraphQL\Error\Error;
use GraphQL\Error\InvariantViolation;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\GraphQL;

require_once './vendor/autoload.php';
require_once './src/Database.php';
require_once './src/ScalarTypes.php';
require_once './src/ObjectTypes.php';

class CustomTypes
{
	private static $user;
	private static $location;

	public static function user()
	{
		return self::$user ?: (self::$user = new UserType());
	}

	public static function location()
	{
		return self::$location ?: (self::$location = new LocationType());
	}
	
	public static function id($id)
	{
		if (isset($id)) {
			return ($id > 0) && (floor($id) === $id);
		}
		else {
			return Type::int();
		}
	}

	public static function string()
	{
		return Type::string();
	}
	
	public static function int()
	{
		return Type::int();
	}

	public static function listOf($type)
	{
		return Type::listOf($type);
	}
}

class EmailType extends ScalarType
{
	public function serialize($value)
	{
		return $value;
	}

	public function parseValue($value)
	{
		if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
			throw new Error("Cannot represent following value as email: " . Utils::printSafeJson($value));
		}
		return $value;
	}

	public function parseLiteral($valueNode, array $variables = null)
	{
		if (!$valueNode instanceof StringValueNode) {
			throw new Error('Query error: Can only parse strings got: ' . $valueNode->kind, [$valueNode]);
		}
		if (!filter_var($valueNode->value, FILTER_VALIDATE_EMAIL)) {
			throw new Error("Not a valid email", [$valueNode]);
		}
		return $valueNode->value;
	}
}

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

class LocationType extends ObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					'locationid' => [
						'type' => CustomTypes::int(),
						'resolve' => function($location) {
							return $location["locationid"];
						}
					],
					'lname' => [
						'type' => CustomTypes::string(),
						'resolve' => function($location) {
							return $location["lname"];
						}
					],
					'users' => [
						'type' => CustomTypes::listOf(CustomTypes::user()),
						'args' => [
							'limit' => [
								'type' => CustomTypes::int(),
								'description' => 'Limit users whomst are in location',
								'defaultValue' => 10
							]
						],
						'resolve' => function($location, $args, $context) {
							
							$users = json_decode($location["users"], true);
							$u = [];
							for ($i = 0; $i < count($users); $i++) {
								$userid = $users[$i];
								$user = DB::getUserFromID($userid);
								$u[$i] = $user;
							}
							return $u;
						}
					]
				];
			}
		];
		parent::__construct($params);
	}
}

class QueryType extends ObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					'location' => [ 
						'type' => CustomTypes::location(),
						'args' => [
							'id' => [
								'type' => CustomTypes::int(),
								'defaultValue' => 1
							]
						],
						'resolve' => function($obj, $args) {
							$result = DB::getLocationFromID($args["id"]);
							return $result;
						}
					],
					'user' => [
						'type' => CustomTypes::user(),
						'args' => [
							'id' => [
								'type' => CustomTypes::int(),
								'defaultValue' => 1
							]
						],
						'resolve' => function($obj, $args) {
							$result = DB::getUserFromID($args["id"]);
							return $result;
						}
					]
				];
			}
		];
		parent::__construct($params);
	}
}

try {
	$schema = new Schema([
		'query' => (new QueryType())
	]);

	$rawInput = file_get_contents('php://input');
	$input = json_decode($rawInput, true);
	$query = $input['query'];
	$variableValues = isset($input['variables']) ? $input['variables'] : null;


	$result = GraphQL::executeQuery($schema, $query, null, null, $variableValues);
	$output = $result->toArray();
} catch (\Exception $e) {
	$output = [
		'error' => [
			'message' => $e->getMessage()
		]
	];
}
header('Content-Type: application/json; charset=UTF-8');
echo json_encode($output);
