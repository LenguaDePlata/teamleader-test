<?php

declare(strict_types=1);

namespace App\Discounts\Application\Query\CalculateDiscount;

use App\Shared\Application\Query\ResponseDTO;

final class DiscountedOrderItemResponse implements ResponseDTO
{
	public function __construct(
		private string $productId,
		private int $quantity,
		private float $unitPrice,
		private float $total,
		private string $discountsAppliedToItem
	){}

	public function __toArray(): array
	{
		return [
			'product-id' => $this->productId,
			'quantity' => $this->quantity,
			'unit-price' => $this->unitPrice,
			'total' => $this->total,
			'discounts-applied-to-item' => $this->discountsAppliedToItem
		];
	}
}