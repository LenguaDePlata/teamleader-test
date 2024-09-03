<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Exception;

class InvalidJsonException extends \Exception
{
	public function __construct()
	{
		parent::__construct('Invalid JSON');
	}
}