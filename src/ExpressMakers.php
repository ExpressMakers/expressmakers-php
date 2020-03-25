<?php

namespace ExpressMakers\API;

use ExpressMakers\API\Exceptions\TokenNotSetException;
use ExpressMakers\API\Responses\CreateTransactionResponse;
use ExpressMakers\API\Responses\GetOrdersResponse;
use ExpressMakers\API\Responses\GetTransactionResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class ExpressMakers.
 *
 * @author Pezhvak <pezhvak@imvx.org>
 *
 * @see https://developers.expressmakers.com
 */
class ExpressMakers
{
    const BASE_URL = 'https://panel.expressmakers.com/api/';
    private $_token;
    private $_client;

    /**
     * ExpressMakers constructor.
     *
     * @param string $token
     *
     * @throws TokenNotSetException
     */
    public function __construct(string $token)
    {
        if (empty($token)) {
            $this->_throwInvalidTokenException();
        }
        $this->_token = $token;
    }

    /**
     * @throws TokenNotSetException
     */
    private function _throwInvalidTokenException(): void
    {
        throw new TokenNotSetException('Please provide a valid token');
    }

    /**
     * Get Orders.
     *
     * using this endpoint you can receive all orders you have created.
     *
     * @see https://developers.expressmakers.com/#get-orders
     *
     * @throws TokenNotSetException
     *
     * @return GetOrdersResponse
     */
    public function getOrders(): GetOrdersResponse
    {
        return new GetOrdersResponse($this->_call('GET', 'orders'));
    }

    /**
     * Call API Endpoint.
     *
     * @param string     $method
     * @param string     $endpoint
     * @param array|null $data
     *
     * @throws TokenNotSetException
     *
     * @return mixed
     */
    private function _call(string $method, string $endpoint, array $data = null)
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->_token,
            'Accept'        => 'application/json',
        ];
        if (!isset($this->_client)) {
            $this->_client = new Client(['headers' => $headers]);
        }
        $response = '';

        try {
            if (is_null($data)) {
                $response = $this->_client->$method(self::BASE_URL.$endpoint);
            } else {
                $response = $this->_client->$method(self::BASE_URL.$endpoint, ['form_params' => $data]);
            }
        } catch (ClientException $exception) {
            switch ($exception->getCode()) {
                case 401:

                        $this->_throwInvalidTokenException();

                    break;
                default:

                    throw $exception;
            }
        }

        return $response;
    }

    /**
     * Create Transaction.
     *
     * every time you need to receive an amount from your client using your created order, you should call this
     * endpoint. once transaction is created you should redirect your client to 'payment_link' property returned from
     * your request.
     *
     * @see https://developers.expressmakers.com/#transaction-create
     *
     * @param int    $amount           the amount you desire to receive
     * @param string $domain           the domain name you have ordered
     * @param string $success_callback the url that user should get redirected into when transaction payed successfully
     * @param string $failure_callback the url that user should get redirected into when transaction did not payed successfully
     *
     * @throws TokenNotSetException
     *
     * @return CreateTransactionResponse
     */
    public function createTransaction(int $amount, string $domain, string $success_callback, string $failure_callback)
    {
        return new CreateTransactionResponse($this->_call(
            'POST',
            'transactions',
            compact('amount', 'domain', 'success_callback', 'failure_callback')
        ));
    }

    /**
     * Get Transaction.
     *
     * once you created a transaction and you need to known the state of it, you can use this endpoint, this will be
     * used usually after user has returned to your callback url and you want to know what is the state of the
     * transaction.
     *
     * @see https://developers.expressmakers.com/#transaction
     *
     * @param string $transaction_id id of the transaction
     *
     * @throws TokenNotSetException
     *
     * @return GetTransactionResponse
     */
    public function renewOrder(string $transaction_id): GetTransactionResponse
    {
        return new GetTransactionResponse($this->_call('GET', "transactions/{$transaction_id}"));
    }
}
