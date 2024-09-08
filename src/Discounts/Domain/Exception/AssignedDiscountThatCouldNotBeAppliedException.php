<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Exception;

use Exception;

class AssignedDiscountThatCouldNotBeAppliedException extends Exception
{
	public function __construct(string $discountClassName)
	{
		parent::__construct("The discount $discountClassName should have been applicable for the order, but it couldn't be applied");
	}
}