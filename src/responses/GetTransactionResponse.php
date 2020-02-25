<?php

namespace ExpressMakers\API\Responses;

/**
 * Class GetTransactionResponse.
 *
 * @author Pezhvak <pezhvak@imvx.org>
 *
 */
class GetTransactionResponse extends BaseResponse
{
    /**
     * Get Transaction Details.
     *
     * get details of the transaction
     *
     * @return array
     */
    public function getTransactionDetails(): array
    {
        return $this->_data->transaction_details;
    }
}