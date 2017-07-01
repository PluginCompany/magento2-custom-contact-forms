<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */
namespace PluginCompany\ContactForms\Controller\Form\Visualcaptcha;

class Audio extends AbstractCaptcha
{
    public function runExecute()
    {
        $captcha = $this->getCaptcha();
        if ( ! $captcha->streamAudio( array(), 'mp3') ) {
            echo 'pass?';
        }
        exit;
    }
}