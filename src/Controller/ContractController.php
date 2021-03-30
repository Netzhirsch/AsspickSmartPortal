<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contract")
 */
class ContractController extends AbstractController {

	const TOKEN_URL = "https://account-staging.assfinet.de/oauth/token";
	const API_URL = "https://drive-staging.assfinetcloud.de/api/v1/AMS/Vertrag";
	const API_USER = "test1@drive.assfinet.de";
	const API_PASSWORD = "al%cS2v5pS";
	const API_CLIENT_ID = "SoapUi";
	const API_CLIENT_SECRET = "SoapUi";

	/**
	 * @Route("/", name="contract_list")
	 * @return Response
	 */
	public function listAction(): Response {
		$parameters = [];
		$parameters['contracts'] = [];

		$access_token = self::getAccessToken();

		if (!empty($access_token)) {
			$resource = self::getResource($access_token);
			$parameters['contracts'] = $resource;
		}

		return $this->render('contract/index.html.twig', $parameters);
	}

	private static function getAccessToken() {
		$tokenContent = "grant_type=password&username=" . self::API_USER . "&password=" . self::API_PASSWORD . "&scope=%20";
		$authorization = base64_encode(self::API_CLIENT_ID . ":" . self::API_CLIENT_SECRET);
		$tokenHeaders = ["Authorization: Basic {$authorization}", "Content-Type: application/x-www-form-urlencoded"];

		$token = curl_init();
		curl_setopt($token, CURLOPT_URL, self::TOKEN_URL);
		curl_setopt($token, CURLOPT_HTTPHEADER, $tokenHeaders);
		curl_setopt($token, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($token, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($token, CURLOPT_POST, true);
		curl_setopt($token, CURLOPT_POSTFIELDS, $tokenContent);
		$response = curl_exec($token);
		curl_close($token);
		$token_array = json_decode($response, true);

		if (is_array($token_array) && !empty($token_array["access_token"])) {
			return $token_array["access_token"];
		}

		return null;
	}

	//	step B - with the returned access_token we can make as many calls as we want
	private static function getResource($access_token) {
		$header = [
			"Content-Type: application/json",
			"Authorization: Bearer {$access_token}",
		];

		$curl = curl_init();
		curl_setopt_array(
			$curl,
			[
				CURLOPT_URL            => self::API_URL,
				CURLOPT_HTTPHEADER     => $header,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_RETURNTRANSFER => true,
			]
		);
		$response = curl_exec($curl);
		curl_close($curl);

		return json_decode($response, true);
	}
}
