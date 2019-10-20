<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */
namespace PluginCompany\ContactForms\Controller\Form\Visualcaptcha;

class Image extends AbstractCaptcha
{
    public function runExecute()
    {
        $index = $this->getRequest()->getParam('index');
        $retina = $this->getRequest()->getParam('retina');

        $captcha = $this->getCaptcha();
        $image = $captcha->streamImage(
            array(),
            $index,
            $retina
        );
        $this->streamFile($image);
    }
}