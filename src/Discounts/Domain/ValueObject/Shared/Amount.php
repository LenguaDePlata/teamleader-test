<?php

declare(strict_types=1);

namespace App\Discounts\Domain\ValueObject\Shared;

final class Amount
{
	public function __construct(
		private float $value
	){}

	public function __toFloat(): float
	{
		return $this->value;
	}
}