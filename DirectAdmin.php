<?php
declare(strict_types=1);

namespace JannickVanG\DirectAdminApi;


class DirectAdmin
{

    /**
     * @var string
     */
    private $domain;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $serverIp;

    public function __construct(string $domain, string $serverIp, string $username, string $password)
    {
        $this->domain = $domain;
        $this->serverIp = $serverIp;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getServerIp(): string
    {
        return $this->serverIp;
    }

    /**
     * @param string $endPoint
     * @param array $options
     * @return DirectAdminResponse
     */
    public function getDirectAdminResponse(string $endPoint, array $options): DirectAdminResponse
    {
        $postString = $this->transformArrayToString($options);

        $result = $this->curl($endPoint, $postString);
        return new DirectAdminResponse($this->resultToArray($result));
    }

    public function getArray(string $endPoint, array $options): array
    {
        $postString = $this->transformArrayToString($options);

        $result = $this->curl($endPoint, $postString);
        return $this->resultToArray($result);
    }

    /**
     * @param array $options
     * @return string
     */
    public function transformArrayToString(array $options): string
    {
        if (!isset($options['domain'])) {
            $options['domain'] = $this->getDomain();
        }

        $postString = '';
        foreach ($options as $name => $value) {
            $postString .= $name . '=' . $value . '&';
        }
        $postString = substr($postString, 0, -1);
        return $postString;
    }

    /**
     * @param string $endPoint
     * @param $postString
     * @return string
     */
    private function curl(string $endPoint, $postString): string
    {
        $curl = curl_init($this->serverIp . ':2222/' . $endPoint);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postString);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    /**
     * @param string $result
     * @return array
     */
    private function resultToArray(string $result): array
    {
        parse_str($result, $array);
        return $array;
    }
}