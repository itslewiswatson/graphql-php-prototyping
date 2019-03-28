<?php

namespace Prototype\GQL\Registry;

use Prototype\GQL\Type\User\CreateUserType;
use Prototype\GQL\Type\Location\CreateLocationType;

class MutationRegistry
{
	private static $createUser;
	private static $createLocation;

	public static function createUser()
	{
		return self::$createUser ?: (self::$createUser = new CreateUserType());
	}

	public static function createLocation()
	{
		return self::$createLocation ?: (self::$createLocation = new CreateLocationType());
	}
}