<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */
namespace PluginCompany\ContactForms\Model\Template\FilterObjects;

use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Registry;

class Product extends DataObject
{
    private $product;
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    private $request;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var Registry
     */
    private $registry;

    public function __construct(
        RequestInterface $request,
        ProductRepository $productRepository,
        Registry $registry
    ){
        $this->request = $request;
        $this->productRepository = $productRepository;
        $this->registry = $registry;
        return $this;
    }

    public function __call($method, $args)
    {
        if(substr($method, 0, 3) == 'get') {
            $key = $this->_underscore(substr($method, 3));
            if($this->getProductResource() && $this->isAttribute($key)){
                return $this->getAttributeText($key);
            }
        }
        return $this->getProduct()->{$method}($args);
    }

    public function isAttribute($key)
    {
        return $this->getProductResource()->getAttribute($key);
    }

    public function getProductResource()
    {
        return $this->getProduct()->getResource();
    }

    public function getAttributeText($attributeCode)
    {
        $data = $this->getProduct()->getData($attributeCode);
        if(!$this->isAttrSelect($attributeCode)){
            return $data;
        }
        $text = $this->getProduct()->getAttributeText($attributeCode);
        if(is_array($text)){
            $text = implode(', ', $text);
        }
        return $text;
    }

    public function isAttrSelect($key){
        if($key == 'store_id'){
            return false;
        }
        $input = $this
            ->getResource()
            ->getAttribute($key)
            ->getFrontendInput()
        ;
        return in_array($input,array('select','multiselect'));
    }

    public function getProduct()
    {
        if(!$this->product){
            $this->initProduct();
        }
        return $this->product;
    }

    public function initProduct()
    {
        $product = $this->retrieveProduct();
        if($product) {
            return $this->setProduct($product);
        }
        return $this->setProduct(new DataObject());
    }

    private function retrieveProduct()
    {
        if($this->getProductFromRegistry()) {
            return $this->getProductFromRegistry();
        }
        if($this->getProductIdFromRequest()){
            return $this->getProductBasedOnRequest();
        }
        return false;
    }

    private function getProductFromRegistry()
    {
        $product = $this->registry->registry('product');
        if ($product && $product->getId()) {
            return $product;
        }
        return false;
    }

    private function getProductBasedOnRequest()
    {
        $productId = $this->getProductIdFromRequest();
        if ($productId) {
            return $this->getProductFromRepository($productId);
        }
        return false;
    }

    private function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    private function getProductIdFromRequest()
    {
        $handles = $this->getRequestHandles();
        foreach($handles as $handle){
            if(stristr($handle, 'catalog_product_view_id_')){
                return str_replace('catalog_product_view_id_', '', $handle);
            }
        }
        return false;
    }

    private function getRequestHandles()
    {
        $handles = json_decode($this->request->getQueryValue('handles'));
        if(!empty($handles)){
            return $handles;
        }
        return [];
    }

    private function getProductFromRepository($productId)
    {
        return $this->productRepository->getById($productId);
    }
}
