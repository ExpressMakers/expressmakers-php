<?php

namespace ExpressMakers\API\Responses;

/**
 * Class GetOrdersResponse.
 *
 * @author Pezhvak <pezhvak@imvx.org>
 *
 * @property int $current_page
 * @property string $first_page_url
 * @property int $from
 * @property int $last_page
 * @property string $last_page_url
 * @property string $next_page_url
 * @property string $path
 * @property int $per_page
 * @property string $prev_page_url
 * @property int $to
 * @property int $total
 */
class GetOrdersResponse extends BaseResponse
{
    /**
     * Get Orders.
     *
     * array of all orders
     *
     * @return array
     */
    public function getOrders(): array
    {
        return $this->_data->data;
    }
}