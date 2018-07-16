<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */
namespace PluginCompany\ContactForms\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject;
use Magento\Store\Model\ScopeInterface;
use \Magento\Framework\Mail\Template\TransportBuilder;

class Mailer extends TransportBuilder
{

    private $mailData;
    /** @var  \PluginCompany\ContactForms\Model\Entry */
    private $entry;

    public function sendCustomerNotification()
    {
        if(!$this->getEntry()){
            $this->throwNoEntryLoadedException();
        }

        $this->initMailData();

        $entry = $this->getEntry();

        $this->mailData
            ->setToEmail(
                $entry->getCustomerEmail()
            )->setToName(
                $entry->getCustomerName()
            )->setBcc(
                ($entry->getCustomerBcc() ? explode(',', $entry->getCustomerBcc()) : null)
            )->setBody(
                $entry->getCustomerNotification()
            )->setSubject(
                $entry->getCustomerSubject()
            )->setFromName(
                $entry->getSenderName()
            )->setFromEmail(
                $entry->getSenderEmail()
            )
            ->setReplyTo(null)
        ;
        $this->sendMail();

        return $this;
    }

    private function throwNoEntryLoadedException()
    {
        throw new \Exception("No entry loaded, unable to send e-mail");
    }

    private function initMailData()
    {
//        if(empty($this->mailData)){
        $this->mailData = new DataObject();
//        }
        return $this;
    }

    public function getEntry()
    {
        return $this->entry;
    }

    public function setEntry($entry)
    {
        $this->entry = $entry;
        return $this;
    }

    public function sendAdminNotification()
    {
        if(!$this->getEntry()){
            $this->throwNoEntryLoadedException();
        }

        $this->initMailData();

        $entry = $this->getEntry();

        $this->mailData
            ->setToEmail(
                $entry->getAdminEmail()
            )->setToName(
                null
            )->setBcc(
                ($entry->getAdminBcc() ? explode(',', $entry->getAdminBcc()) : null)
            )->setBody(
                $entry->getAdminNotification()
            )->setSubject(
                $entry->getAdminSubject()
            )->setFromName(
                $entry->getAdminSenderName()
            )->setFromEmail(
                $entry->getAdminSenderEmail()
            )->setReplyTo(
                $entry->getAdminReplyToEmail()
            )->setAttachments(
                $this->getAttachments()
            )
        ;
        $this->sendMail();

        return $this;
    }

    public function getAttachments()
    {
        if(!$this->attachmentsAllowed()) {
            return [];
        }
        return $this->getEntry()->getAllUploadedFilePaths();
    }

    public function attachmentsAllowed()
    {
        /** @var \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig */
        $scopeConfig = $this->objectManager->create('\Magento\Framework\App\Config\ScopeConfigInterface');
        return $scopeConfig->isSetFlag('plugincompany_contactforms/admin_notification/include_uploads', 'store');
    }

    /**
     * Send Customer Comment e-mail message
     *
     * @param Entry $entry
     * @return $this|bool
     */
    public function sendCommentNotification(Entry $entry, $comment)
    {
        $form = $entry->getParentForm();
        $params = $entry->getParamsArray();

        $params['comment_text'] = nl2br($comment);
        $params['customer_name'] = $entry->getCustomerName();

        $mailData = [];

        //use name or else firstname and lastname as recipient title
        $mailData['to_name'] = $entry->getCustomerName();
        $mailData['to_email'] = $entry->getCustomerEmail();
        $mailData['from_name'] = $form->getMailVar('customer_from_name');
        $mailData['from_email'] = $form->getMailVar('customer_from_email');
        $mailData['body'] = $this->_getCommentTemplate($entry->getStoreId());
        $mailData['subject'] = $this->_getCommentNotificationSubject($entry->getStoreId());
        $mailData['bcc'] = $form->getMailVar('customer_mail_bcc');

        //insert variables into e-mail data
        $mailData = $this->insertVariables($mailData,$params);

        //create parameter object
        $paramsObj = new DataObject();
        $paramsObj
            ->setData($mailData)
            ->setCanSendMail(true);

        //event hook
        $this->_eventManagerInterface->dispatch('pc_contactforms_comment_notify_before', ['entry' => $entry, 'comment' => $comment]);

        //send e-mail
        if($paramsObj->getCanSendMail()){
            $mailData = $paramsObj->getData();
            $this->sendMail($mailData);

            $this->_eventManagerInterface->dispatch('pc_contactforms_comment_notify_after', ['entry' => $entry, 'comment' => $comment]);
        }

        return $this;

    }

    public function sendMail()
    {
        $mailData = $this->mailData;
        $message = $this->message;
        $message
            ->setBody($mailData->getBody())
            ->setSubject($mailData->getSubject())
            ->setFrom($mailData->getFromEmail(), $mailData->getFromName())
            ->setReplyTo($mailData->getReplyTo())
            ->addTo($this->getToEmail(), $mailData->getToName())
        ;
        //bcc needs to be checked for SendGrid extension compatibility
        if($this->getBcc()){
            $message->addBcc($this->getBcc());
        }
        $this->addAttachmentsToMessage($message, $mailData->getAttachments());
        $this->getTransport()->sendMessage();
        return $this;
    }

    private function addAttachmentsToMessage($message, $paths)
    {
        if(!is_array($paths)){
            return $this;
        }
        foreach($paths as $filePath) {
            if (!file_exists($filePath)) {
                continue;
            }
            $message->createAttachment(
                file_get_contents($filePath),
                finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filePath),
                \Zend_Mime::DISPOSITION_ATTACHMENT,
                \Zend_Mime::ENCODING_BASE64,
                $this->getFileNameFromPath($filePath)
            );
        }
        return $this;
    }

    private function getFileNameFromPath($path)
    {
        $parts = explode('/', $path);
        return array_pop($parts);
    }

    public function getToEmail()
    {
        return $this->explodeIfCommaDelimited(
            $this->mailData->getData('to_email')
        );
    }

    public function getBcc()
    {
        return $this->explodeIfCommaDelimited(
            $this->mailData->getData('bcc')
        );
    }

    private function explodeIfCommaDelimited($mail)
    {
        if(!is_array($mail) && stristr($mail,',')){
            return explode(',', $mail);
        }
        return $mail;
    }

    /**
     * Prepare message
     *
     * @return $this
     */
    protected function prepareMessage()
    {
        try{
            $this->message
                ->setMessageType('text/html');
            $this->message
                ->setBodyHtml($this->mailData->getBody());
        }catch(\Exception $e){
            $bla = 1;
        }
        return $this;
    }

    protected function _getCommentTemplate($storeId)
    {
        return $this->_configScopeConfigInterface->getValue('plugincompany_contactforms/customer_notification/comment_template', ScopeInterface::SCOPE_STORE,$storeId);
    }

    protected function _getCommentNotificationSubject($storeId)
    {
        return $this->_configScopeConfigInterface->getValue('plugincompany_contactforms/customer_notification/comment_subject', ScopeInterface::SCOPE_STORE,$storeId);
    }

}
