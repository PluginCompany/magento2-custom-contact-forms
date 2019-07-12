<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */
namespace PluginCompany\ContactForms\Model\Template;

use Magento\Cms\Model\Template\Filter as CmsFilter;
use Magento\Email\Model\Template\Filter as EmailFilter;
use Magento\Email\Model\Template as EmailTemplate;
use Magento\Framework\Registry;
use Magento\Framework\DataObject;
use PluginCompany\ContactForms\Model\Template\FilterObjects\Customer;
use PluginCompany\ContactForms\Model\Template\FilterObjects\Product;

class Filter
{

    private $filter;
    private $registry;
    private $customer;
    private $product;
    /**
     * @var PrivateContentFilter
     */
    private $privateContentFilter;
    /**
     * @var EmailFilter
     */
    private $emailFilter;

    /**
     * Filter constructor.
     * @param CmsFilter $filter
     * @param EmailFilter $emailFilter
     * @param Registry $registry
     * @param Customer $customer
     * @param Product $product
     * @param EmailTemplate $emailTemplate
     * @param PrivateContentFilter $privateContentFilter
     */
    public function __construct(
        CmsFilter $filter,
        EmailFilter $emailFilter,
        Registry $registry,
        Customer $customer,
        Product $product,
        EmailTemplate $emailTemplate,
        PrivateContentFilter $privateContentFilter
    ){
        $this->filter = $filter;
        $this->emailFilter = $emailFilter;
        $this->customer = $customer;
        $this->product = $product;
        $this->registry = $registry;

        $this->filter->setTemplateProcessor([$emailTemplate, 'getTemplateContent']);
        $this->filter->setDesignParams($emailTemplate->getDesignParams());

        $this->emailFilter->setTemplateProcessor([$emailTemplate, 'getTemplateContent']);
        $this->emailFilter->setDesignParams($emailTemplate->getDesignParams());

        $this->privateContentFilter = $privateContentFilter;
    }

    public function initFrontEndVariables()
    {
        $this
            ->addCustomerVariables()
            ->addProductVariables()
            ->addCategoryVariables()
        ;
        return $this;
    }

    public function addCustomerVariables()
    {
        $this->setVariables(
            [
                'customer' => $this->getCurrentCustomer(),
                'billing_address' => $this->getCurrentBillingAddress(),
                'shipping_address' => $this->getCurrentShippingAddress()
            ]
        );
        return $this;
    }

    public function getCurrentCustomer()
    {
        return $this->customer;
    }

    public function getCurrentBillingAddress()
    {
        return $this
            ->getCurrentCustomer()
            ->getDefaultBillingAddress();
    }

    public function getCurrentShippingAddress()
    {
        return $this
            ->getCurrentCustomer()
            ->getDefaultShippingAddress();
    }

    public function addProductVariables()
    {
        $this->setVariables(
            ['product' => $this->getCurrentProduct()]
        );
        return $this;
    }

    /**
     * @return Product
     */
    public function getCurrentProduct()
    {
        return $this->product;
    }

    public function addCategoryVariables()
    {
        $this->setVariables(
            ['category' => $this->getCurrentCategory()]
        );
        return $this;
    }

    /**
     * @return Category
     */
    public function getCurrentCategory()
    {
        $category = $this->registry->registry('current_category');
        if (!$category || !$category->getId()) {
            $category = new DataObject();
        }

        return $category;
    }

    public function setVariables($variables)
    {
        $this->filter
            ->setVariables($variables);
        $this->emailFilter
            ->setVariables($variables);
        return $this;
    }

    public function rewriteDefaultCustomerValuesToKo($string)
    {
        return $this->privateContentFilter->rewriteDefaultCustomerValuesToKo($string);
    }

    public function filter($string)
    {
        return $this->filter->filter($string);
    }

    public function getFilter()
    {
        return $this->filter;
    }

    public function filterForEmail($string)
    {
        return $this->emailFilter->filter($string);
    }

}


