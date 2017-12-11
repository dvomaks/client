<?php
/**
 * This file is part of the IOTA PHP package.
 *
 * (c) Benjamin Ansbach <benjaminansbach@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Techworker\IOTA;

/**
 * Class Node.
 *
 * Information about a node.
 */
class Node implements SerializeInterface
{
    /**
     * The host in the form of $scheme://$host:$port.
     *
     * @var string
     */
    protected $host;

    /**
     * The version of the api.
     *
     * @var int
     */
    protected $apiVersion;

    /**
     * The token.
     *
     * @var string|null
     */
    protected $token;

    /**
     * A flag indicating whether the node allows to call attachToTangle and does
     * the POW for you.
     *
     * @var bool
     */
    protected $doesPOW;

    /**
     * Node constructor.
     *
     * @param string      $host
     * @param bool        $doesPOW
     * @param int         $apiVersion
     * @param string|null $token
     */
    public function __construct(
                                string $host = 'http://localhost:14265',
                                bool $doesPOW = false,
                                int $apiVersion = 1,
                                string $token = null
    ) {
        $this->host = $host;
        $this->token = $token;
        $this->apiVersion = $apiVersion;
        $this->doesPOW = $doesPOW;
    }

    /**
     * Returns the URL to the commands endpoint.
     *
     * @return string
     */
    public function getCommandsEndpoint(): string
    {
        return sprintf('%s/commands', $this->host);
    }

    /**
     * Returns the URL to the commands endpoint.
     *
     * @param string $jobId
     *
     * @return string
     */
    public function getJobsEndpoint(string $jobId): string
    {
        return sprintf('%s/api/v%d/jobs/%s', $this->host, $this->apiVersion, $jobId);
    }

    /**
     * Gets the host of the node.
     *
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * Gets the api version of the node.
     *
     * @return int
     */
    public function getApiVersion(): int
    {
        return $this->apiVersion;
    }

    /**
     * Gets the token.
     *
     * @return null|string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Gets a value indicating whether the node does the POW for you.
     *
     * @return bool
     */
    public function doesPOW(): bool
    {
        return $this->doesPOW;
    }

    /**
     * Gets the serialized version of the node.
     *
     * @return array
     */
    public function serialize(): array
    {
        return [
            'host' => $this->host,
            'doesPOW' => $this->doesPOW(),
            'token' => $this->token,
            'apiVersion' => $this->apiVersion,
        ];
    }
}