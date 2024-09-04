<?php

declare(strict_types=1);

namespace App\Discounts\Application\Query\CalculateDiscount;

use App\Shared\Application\Query\ResponseDTO;

final class DiscountedTotalResponse implements ResponseDTO
{
	public function __construct(
		private float $total,
		private array $discountsAppliedToTotal
	){}

	public function toArray(): array
	{
		return [
			'total' => $this->total,
			'discounts-applied-to-total' => $this->discountsAppliedToTotal
		];
	}
}