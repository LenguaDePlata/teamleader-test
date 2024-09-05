<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Specification\DiscountCheck;

use App\Discounts\Domain\Model\Order\Order;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.discounts.discount_check')]
interface DiscountCheck
{
	public function isSatisfiedBy(Order $order): boolean;
}