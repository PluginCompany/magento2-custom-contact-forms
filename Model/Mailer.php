<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */
namespace PluginCompany\ContactForms\Model;

use Magento\Framework\DataObject;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Mail\Template\TransportBuilder;

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
        $this->mailData = new DataObject();
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

        $this->setBodyHtmlToMessage();
        $this->addAttachmentsToMessage();

        $message
            ->setSubject($mailData->getSubject())
            ->setFrom($mailData->getFromEmail(), $mailData->getFromName())
            ->addTo($this->getToEmail(), $mailData->getToName())
        ;
        if($mailData->getReplyTo()) {
            $message->setReplyTo($mailData->getReplyTo());
        }
        //bcc needs to be checked for SendGrid extension compatibility
        if($this->getBcc()){
            $message->addBcc($this->getBcc());
        }
        $this->getTransport()->sendMessage();
        return $this;
    }

    private function setBodyHtmlToMessage()
    {
        if($this->isMagento23Plus()) {
            $this->message->setBodyHtml($this->mailData->getBody());
            return $this;
        }
        $this->message
            ->setMessageType('text/html')
            ->setBody($this->mailData->getBody());
        return $this;
    }

    /**
     * @param $paths
     * @return $this
     */
    private function addAttachmentsToMessage()
    {
        $paths = $this->mailData->getAttachments();
        if(!is_array($paths)){
            return $this;
        }
        foreach($paths as $filePath) {
            if (!file_exists($filePath)) {
                continue;
            }
            $this->addAttachment($filePath);
        }
        return $this;
    }

    private function addAttachment($filePath)
    {
        if($this->isMagento23Plus()) {
            return $this->addAttachment23Plus($filePath);
        }
        return $this->addAttachment23Below($filePath);
    }

    private function addAttachment23Plus($filePath)
    {
        $mp = new \Zend\Mime\Part(file_get_contents($filePath));
        $mp->type = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filePath);
        $mp->encoding = \Zend\Mime\Mime::ENCODING_BASE64;
        $mp->disposition = \Zend\Mime\Mime::DISPOSITION_ATTACHMENT;
        $mp->filename = $this->getFileNameFromPath($filePath);

        $body = $this->message->getBody();
        $body->addPart($mp);
        $this->message->setBodyHtml($body);

        return $this;
    }

    private function addAttachment23Below($filePath)
    {
        $this->message->createAttachment(
            file_get_contents($filePath),
            finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filePath),
            \Zend_Mime::DISPOSITION_ATTACHMENT,
            \Zend_Mime::ENCODING_BASE64,
            $this->getFileNameFromPath($filePath)
        );
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
            $mail = explode(',', $mail);
        }
        if(is_array($mail)) {
            $mail = array_map('trim', $mail);
        }
        return $mail;
    }

    protected function prepareMessage()
    {
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

    private function isMagento23Plus()
    {
        return version_compare($this->getMagentoVersion(), '2.3.0') >= 0;
    }

    private function getMagentoVersion()
    {
        return $this->getProductMetaData()->getVersion();
    }

    /**
     * @return \Magento\Framework\App\ProductMetadataInterface
     */
    private function getProductMetaData()
    {
        /** @var \Magento\Framework\App\ProductMetadataInterface $metaData */
        return $this->objectManager->create('\Magento\Framework\App\ProductMetadataInterface');
    }

}
