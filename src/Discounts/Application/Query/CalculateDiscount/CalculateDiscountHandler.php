<?php

declare(strict_types=1);

namespace App\Discounts\Application\Query\CalculateDiscount;

use App\Discounts\Application\DTO\OrderItemResponse;
use App\Discounts\Application\DTO\OrderItemDTO;

class CalculateDiscountHandler
{
	public function handle(CalculateDiscountQuery $query): CalculateDiscountResponse
	{
		// Create order object from DTO
		$orderItems = array_map(
			function (OrderItemDTO $orderLineDTO) {
				return OrderItem::create(
					$orderItem->getProductId(),
					$orderItem->getQuantity(),
					$orderItem->getUnitPrice(),
					$orderItem->getTotal()
				);
			},
			$query->getOrderItems()
		);
		$order = Order::create(
			$query->getId(),
			$query->getCustomerId(),
			$orderItems,
			$query->getTotal()
		);
		// Redirect to domain function to apply discounts (composite for each discount, specification to check which to add to the composite)
		$order->applyDiscounts();
		// Construct response object from new order and original values
		return new CalculateDiscountResponse(
			$query->getId(),
			$query->getCustomerId(),
			array_map(
				function (OrderItemDTO $orderItemDTO) {
					return new OrderItemResponse(
						$orderItemDTO->getProductId(),
						$orderItemDTO->getQuantity(),
						$orderItemDTO->getUnitPrice(),
						$orderItemDTO->getTotal()
					);
				},
				$query->getOrderItems()
			),
			$query->getTotal(),
			array_map(
				function (OrderItem $orderItem) {
					return new DiscountedOrderItemResponse(
						$orderItem->productId()->__toString(),
						$orderItem->quantity()->__toInt(),
						$orderItem->unitPrice()->__toFloat(),
						$orderItem->total()->__toFloat(),
						$orderItem->discountsAppliedToItem()->__toString()
					);
				},
				$order->orderItems()
			),
			new DiscountedTotalResponse(
				$order->total()->__toString(),
				$order->discountsAppliedToTotal()->__toString()
			)
		);
	}
}