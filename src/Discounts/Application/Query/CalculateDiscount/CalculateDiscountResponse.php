<?php

declare(strict_types=1);

namespace App\Discounts\Application\Query\CalculateDiscount;

use App\Shared\Application\Query\ResponseDTO;

final class CalculateDiscountResponse implements ResponseDTO
{
	public function __construct(
		private int $id,
		private int $customerId,
		/** @var ProductResponse[] $originalProducts */
		private array $originalProducts,
		private float $originalTotal,
		/** @var DiscountedProductResponse[] $originalProducts */
		private array $discountedProducts,
		private DiscountedTotalResponse $discountedTotal
	){}

	public function toArray(): array
	{
		return [
			'id' => $this->id,
			'customer-id' => $this->customerId,
			'original-order' => [
				'items' => array_map(
					function(ProductResponse $product) {
						return $product->toArray();
					},
					$this->originalProducts
				),
				'total' => $this->originalTotal
			],
			'discounted-order' => [
				'items' => array_map(
					function(DiscountedProductResponse $product) {
						return $product->toArray();
					},
					$this->discountedProducts
				),
				'total' => $this->discountedTotal->toArray()
			]
		];
	}
}