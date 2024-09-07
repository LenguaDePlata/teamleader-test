<?php

declare(strict_types=1);

namespace App\Tests\Mother\Discounts;

use App\Discounts\Application\DTO\OrderItemDTO;

final class OrderItemDTOMother
{
	public static function aTenSwitchProductItemDTO(): OrderItemDTO
	{
		return new OrderItemDTO(
			productId: "B102",
			quantity: 10,
			unitPrice: 4.99,
			total: 49.90
		);
	}

	public static function aTwoToolProductItemDTO(): OrderItemDTO
	{
		return new OrderItemDTO(
			productId: "A101",
			quantity: 2,
			unitPrice: 9.75,
			total: 19.50
		);
	}

	public static function aOneToolProductItemDTO(): OrderItemDTO
	{
		return new OrderItemDTO(
			productId: "A102",
			quantity: 1,
			unitPrice: 49.50,
			total: 49.50
		);
	}
}