<?php

declare(strict_types=1);

namespace App\Discounts\Application\DTO;

use App\Shared\Application\Query\ResponseDTO;

final class OrderLineResponse implements ResponseDTO
{
	public function __construct(
		private string $productId,
		private int $quantity,
		private float $unitPrice,
		private float $total
	){}

	public function toArray(): array
	{
		return [
			'product-id' => $this->productId,
			'quantity' => $this->quantity,
			'unit-price' => $this->unitPrice,
			'total' => $this->total
		];
	}
}