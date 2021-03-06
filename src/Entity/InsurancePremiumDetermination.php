<?php

namespace App\Entity;

class InsurancePremiumDetermination {

	public const MODE_BAK_I = 'bak_i';
	public const MODE_BAK_III = 'bak_iii';
	public const MODE_BAK_IV_MAX_2_5_MIO = 'bak_iv_max_2_5_mio';
	public const MODE_BAK_IV_OVER_2_5_MIO = 'bak_iv_over_2_5_mio';
	public const MODE_DENKMALSCHUTZ = 'bak_denkmalschutz';
	public const MODE_FERIENHAUS = 'bak_ferienhaus';

	public const SALUTATION_MR = 'mr';
	public const SALUTATION_MRS = 'mrs';

	public const PAYMENT_METHOD_BILL = 'bill';
	public const PAYMENT_METHOD_DIRECT_DEBIT = 'direct_debit';

	private $salutation;

	private $firstName;

	private $lastName;

	private $street;

	private $zipcode;

	private $city;

	private $paymentMethod;

	private $mode;

	private $sumInsured;

	private $sumInsuredVs;

	private $total;

	private $totalVs;

	private $numberOfResidentialUnits;

	private $numberOfCommerciallyUsedUnits;

	private $oilTankSize;

    public function getName(): string
    {
		$name = [];
		if (!empty($this->getSalutation()))
			$name[] = $this->getSalutation();
		if (!empty($this->getFirstName()))
			$name[] = $this->getFirstName();
		if (!empty($this->getLastName()))
			$name[] = $this->getLastName();
		
		return implode(" ", $name);
	}
	/**
	 * @return mixed
	 */
	public function getSalutation() {
		return $this->salutation;
	}

	/**
	 * @param mixed $salutation
	 */
	public function setSalutation($salutation): void {
		$this->salutation = $salutation;
	}

	/**
	 * @return mixed
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * @param mixed $firstName
	 */
	public function setFirstName($firstName): void {
		$this->firstName = $firstName;
	}

	/**
	 * @return mixed
	 */
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * @param mixed $lastName
	 */
	public function setLastName($lastName): void {
		$this->lastName = $lastName;
	}

	/**
	 * @return mixed
	 */
	public function getStreet() {
		return $this->street;
	}

	/**
	 * @param mixed $street
	 */
	public function setStreet($street): void {
		$this->street = $street;
	}

	/**
	 * @return mixed
	 */
	public function getZipcode() {
		return $this->zipcode;
	}

	/**
	 * @param mixed $zipcode
	 */
	public function setZipcode($zipcode): void {
		$this->zipcode = $zipcode;
	}

	/**
	 * @return mixed
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * @param mixed $city
	 */
	public function setCity($city): void {
		$this->city = $city;
	}

	/**
	 * @return mixed
	 */
	public function getPaymentMethod() {
		return $this->paymentMethod;
	}

	/**
	 * @param mixed $paymentMethod
	 */
	public function setPaymentMethod($paymentMethod): void {
		$this->paymentMethod = $paymentMethod;
	}

	/**
	 * @return mixed
	 */
	public function getMode() {
		return $this->mode;
	}

	/**
	 * @param mixed $mode
	 */
	public function setMode($mode): void {
		$this->mode = $mode;
	}

	/**
	 * @return mixed
	 */
	public function getSumInsured() {
		return $this->sumInsured;
	}

	/**
	 * @param mixed $sumInsured
	 */
	public function setSumInsured($sumInsured): void {
		$this->sumInsured = $sumInsured;
	}

	/**
	 * @return mixed
	 */
	public function getSumInsuredVs() {
		return $this->sumInsuredVs;
	}

	/**
	 * @param mixed $sumInsuredVs
	 */
	public function setSumInsuredVs($sumInsuredVs): void {
		$this->sumInsuredVs = $sumInsuredVs;
	}

	/**
	 * @return mixed
	 */
	public function getTotal() {
		return $this->total;
	}

	/**
	 * @param mixed $total
	 */
	public function setTotal($total): void {
		$this->total = $total;
	}

	/**
	 * @return mixed
	 */
	public function getTotalVs() {
		return $this->totalVs;
	}

	/**
	 * @param mixed $totalVs
	 */
	public function setTotalVs($totalVs): void {
		$this->totalVs = $totalVs;
	}

	/**
	 * @return mixed
	 */
	public function getNumberOfResidentialUnits() {
		return $this->numberOfResidentialUnits;
	}

	/**
	 * @param mixed $numberOfResidentialUnits
	 */
	public function setNumberOfResidentialUnits($numberOfResidentialUnits): void {
		$this->numberOfResidentialUnits = $numberOfResidentialUnits;
	}

	/**
	 * @return mixed
	 */
	public function getNumberOfCommerciallyUsedUnits() {
		return $this->numberOfCommerciallyUsedUnits;
	}

	/**
	 * @param mixed $numberOfCommerciallyUsedUnits
	 */
	public function setNumberOfCommerciallyUsedUnits($numberOfCommerciallyUsedUnits): void {
		$this->numberOfCommerciallyUsedUnits = $numberOfCommerciallyUsedUnits;
	}

	/**
	 * @return mixed
	 */
	public function getOilTankSize() {
		return $this->oilTankSize;
	}

	/**
	 * @param mixed $oilTankSize
	 */
	public function setOilTankSize($oilTankSize): void {
		$this->oilTankSize = $oilTankSize;
	}

	public static function getPaymentMethods() {
		return [
			'Rechnung'               => self::PAYMENT_METHOD_BILL,
			'Lastschrift'             => self::PAYMENT_METHOD_DIRECT_DEBIT,
		];
	}

	public static function getModeOptions() {
		return [
			'BAK I'               => self::MODE_BAK_I,
			'BAK III'             => self::MODE_BAK_III,
			'BAK IV bis 2,5 Mio'  => self::MODE_BAK_IV_MAX_2_5_MIO,
			'BAK IV über 2,5 Mio' => self::MODE_BAK_IV_OVER_2_5_MIO,
			'Denkmalschutz'       => self::MODE_DENKMALSCHUTZ,
			'Ferienhaus'          => self::MODE_FERIENHAUS,
		];
	}

	public static function getSalutationOptions() {
		return [
			'Frau'             => self::SALUTATION_MRS,
			'Herr'               => self::SALUTATION_MR,
		];
	}
}
