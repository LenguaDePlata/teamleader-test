<?php

declare(strict_types=1);

namespace App\Discounts\Application\Exception;

use Exception;

class ProductNotFoundException extends Exception
{
	public function __construct(Exception $previous)
	{
		parent::__construct($previous->getMessage(), 0, $previous);
	}
}