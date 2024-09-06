<?php

declare(strict_types=1);

namespace App\Discounts\Domain\ValueObject\Product;

final class Category
{
	public function __construct(
		private int $value
	){}

	public function __toInt(): string
	{
		return $this->value;
	}

	public function equalsTo(int $category): bool
	{
		return $this->value === $category;
	}
}