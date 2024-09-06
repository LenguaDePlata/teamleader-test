<?php

declare(strict_types=1);

namespace App\Discounts\Application\Assembler;

use App\Discounts\Application\DTO\OrderItemResponse;
use App\Discounts\Application\DTO\OrderItemDTO;
use App\Discounts\Application\Query\CalculateDiscount\CalculateDiscountQuery;
use App\Discounts\Application\Query\CalculateDiscount\CalculateDiscountResponse;
use App\Discounts\Application\Query\CalculateDiscount\DiscountedOrderItemResponse;
use App\Discounts\Application\Query\CalculateDiscount\DiscountedTotalResponse;
use App\Discounts\Domain\Model\Order\Order;
use App\Discounts\Domain\Model\Order\OrderItem;
use App\Discounts\Domain\ValueObject\Order\AppliedDiscount;

class CalculateDiscountResponseAssembler
{
	public function toDTO(
		Order $order,
		CalculateDiscountQuery $query
	): CalculateDiscountResponse {
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
						$orderItem->product()->id()->__toString(),
						$orderItem->quantity()->__toInt(),
						$orderItem->unitPrice()->__toFloat(),
						$orderItem->total()->__toFloat(),
						array_reduce(
							$orderItem->discountsAppliedToItem(),
							function (string $carry, AppliedDiscount $appliedDiscount) {
								return $carry . ',' . $appliedDiscount->__toString();
							}
						)
					);
				},
				$order->orderItems()
			),
			new DiscountedTotalResponse(
				$order->total()->__toFloat(),
				array_reduce(
					$order->discountsAppliedToTotal(),
					function (string $carry, AppliedDiscount $appliedDiscount) {
						return $carry . ',' . $appliedDiscount->__toString();
					}
				)
			)
		);
	}
}