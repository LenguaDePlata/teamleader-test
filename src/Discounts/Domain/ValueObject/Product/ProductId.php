<?php

declare(strict_types=1);

namespace App\Discounts\Domain\ValueObject\Product;

final class ProductId
{
	public function __construct(
		private string $value
	){}

	public function __toString(): string
	{
		return $this->value;
	}
}