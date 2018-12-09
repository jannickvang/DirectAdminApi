<?php

declare(strict_types=1);

namespace JannickVanG\DirectAdminApi\Domain;


use JannickVanG\DirectAdminApi\DirectAdmin;
use JannickVanG\DirectAdminApi\DirectAdminResponse;
use JannickVanG\DirectAdminApi\Exceptions\Domain\DA_CannotCreateDomainException;
use JannickVanG\DirectAdminApi\Exceptions\Domain\DA_CannotCreateSubDomainException;
use JannickVanG\DirectAdminApi\Exceptions\Domain\DA_CannotDeleteSubDomainException;

class DomainHandler
{
    /**
     * @var DirectAdmin
     */
    private $directAdmin;

    public function __construct(DirectAdmin $directAdmin)
    {
        $this->directAdmin = $directAdmin;
    }

    /**
     * @return array|null
     */
    public function getAllDomains(): ?array
    {
        $options = array();

        $result = $this->directAdmin->getArray('CMD_API_SHOW_DOMAINS', $options);

        if (!isset($result['list'])) {
            return null;
        }
        return $result['list'];
    }

    /**
     * @param Domain $domain
     * @return DirectAdminResponse
     * @throws DA_CannotCreateDomainException
     */
    public function createDomain(Domain $domain):DirectAdminResponse
    {
        $options = array(
            'action' => 'create',
            'domain' => $domain->getDomainName(),
            'bandwidth' => $domain->getBandwidth(),
            'quota' => $domain->getQuota(),
            'ssl' => $domain->isSsl() == true ? 'ON':'OFF',
            'cgi' => $domain->isCgi() == true ? 'ON':'OFF',
            'php' => $domain->isPhp() == true ? 'ON':'OFF',
        );

        $response = $this->directAdmin->getDirectAdminResponse('CMD_API_DOMAIN', $options);

        if ($response->isError()) {
            throw new DA_CannotCreateDomainException($response->getDetails());
        }
        return $response;
    }

    /**
     * @return array|null
     */
    public function getAllSubDomains(): ?array
    {
        $options = array();

        $result = $this->directAdmin->getArray('CMD_API_SUBDOMAINS', $options);

        if (!isset($result['list'])) {
            return null;
        }
        return $result['list'];
    }

    /**
     * @param string $domainName
     * @return DirectAdminResponse
     * @throws DA_CannotCreateSubDomainException
     */
    public function createSubDomain(string $domainName):DirectAdminResponse
    {
        $options = array(
            'action' => 'create',
            'subdomain' => $domainName
        );

        $response = $this->directAdmin->getDirectAdminResponse('CMD_API_SUBDOMAINS', $options);

        if ($response->isError()) {
            throw new DA_CannotCreateSubDomainException($response->getDetails());
        }
        return $response;
    }

    /**
     * @param string $domainName
     * @param bool $deleteContent
     * @return DirectAdminResponse
     * @throws DA_CannotDeleteSubDomainException
     */
    public function deleteSubDomain(string $domainName, bool $deleteContent = false): DirectAdminResponse
    {
        $options = array(
            'action' => 'delete',
            'select0' => $domainName,
            'contents' => $deleteContent == true ? 'yes':'no'
        );

        $response = $this->directAdmin->getDirectAdminResponse('CMD_API_SUBDOMAINS', $options);

        if ($response->isError()) {
            throw new DA_CannotDeleteSubDomainException($response->getDetails());
        }
        return $response;
    }
}