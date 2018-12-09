<?php

declare(strict_types=1);

namespace JannickVanG\DirectAdminApi;


class DirectAdminResponse
{
    /**
     * @var bool
     */
    private $error = false;

    /**
     * @var string|null
     */
    private $text;

    /**
     * @var string|null
     */
    private $details;

    /**
     * @var string|null
     */
    private $success;

    public function __construct(array $results)
    {
        $this->error = (bool)$results['error'];
        if (isset($results['text'])) {
            $this->text = $results['text'];
        }
        if (isset($results['details'])) {
            $this->details = str_replace('<br>', '', $results['details']);
        }
        if (isset($results['success'])) {
            $this->success = $results['success'];
        }
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->error;
    }

    /**
     * @return null|string
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return null|string
     */
    public function getDetails(): ?string
    {
        return $this->details;
    }

    /**
     * @return null|string
     */
    public function getSuccess(): ?string
    {
        return $this->success;
    }
}