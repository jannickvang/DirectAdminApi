<?php

declare(strict_types=1);

namespace JannickVanG\DirectAdminApi\Email;


use JannickVanG\DirectAdminApi\DirectAdmin;
use JannickVanG\DirectAdminApi\DirectAdminResponse;
use JannickVanG\DirectAdminApi\Exceptions\Email\DA_UnableToCreateVacationMessageException;
use JannickVanG\DirectAdminApi\Exceptions\Email\DA_UnableToEditVacationMessageException;

class VacationMessageHandler
{
    /**
     * @var DirectAdmin
     */
    private $directAdmin;

    /**
     * VacationMessageHandler constructor.
     * @param DirectAdmin $directAdmin
     */
    public function __construct(DirectAdmin $directAdmin)
    {
        $this->directAdmin = $directAdmin;
    }

    /**
     * @param VacationMessage $vacationMessage
     * @return DirectAdminResponse
     * @throws DA_UnableToCreateVacationMessageException
     */
    public function createVacationMessage(VacationMessage $vacationMessage): DirectAdminResponse
    {
        $options = array(
            'action' => 'create',
            'create' => 'Create',
            'subject' => 'Autoreply',
            'reply_encoding' => 'iso-8859-1',
            'reply_content_type' => 'text/plain',
            'reply_once_time' => '2d',
            'text' => $vacationMessage->getText(),
            'user' => $vacationMessage->getEmailAccount()->getName(),
            'starttime' => $vacationMessage->getStart()->getTime(),
            'startmonth' => $vacationMessage->getStart()->getMonth(),
            'startday' => $vacationMessage->getStart()->getDay(),
            'startyear' => $vacationMessage->getStart()->getYear(),
            'endtime' => $vacationMessage->getEnd()->getTime(),
            'endmonth' => $vacationMessage->getEnd()->getMonth(),
            'endday' => $vacationMessage->getEnd()->getDay(),
            'endyear' => $vacationMessage->getEnd()->getYear(),
        );

        $response = $this->directAdmin->getDirectAdminResponse('CMD_API_EMAIL_VACATION', $options);

        if ($response->isError()) {
            throw new DA_UnableToCreateVacationMessageException($response->getDetails());
        }
        return $response;
    }

    /**
     * @param VacationMessage $vacationMessage
     * @return DirectAdminResponse
     * @throws DA_UnableToEditVacationMessageException
     */
    public function editVacationMessage(VacationMessage $vacationMessage): DirectAdminResponse
    {
        $options = array(
            'action' => 'modify',
            'create' => 'Modify',
            'subject' => 'Autoreply',
            'reply_encoding' => 'iso-8859-1',
            'reply_content_type' => 'text/plain',
            'reply_once_time' => '2d',
            'text' => $vacationMessage->getText(),
            'user' => $vacationMessage->getEmailAccount()->getName(),
            'starttime' => $vacationMessage->getStart()->getTime(),
            'startmonth' => $vacationMessage->getStart()->getMonth(),
            'startday' => $vacationMessage->getStart()->getDay(),
            'startyear' => $vacationMessage->getStart()->getYear(),
            'endtime' => $vacationMessage->getEnd()->getTime(),
            'endmonth' => $vacationMessage->getEnd()->getMonth(),
            'endday' => $vacationMessage->getEnd()->getDay(),
            'endyear' => $vacationMessage->getEnd()->getYear(),
        );

        $response = $this->directAdmin->getDirectAdminResponse('CMD_API_EMAIL_VACATION', $options);

        if ($response->isError()) {
            throw new DA_UnableToEditVacationMessageException($response->getDetails());
        }
        return $response;
    }

    /**
     * @param EmailAccount $emailAccount
     * @return DirectAdminResponse
     */
    public function deleteVacationMessageForEmailAccount(EmailAccount $emailAccount): DirectAdminResponse
    {
        $options = array(
            'select0' => $emailAccount->getName(),
            'delete' => 'Delete Selected',
            'action' => 'delete'
        );

        $response = $this->directAdmin->getDirectAdminResponse('CMD_API_EMAIL_VACATION', $options);

        return $response;
    }
}