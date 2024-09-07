<?php

declare(strict_types=1);

namespace App\Tests\Mother\Discounts;

use App\Discounts\Domain\ValueObject\Product\ProductId;

final class ProductIdMother
{
	public static function aWeirdId(): ProductId
	{
		return new ProductId('XXXX01');
	}
}