<?php

declare(strict_types=1);

namespace App\Discounts\Domain\ValueObject\Customer;

final class CustomerId
{
	public function __construct(
		private int $value
	){}
}