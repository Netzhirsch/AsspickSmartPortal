<?php

namespace App\Enumeration;

abstract class CriminalProceedingsAgainstTypEnum {
	const MICH = 1;
	const UNFALLGEGNER = 2;
	const SCHADENVERURSACHER = 3;

	/**
	 * @return array<string>
	 */
	public static function getAll(): array
    {
		return [
			self::MICH,
			self::UNFALLGEGNER,
			self::SCHADENVERURSACHER
		];
	}
}
