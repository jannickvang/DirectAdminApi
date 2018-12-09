<?php

declare(strict_types=1);

namespace JannickVanG\DirectAdminApi\DomainPointer;


use JannickVanG\DirectAdminApi\DirectAdmin;
use JannickVanG\DirectAdminApi\DirectAdminResponse;
use JannickVanG\DirectAdminApi\Exceptions\DomainPointer\DA_UnableToAddDomainPointer;
use JannickVanG\DirectAdminApi\Exceptions\DomainPointer\DA_UnableToDeleteDomainPointer;

class DomainPointerHandler
{
    /**
     * @var DirectAdmin
     */
    private $directAdmin;

    /**
     * DomainPointerHandler constructor.
     * @param DirectAdmin $directAdmin
     */
    public function __construct(DirectAdmin $directAdmin)
    {
        $this->directAdmin = $directAdmin;
    }

    /**
     * @param string $domainName
     * @return DirectAdminResponse
     * @throws DA_UnableToAddDomainPointer
     */
    public function createDomainAlias(string $domainName): DirectAdminResponse
    {
        $options = array(
            'action' => 'add',
            'from' => $domainName,
            'alias' => 'yes'
        );

        $response = $this->directAdmin->getDirectAdminResponse('CMD_API_DOMAIN_POINTER', $options);

        if ($response->isError()) {
            throw new DA_UnableToAddDomainPointer($response->getDetails());
        }
        return $response;
    }

    /**
     * @param string $domainName
     * @return DirectAdminResponse
     * @throws DA_UnableToAddDomainPointer
     */
    public function createDomainPointer(string $domainName): DirectAdminResponse
    {
        $options = array(
            'action' => 'add',
            'from' => $domainName
        );

        $response = $this->directAdmin->getDirectAdminResponse('CMD_API_DOMAIN_POINTER', $options);

        if ($response->isError()) {
            throw new DA_UnableToAddDomainPointer($response->getDetails());
        }
        return $response;
    }

    /**
     * @param string $domainName
     * @return DirectAdminResponse
     * @throws DA_UnableToDeleteDomainPointer
     */
    public function deleteDomainPointer(string $domainName): DirectAdminResponse
    {
        $options = array(
            'action' => 'delete',
            'select2' => $domainName,
            'delete' => 'Delete'
        );

        $response = $this->directAdmin->getDirectAdminResponse('CMD_API_DOMAIN_POINTER', $options);

        if ($response->isError()) {
            throw new DA_UnableToDeleteDomainPointer($response->getDetails());
        }
        return $response;
    }
}