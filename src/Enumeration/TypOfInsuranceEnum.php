<?php

namespace App\Enumeration;

abstract class TypOfInsuranceEnum {
	const HAFTPFLICHT = 1;
	const KASKO = 2;

	/**
	 * @return array<string>
	 */
	public static function getAll(): array
    {
		return [
			self::HAFTPFLICHT,
			self::KASKO
		];
	}
}
