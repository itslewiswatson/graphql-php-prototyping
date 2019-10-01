<?php

require_once '../vendor/autoload.php';

use GraphQL\Error\Error;
use GraphQL\Error\InvariantViolation;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\GraphQL;

//use Prototype\GQL\Priv\Database;
///use Prototype\GQL\Type\MutationType;
//use Prototype\GQL\Type\QueryType;
//use Prototype\GQL\Type\CustomType;

class CustomType
{
	private static $hello;
	private static $goodbye;

	public static function hello()
	{
		return self::$hello ?: (self::$hello = new HelloType());
	}

	public static function goodbye()
	{
		return self::$goodbye ?: (self::$goodbye = new GoodbyeType());
	}
}

class HelloType extends ObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					'id' => [
						'type' => CustomType::int()
					],
					'goodbye' => [
						'type' => CustomType::goodbye(),
						'resolve' => [
							
						]
					],
				];
			}
		];
		parent::__construct($params);
	}
}

class GoodbyeType extends ObjectType
{
	public function __construct()
	{
		$params = [
			'fields' => function() {
				return [
					'id' => [
						'type' => CustomType::int()
					],
					'hello' => [
						'type' => CustomType::hello()
					],
				];
			}
		];
		parent::__construct($params);
	}
}

try {
	$schema = new Schema([
		'query' => (new HelloType()),
		//'mutation' => (new MutationType())
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
