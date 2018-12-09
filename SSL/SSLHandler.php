<?php

declare(strict_types=1);

namespace JannickVanG\DirectAdminApi\SSL;


use JannickVanG\DirectAdminApi\DirectAdmin;
use JannickVanG\DirectAdminApi\DirectAdminResponse;
use JannickVanG\DirectAdminApi\Exceptions\SSL\DA_CannotExecuteYourRequestException;
use JannickVanG\DirectAdminApi\Exceptions\SSL\DA_DomainNameArrayCannotBeEmptyExtension;

class SSLHandler
{
    private $directAdmin;

    public function __construct(DirectAdmin $directAdmin)
    {
        $this->directAdmin = $directAdmin;
    }

    /**
     * @param array $domainNames
     * @return DirectAdminResponse
     * @throws DA_CannotExecuteYourRequestException
     * @throws DA_DomainNameArrayCannotBeEmptyExtension
     */
    public function createLetsencryptCertificate(array $domainNames)
    {
        if (empty($domainNames)) {
            throw new DA_DomainNameArrayCannotBeEmptyExtension();
        }

        $options = array(
            'action' => 'save',
            'background' => 'auto',
            'type' => 'create',
            'request' => 'letsencrypt',
            'country' => '',
            'province' => '',
            'city' => '',
            'company' => '',
            'division' => '',
            'email' => '',
            'name' => 'www.'.$this->directAdmin->getDomain(),
            'keysize' => '4096',
            'encryption' => 'sha256',
            'le_wc_select0' => '*.'.$this->directAdmin->getDomain(),
            'le_wc_select1' => $this->directAdmin->getDomain(),
            'certificate' => '',
            'submit' => 'Save'
        );

        array_unshift($domainNames, $this->directAdmin->getDomain());
        $domainNames = array_unique($domainNames);
        foreach ($domainNames as $key => $domainName) {
            $options['le_select'.$key] = $domainName;
        }

        $response = $this->directAdmin->getDirectAdminResponse('CMD_API_SSL',$options);

        if ($response->isError()) {
            throw new DA_CannotExecuteYourRequestException($response->getDetails());
        }
        return $response;
    }
}