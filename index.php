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
require_once './src/CustomTypes.php';
require_once './src/ScalarTypes.php';
require_once './src/ObjectTypes.php';

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
