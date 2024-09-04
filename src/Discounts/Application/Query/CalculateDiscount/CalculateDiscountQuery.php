<?php

declare(strict_types=1);

namespace App\Discounts\Application\Query\CalculateDiscount;

final class CalculateDiscountQuery
{
	public function __construct(
		private int $id,
		private int $customerId,
		/** @var ProductDTO[] $products */
		private array $products,
		private float $total
	){}

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