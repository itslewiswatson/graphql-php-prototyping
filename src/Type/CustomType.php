<?php

namespace Prototype\GQL\Type;

use GraphQL\Type\Definition\Type;
use GraphQL\GraphQL;
use Prototype\GQL\Type\Location\LocationType;
use Prototype\GQL\Type\User\UserType;

class CustomType
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