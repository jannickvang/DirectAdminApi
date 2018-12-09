<?php

declare(strict_types=1);

namespace JannickVanG\DirectAdminApi\Domain;


class Domain
{
    /**
     * @var string
     */
    private $domainName;

    /**
     * @var int
     */
    private $bandwidth = 1000;

    /**
     * @var int
     */
    private $quota = 0;

    /**
     * @var bool
     */
    private $ssl = true;

    /**
     * @var bool
     */
    private $cgi = false;

    /**
     * @var bool
     */
    private $php = true;

    /**
     * @return string
     */
    public function getDomainName(): string
    {
        return $this->domainName;
    }

    /**
     * @param string $domainName
     */
    public function setDomainName(string $domainName): void
    {
        $this->domainName = $domainName;
    }

    /**
     * @return int
     */
    public function getBandwidth(): int
    {
        return $this->bandwidth;
    }

    /**
     * @param int $bandwidth
     */
    public function setBandwidth(int $bandwidth): void
    {
        $this->bandwidth = $bandwidth;
    }

    /**
     * @return int
     */
    public function getQuota(): int
    {
        return $this->quota;
    }

    /**
     * @param int $quota
     */
    public function setQuota(int $quota): void
    {
        $this->quota = $quota;
    }

    /**
     * @return bool
     */
    public function isSsl(): bool
    {
        return $this->ssl;
    }

    /**
     * @param bool $ssl
     */
    public function setSsl(bool $ssl): void
    {
        $this->ssl = $ssl;
    }

    /**
     * @return bool
     */
    public function isCgi(): bool
    {
        return $this->cgi;
    }

    /**
     * @param bool $cgi
     */
    public function setCgi(bool $cgi): void
    {
        $this->cgi = $cgi;
    }

    /**
     * @return bool
     */
    public function isPhp(): bool
    {
        return $this->php;
    }

    /**
     * @param bool $php
     */
    public function setPhp(bool $php): void
    {
        $this->php = $php;
    }
}