<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Exception;

use Exception;

class ProductNotFoundException extends Exception
{
	public function __construct(ProductId $id)
	{
		parent::__construct('Product with id '.(string)$id.' has not been found or does not exist');
	}
}