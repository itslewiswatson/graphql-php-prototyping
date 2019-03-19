<?php

require_once './vendor/autoload.php';
require_once './db.php';

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\GraphQL;

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

    public static function string()
    {
        return Type::string();
    }

    public static function listOf($type)
    {
        return Type::listOf($type);
    }
}

class UserType extends ObjectType
{
    public function __construct()
    {
        $params = [
            'fields' => function() {
                return [
                    'firstname' => [
                        'type' => CustomTypes::string()
                    ],
                    'lastname' => [
                        'type' => CustomTypes::string()
                    ],
                    'locations' => [
                        'type' => CustomTypes::listOf(CustomTypes::location())
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
                    'name' => [
                        'type' => CustomTypes::string()
                    ],
                    'users' => [
                        'type' => CustomTypes::listOf(CustomTypes::user())
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
                    ],
                    'user' => [
                        'type' => CustomTypes::user(),
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
