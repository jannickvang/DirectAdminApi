<?php

declare(strict_types=1);

namespace JannickVanG\DirectAdminApi\Email;

class VacationMessage
{
    /**
     * @var string
     */
    private $text;
    /**
     * @var DirectAdminTime
     */
    private $start;

    /**
     * @var DirectAdminTime
     */
    private $end;

    /**
     * @var EmailAccount
     */
    private $emailAccount;

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return DirectAdminTime
     */
    public function getStart(): DirectAdminTime
    {
        return $this->start;
    }

    /**
     * @param DirectAdminTime $start
     */
    public function setStart(DirectAdminTime $start): void
    {
        $this->start = $start;
    }

    /**
     * @return DirectAdminTime
     */
    public function getEnd(): DirectAdminTime
    {
        return $this->end;
    }

    /**
     * @param DirectAdminTime $end
     */
    public function setEnd(DirectAdminTime $end): void
    {
        $this->end = $end;
    }

    /**
     * @return EmailAccount
     */
    public function getEmailAccount(): EmailAccount
    {
        return $this->emailAccount;
    }

    /**
     * @param EmailAccount $emailAccount
     */
    public function setEmailAccount(EmailAccount $emailAccount): void
    {
        $this->emailAccount = $emailAccount;
    }
}