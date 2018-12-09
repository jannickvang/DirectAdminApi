<?php

declare(strict_types=1);

namespace JannickVanG\DirectAdminApi\Ftp;


use JannickVanG\DirectAdminApi\DirectAdmin;
use JannickVanG\DirectAdminApi\DirectAdminResponse;
use JannickVanG\DirectAdminApi\Exceptions\SSL\DA_CannotExecuteYourRequestException;

class FtpHandler
{
    /**
     * @var DirectAdmin
     */
    private $directAdmin;

    /**
     * FtpHandler constructor.
     * @param DirectAdmin $directAdmin
     */
    public function __construct(DirectAdmin $directAdmin)
    {
        $this->directAdmin = $directAdmin;
    }

    /**
     * @return array
     */
    public function getAllFtpUsers(): array
    {
        $options = array(
            'action' => 'list'
        );

        $response = $this->directAdmin->getArray('CMD_API_FTP', $options);

        $responseArray = array();
        foreach ($response as $email => $path) {
            $responseArray[] = array('username' => $email, 'path' => $path);
        }

        return $responseArray;
    }

    /**
     * @param FtpUser $ftpUser
     * @return DirectAdminResponse
     * @throws DA_CannotExecuteYourRequestException
     */
    public function createFtpUser(FtpUser $ftpUser): DirectAdminResponse
    {
        $options = array(
            'fakeusernameremembered' => '',
            'fakepasswordremembered' => '',
            'action' => 'create',
            'create' => 'Create',
            'user' => $ftpUser->getUsername(),
            'passwd' => $ftpUser->getPassword(),
            'passwd2' => $ftpUser->getPassword(),
            'random' => 'Save Password',
            'type' => 'custom',
            'custom_val' => $ftpUser->getDir()
        );

        $response = $this->directAdmin->getDirectAdminResponse('CMD_API_FTP', $options);

        if ($response->isError()) {
            throw new DA_CannotExecuteYourRequestException($response->getDetails());
        }
        return $response;
    }

    /**
     * @param FtpUser $ftpUser
     * @return DirectAdminResponse
     * @throws DA_CannotExecuteYourRequestException
     */
    public function editFtpUser(FtpUser $ftpUser): DirectAdminResponse
    {
        $options = array(
            'action' => 'modify',
            'create' => 'Modify',
            'user' => $ftpUser->getUsername(),
            'passwd' => $ftpUser->getPassword(),
            'passwd2' => $ftpUser->getPassword(),
            'random' => 'Save Password',
            'type' => 'custom',
            'custom_val' => $ftpUser->getDir()
        );

        $response = $this->directAdmin->getDirectAdminResponse('CMD_API_FTP', $options);

        if ($response->isError()) {
            throw new DA_CannotExecuteYourRequestException($response->getDetails());
        }
        return $response;
    }

    /**
     * @param string $username
     * @return DirectAdminResponse
     */
    public function deleteFtpUser(string $username): DirectAdminResponse
    {
        $options = array(
            'action' => 'delete',
            'delete' => 'Delete Selected',
            'select1' => $username
        );

        $response = $this->directAdmin->getDirectAdminResponse('CMD_API_FTP', $options);

        return $response;
    }
}