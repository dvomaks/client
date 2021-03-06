<?php

declare(strict_types=1);

/*
 * This file is part of the IOTA PHP package.
 *
 * (c) Benjamin Ansbach <benjaminansbach@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IOTA\RemoteApi\Actions\BroadcastTransactions;

use IOTA\RemoteApi\AbstractResult;

/**
 * Class Response.
 *
 * An empty response object from the broadcastTransactions request.
 *
 * @see https://iota.readme.io/docs/broadcasttransactions
 */
class Result extends AbstractResult
{
    /**
     * Gets the array version of the response.
     *
     * @return array
     */
    public function serialize(): array
    {
        return array_merge([], parent::serialize());
    }

    /**
     * Maps the response result to the predefined props.
     *
     * @throws \RuntimeException
     */
    protected function mapResults(): void
    {
    }
}
