<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */
namespace PluginCompany\ContactForms\Controller\Form;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\File\Uploader;

class Removeupload extends Upload
{
    /**
     * Execute action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $this->checkCanRemoveFile();
            $this->removeUploadedFile();
        } catch (LocalizedException $e) {
            $this->getResponse()
                ->setHttpResponseCode(500);
            return $this->jsonResponse($e->getMessage());
        } catch (\Exception $e) {
            $this->getLogger()->critical($e);
            $this->getResponse()
                ->setHttpResponseCode(500);
            return $this->jsonResponse($e->getMessage());
        }
    }

    public function checkCanRemoveFile()
    {
        if(stristr($this->getFileName(),'/')){
            throw new LocalizedException(__('Forward slash in filename not allowed'));
        }
        if(stristr($this->getFileName(),'\\')){
            throw new LocalizedException(__('Backslash in filename not allowed'));
        }
        if(stristr($this->getFileName(),'*')){
            throw new LocalizedException(__('Wildcard * in filename not allowed'));
        }
    }

    private function getFileName()
    {
        $fileName = $this->_request->getParam('filename');
        return Uploader::getCorrectFileName($fileName);
    }

    public function removeUploadedFile()
    {
        try{
            $file = $this->getUploadDir() . $this->getFileName();
            if(stristr($file,'contactforms' . DIRECTORY_SEPARATOR . 'uploads')){
                $this->getIoFile()->rm($file);
            }
        }catch(\Exception $e) {
            $this->getLogger()->critical($e->getMessage());
            $this->throwRemoveFileError();
        }
        return $this;
    }

    private function throwRemoveFileError()
    {
        throw new LocalizedException(__('An error occured removing the file from filesystem'));
    }


}