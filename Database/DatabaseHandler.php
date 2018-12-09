<?php

declare(strict_types=1);

namespace JannickVanG\DirectAdminApi\Database;


use JannickVanG\DirectAdminApi\DirectAdmin;
use JannickVanG\DirectAdminApi\DirectAdminResponse;
use JannickVanG\DirectAdminApi\Exceptions\Database\DA_CannotCreateDatabaseException;
use JannickVanG\DirectAdminApi\Exceptions\Database\DA_CannotDeleteDatabaseException;

class DatabaseHandler
{
    /**
     * @var DirectAdmin
     */
    private $directAdmin;

    /**
     * DatabaseHandler constructor.
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
        $options = array();

        $result = $this->directAdmin->getArray('CMD_API_DATABASES', $options);

        if (!isset($result['list'])) {
            return null;
        }
        return $result['list'];
    }

    /**
     * @param Database $database
     * @return DirectAdminResponse
     * @throws DA_CannotCreateDatabaseException
     */
    public function createDatabase(Database $database): DirectAdminResponse
    {
        $options = array(
            'action' => 'create',
            'user' => $database->getUsername(),
            'name' => $database->getDatabaseName(),
            'passwd' => $database->getPassword(),
            'passwd2' => $database->getPassword()
        );

        $response = $this->directAdmin->getDirectAdminResponse('CMD_API_DATABASES', $options);

        if ($response->isError()) {
            throw new DA_CannotCreateDatabaseException($response->getDetails());
        }
        return $response;
    }

    /**
     * @param string $databaseName
     * @return DirectAdminResponse
     * @throws DA_CannotDeleteDatabaseException
     */
    public function deleteDatabase(string $databaseName): DirectAdminResponse
    {
        $options = array(
            'action' => 'delete',
            'select0' => $this->directAdmin->getUsername().'_'.$databaseName
        );

        $response = $this->directAdmin->getDirectAdminResponse('CMD_API_DATABASES', $options);

        if ($response->isError()) {
            throw new DA_CannotDeleteDatabaseException($response->getDetails());
        }
        return $response;
    }
}