<?php

namespace ExpressMakers\API\Responses;

/**
 * Class CreateTransactionResponse.
 *
 * @author Pezhvak <pezhvak@imvx.org>
 *
 * @property array $proxies list of all proxies of this order
 */
class CreateTransactionResponse extends BaseResponse
{
    /**
     * Get Transaction Details.
     *
     * transaction details.
     *
     * @return object
     */
    public function getTransaction(): object
    {
        return $this->_data->transaction;
    }

    /**
     * Get Payment Link
     *
     * get the link that user should redirected into for paying provided amount
     *
     * @return string
     */
    public function getPaymentLink(): string
    {
        return $this->_data->payment_link;
    }
}