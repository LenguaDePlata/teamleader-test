<?php

declare(strict_types=1);

namespace App\Discounts\Domain\ValueObject\Shared;

class Amount
{
	public function __construct(
		protected float $value
	){}

	public function __toFloat(): float
	{
		return $this->value;
	}
}