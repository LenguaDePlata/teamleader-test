<?php

declare(strict_types=1);

namespace App\Tests\Unit\Discounts\Infrastructure\Specification\DiscountCheck;

use App\Discounts\Infrastructure\Specification\DiscountCheck\TwoOrMoreProductsOfCategoryTools;
use PHPUnit\Framework\TestCase;

final class TwoOrMoreProductsOfCategoryToolsTest extends TestCase
{
	private TwoOrMoreProductsOfCategoryTools $check;

	protected function setUp(): void
	{
		$this->check = new TwoOrMoreProductsOfCategoryTools();
	}
}