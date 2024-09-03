<?php

declare(strict_types=1);

namespace App\Discounts\Application\Query\CalculateDiscount;

class CalculateDiscountQuery
{
	public function __construct(
		private readonly int $id,
		private readonly int $customerId,
		/** @var ProductDTO[] $products */
		private readonly array $products,
		private readonly float $total
	) {}

	public function getId(): int
	{
		return $this->id;
	}

	public function getCustomerId(): int
	{
		return $this->customerId;
	}

	/**
		@return ProductDTO[]
	*/
	public function getProducts(): array
	{
		return $this->products;
	}

	public function getTotal(): float
	{
		return $this->total;
	}
}