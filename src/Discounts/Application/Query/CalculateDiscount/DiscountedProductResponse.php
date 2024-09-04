<?php

declare(strict_types=1);

namespace App\Discounts\Application\Query\CalculateDiscount;

use App\Shared\Application\Query\ResponseDTO;

final class DiscountedProductResponse implements ResponseDTO
{
	public function __construct(
		private string $productId,
		private int $quantity,
		private float $unitPrice,
		private float $total,
		private array $discountsAppliedToProduct
	){}

	public function toArray(): array
	{
		return [
			'product-id' => $this->productId,
			'quantity' => $this->quantity,
			'unit-price' => $this->unitPrice,
			'total' => $this->total,
			'discounts-applied-to-product' => $this->discountsAppliedToProduct
		];
	}
}