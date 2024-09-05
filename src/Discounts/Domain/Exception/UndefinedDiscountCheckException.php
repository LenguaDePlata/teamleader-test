<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Exception;

use Exception;

class UndefinedDiscountCheckException extends Exception
{
	public function __construct(string $discountCheckClassname)
	{
		parent::__construct("The discount check instance with class $discountCheckClassname is not a valid check or does not have an associated discount logic");
	}
}