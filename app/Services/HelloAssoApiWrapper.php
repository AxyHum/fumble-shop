<?php

namespace App\Services {

    use DateInterval;
    use Datetime;
    use Exception;
    use HTTP_Request2;
    use HTTP_Request2_Exception;
    use HTTP_Request2_LogicException;

    /**
     * This class could appear complicated but once prefill documentation in your hands it will make perfect sens !
     */
    class HelloAssoApiWrapper
    {
        private array $config;
        private $token;

        /**
         * @throws HTTP_Request2_LogicException
         */
        public function __construct($config)
        {
            $this->config = $config;
            $this->initToken($config['clientId'], $config['clientSecret']);
        }

        /**
         * @throws HTTP_Request2_LogicException
         */
        private function initToken($clientId, $clientSecret): void
        {
            $request = new HTTP_Request2();
            $request->setUrl('https://api.helloasso.com/oauth2/token');
            $request->setMethod(HTTP_Request2::METHOD_POST);
            $request->setHeader(array(
                'Content-Type' => 'application/x-www-form-urlencoded',
            ));
            $request->addPostParameter(array(
                'grant_type' => 'client_credentials',
                'client_id' => $clientId,
                'client_secret' => $clientSecret
            ));

            try {
                $response = $request->send();
                if ($response->getStatus() == 200) {
                    $this->token = json_decode($response->getBody());
                    return;
                } else {
                    echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' . $response->getReasonPhrase();
                }
            } catch (HTTP_Request2_Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }

        /**
         * Call HelloAsso API to initialize checkout
         * If ok this function return raw response
         * Else an error code
         * @throws Exception
         */
        public function initCart($data)
        {
            $request = new HTTP_Request2();
            $request->setUrl('https://api.helloasso.com/v5/organizations/' . $this->config['organismSlug'] . '/checkout-intents');
            $request->setMethod(HTTP_Request2::METHOD_POST);
            $request->setHeader(array(
                'authorization' => 'Bearer ' . $this->token->access_token,
                'Content-Type' => 'application/json',
            ));
//            $date = new Datetime($data->birthdate);

            $body = array('totalAmount' => round($data->product->price * 100),
                'initialAmount' => round($data->product->price * 100),
                'itemName' => $data->product->title,
                'backUrl' => $this->config['baseUrl'],
                'errorUrl' => $this->config['errorUrl'],
                'returnUrl' => url("/payments/verify/Asso?status=success&order_id=$data->id"),
                'containsDonation' => false,
                'payer' => array(
                    'firstName' => "",
                    'lastName' => "",
                    'email' => "",
                    'dateOfBirth' => "",
                    'address' => "",
                    'city' => "",
                    'zipCode' => "",
                    'companyName' => "",
                ),
                'metadata' => array(
                    'reference' => $data->id,
                )
            );

            if ($data->method > 1) {
                $body = $this->manageMultiplePayment($data->method, $data->amount * 100, $body);
            }

            $request->setBody(json_encode($body));

            try {
                $response = $request->send();
                return json_decode($response->getBody());
            } catch (Exception $e) {
                return json_decode('{"error":"' . $e . '"}');
            }
        }

        /**
         * @throws HTTP_Request2_LogicException
         */
        public function retrieveCheckout($checkoutId)
        {
            $request = new HTTP_Request2();
            $request->setUrl('https://api.helloasso.com/v5/organizations/' . $this->config['organismSlug'] . '/checkout-intents' . '/' . $checkoutId);
            $request->setMethod(HTTP_Request2::METHOD_GET);
            $request->setHeader(array(
                'authorization' => 'Bearer ' . $this->token->access_token,
                'Content-Type' => 'application/json',
            ));

            try {
                $response = $request->send();
                return json_decode($response->getBody());
            } catch (Exception $e) {
                return json_decode('{"error":"' . $e . '"}');
            }
        }

        /**
         * Split amount into terms and set terms date to first day of the month
         * @throws Exception
         */
        private function manageMultiplePayment($paymentCount, $totalAmount, $body)
        {
            $termsAmount = round($totalAmount / $paymentCount, 2, PHP_ROUND_HALF_DOWN);
            $rest = round($totalAmount - ($termsAmount * $paymentCount), 2);

            $body['initialAmount'] = $termsAmount;

            $body['terms'] = array();
            $today = getdate();
            $nextPayment = new DateTime($today['year'] . '-' . $today['month'] . '-01');

            for ($i = 1; $i < $paymentCount; $i++) {
                $nextPayment->add(new DateInterval('P1M'));
                $body['terms'][] = array(
                    'amount' => $i == $paymentCount - 1 ? ($termsAmount + $rest) : $termsAmount,
                    'date' => $nextPayment->format('Y-m-d')
                );
            }

            return $body;
        }
    }
}
