<?php

declare(strict_types=1);

namespace App\Discounts\Application\DTO;

final class OrderItemDTO
{
	public function __construct(
		private string $productId,
		private int $quantity,
		private float $unitPrice,
		private float $total
	){}

	public function getProductId(): string
	{
		return $this->productId;
	}

	public function getQuantity(): int
	{
		return $this->quantity;
	}

	public function getUnitPrice(): float
	{
		return $this->unitPrice;
	}

	public function getTotal(): float
	{
		return $this->total;
	}
}