<?php

declare(strict_types=1);

namespace App\Discounts\Application\Query\CalculateDiscount;

use App\Shared\Application\Query\ResponseDTO;
use App\Discounts\Application\DTO\OrderItemResponse;

final class CalculateDiscountResponse implements ResponseDTO
{
	public function __construct(
		private int $id,
		private int $customerId,
		/** @var OrderItemResponse[] $originalOrderItems */
		private array $originalOrderItems,
		private float $originalTotal,
		/** @var DiscountedOrderItemResponse[] $discountedOrderItems */
		private array $discountedOrderItems,
		private DiscountedTotalResponse $discountedTotal
	){}

	public function __toArray(): array
	{
		return [
			'id' => $this->id,
			'customer-id' => $this->customerId,
			'original-order' => [
				'items' => array_map(
					function(OrderItemResponse $orderItem) {
						return $orderItem->__toArray();
					},
					$this->originalOrderItems
				),
				'total' => $this->originalTotal
			],
			'discounted-order' => [
				'items' => array_map(
					function(DiscountedOrderItemResponse $orderItem) {
						return $orderItem->__toArray();
					},
					$this->discountedOrderItems
				),
				'total' => $this->discountedTotal->__toArray()
			]
		];
	}
}