<?php

declare(strict_types=1);

namespace JannickVanG\DirectAdminApi\Email;


use JannickVanG\DirectAdminApi\DirectAdmin;
use JannickVanG\DirectAdminApi\DirectAdminResponse;
use JannickVanG\DirectAdminApi\Exceptions\Email\DA_UnableToCreateEmailAccountException;
use JannickVanG\DirectAdminApi\Exceptions\Email\DA_UnableToDeleteEmailAccountException;
use JannickVanG\DirectAdminApi\Exceptions\Email\DA_UnableToEditEmailAccountException;

class EmailHandler
{
    /**
     * @var DirectAdmin
     */
    private $directAdmin;

    /**
     * Email constructor.
     * @param DirectAdmin $directAdmin
     */
    public function __construct(DirectAdmin $directAdmin)
    {
        $this->directAdmin = $directAdmin;
    }

    /**
     * @return array|null
     */
    public function getAll(): ?array
    {
        $options = array('action' => 'list');
        $result = $this->directAdmin->getArray('CMD_API_POP', $options);
        if (!isset($result['list'])) {
            return null;
        }
        return $result['list'];
    }

    //todo: useful? > need to check
    public function getAllQuota()
    {
        $options = array(
            'action' => 'list',
            'type' => 'quota'
        );
        return $this->directAdmin->getDirectAdminResponse('CMD_API_POP', $options);
    }

    /**
     * @param EmailAccount $account
     * @return DirectAdminResponse
     * @throws DA_UnableToCreateEmailAccountException
     */
    public function createAccount(EmailAccount $account): DirectAdminResponse
    {
        $options = array(
            'action' => 'create',
            'user' => $account->getName(),
            'passwd' => $account->getPassword(),
            'passwd2' => $account->getPassword(),
            'quota' => $account->getPassword()
        );

        $response = $this->directAdmin->getDirectAdminResponse('CMD_API_POP', $options);

        if ($response->isError()) {
            throw new DA_UnableToCreateEmailAccountException($response->getDetails());
        }

        return $response;
    }

    /**
     * @param EmailAccount $account
     * @return DirectAdminResponse
     * @throws DA_UnableToEditEmailAccountException
     */
    public function editAccount(EmailAccount $account): DirectAdminResponse
    {
        $options = array(
            'action' => 'modify',
            'user' => $account->getName(),
            'passwd' => $account->getPassword(),
            'passwd2' => $account->getPassword(),
            'quota' => $account->getQuota()
        );
        $response = $this->directAdmin->getDirectAdminResponse('CMD_API_POP', $options);

        if ($response->isError()) {
            throw new DA_UnableToEditEmailAccountException($response->getDetails());
        }

        return $response;
    }

    /**
     * @param string $username
     * @return DirectAdminResponse
     * @throws DA_UnableToDeleteEmailAccountException
     */
    public function deleteAccount(string $username): DirectAdminResponse
    {
        $options = array(
            'action' => 'delete',
            'user' => strtolower($username)
        );
        $response =  $this->directAdmin->getDirectAdminResponse('CMD_API_POP', $options);
        if ($response->isError()) {
            throw new DA_UnableToDeleteEmailAccountException($response->getDetails());
        }

        return $response;
    }
}