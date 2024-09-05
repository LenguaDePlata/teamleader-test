<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Builder;

use App\Discounts\Domain\Model\Order\Order;
use App\Discounts\Domain\Model\Order\OrderItem;

class OrderBuilder
{
	public function build(
		int $id,
		int $customerId,
		array $orderItemsDTO,
		float $total
	): Order {
		// TODO: initialize Product objects from database for each order item
		$orderItems = array_map(
			function (OrderItemDTO $orderItemDTO) {
				return new OrderItem(
					$orderItemDTO->getProductId(),
					$orderItemDTO->getQuantity(),
					$orderItemDTO->getUnitPrice(),
					$orderItemDTO->getTotal()
				);
			},
			$orderItemsDTO
		);
		return new Order(
			$id,
			$customerId,
			$orderItems,
			$total
		);
	}
}