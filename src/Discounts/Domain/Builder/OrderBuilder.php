<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Builder;

use App\Discounts\Domain\Exception\ProductNotFoundException;
use App\Discounts\Domain\Model\Order\Order;
use App\Discounts\Domain\Model\Order\OrderItem;
use App\Discounts\Domain\Repository\ProductRepository;
use App\Discounts\Domain\ValueObject\Product\ProductId;

class OrderBuilder
{
	public function __construct(
		private ProductRepository $productRepository
	){}

	/**
		@param OrderItemDTO[] $orderItemDTOs
		@throws ProductNotFoundException
	*/
	public function build(
		int $id,
		int $customerId,
		array $orderItemDTOs,
		float $total
	): Order {
		$orderItems = $this->generateOrderItems($orderItemDTOs);
		return new Order(
			$id,
			$customerId,
			$orderItems,
			$total
		);
	}

	/**
		@param OrderItemDTO[] $orderItemDTOs
		@return OrderItem[]
		@throws ProductNotFoundException
	*/
	private function generateOrderItems(array $orderItemDTOs): array
	{
		$orderItems = [];
		foreach($orderItemDTOs as $dto) {
			$productId = new ProductId($dto->getProductId());
			$product = $this->productRepository->findById($productId);
			if ($product === null) {
				throw new ProductNotFoundException($productId);
			}
			$orderItems[] = new OrderItem(
				$product,
				$dto->getQuantity(),
				$dto->getUnitPrice(),
				$dto->getTotal()
			);
		}
		return $orderItems;
	}
}