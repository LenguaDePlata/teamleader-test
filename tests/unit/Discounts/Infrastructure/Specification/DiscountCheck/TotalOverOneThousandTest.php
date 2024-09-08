<?php

declare(strict_types=1);

namespace App\Tests\Unit\Discounts\Infrastructure\Specification\DiscountCheck;

use App\Discounts\Infrastructure\Specification\DiscountCheck\TotalOverOneThousand;
use PHPUnit\Framework\TestCase;

final class TotalOverOneThousandTest extends TestCase
{
	private TotalOverOneThousand $check;

	protected function setUp(): void
	{
		$this->check = new TotalOverOneThousand();
	}
}