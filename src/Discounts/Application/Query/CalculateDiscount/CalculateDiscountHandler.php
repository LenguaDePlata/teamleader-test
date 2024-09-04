<?php

declare(strict_types=1);

namespace App\Discounts\Application\Query\CalculateDiscount;

use App\Discounts\Application\DTO\OrderLineResponse;
use App\Discounts\Application\DTO\ProductDTO;

class CalculateDiscountHandler
{
	public function handle(CalculateDiscountQuery $query): CalculateDiscountResponse
	{
		// Create order object from DTO
		$orderLines = array_map(
			function (ProductDTO $orderLineDTO) {
				return OrderLine::create(
					$orderLine->getProductId(),
					$orderLine->getQuantity(),
					$orderLine->getUnitPrice(),
					$orderLine->getTotal()
				);
			},
			$query->getProducts()
		);
		$order = Order::create(
			$query->getId(),
			$query->getCustomerId(),
			$orderLines,
			$query->getTotal()
		);
		// Redirect to domain function to apply discounts (composite for each discount, specification to check which to add to the composite)
		$order->applyDiscounts();
		// Construct response object from new order and original values
		return new CalculateDiscountResponse(
			$query->getId(),
			$query->getCustomerId(),
			array_map(
				function (ProductDTO $orderLineDTO) {
					return new OrderLineResponse(
						$orderLine->getProductId(),
						$orderLine->getQuantity(),
						$orderLine->getUnitPrice(),
						$orderLine->getTotal()
					);
				},
				$query->getProducts()
			),
			$query->getTotal(),
			array_map(
				function (OrderLine $orderLine) {
					return new DiscountedProductResponse(
						$orderLine->productId()->__toString(),
						$orderLine->quantity()->__toInt(),
						$orderLine->unitPrice()->__toFloat(),
						$orderLine->total()->__toFloat(),
						$orderLine->discountsAppliedToLine()->__toString()
					);
				},
				$order->orderLines()
			),
			new DiscountedTotalResponse(
				$order->total()->__toString(),
				$order->discountsAppliedToTotal()->__toString()
			)
		);
	}
}