<?php

declare(strict_types=1);

namespace App\Discounts\Application\Query\CalculateDiscount;

final class CalculateDiscountQuery
{
	public function __construct(
		private int $id,
		private int $customerId,
		/** @var OrderItemDTO[] $orderItems */
		private array $orderItems,
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
		@return OrderItemDTO[]
	*/
	public function getOrderItems(): array
	{
		return $this->orderItems;
	}

	public function getTotal(): float
	{
		return $this->total;
	}
}