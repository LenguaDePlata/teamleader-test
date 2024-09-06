<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Builder;

use App\Discounts\Domain\Model\Order\Order;
use App\Discounts\Domain\Model\Order\OrderItem;
use App\Discounts\Domain\Repository\ProductRepository;

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
		$orderItems = $this->generateOrderItems($orderItemsDTO);
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
			$product = $this->productRepository->findById(
				new ProductId($dto->getProductId())
			);
			if ($product === null) {
				throw new ProductNotFoundException();
			}
			$orderItems[] =new OrderItem(
				$product,
				$orderItemDTO->getQuantity(),
				$orderItemDTO->getUnitPrice(),
				$orderItemDTO->getTotal()
			);
		}
		return $orderItems;
	}
}