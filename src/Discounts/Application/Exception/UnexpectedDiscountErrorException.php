<?php

declare(strict_types=1);

namespace App\Discounts\Application\Exception;

use Exception;

class UnexpectedDiscountErrorException extends Exception
{
	public function __construct(Exception $previous)
	{
		parent::__construct("There was an unexpected error trying to apply the discounts", 0, $previous);
	}
}