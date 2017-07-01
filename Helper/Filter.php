<?php
namespace PluginCompany\ContactForms\Helper;

use Magento\Cms\Model\Template\Filter as TemplateFilter;
use Magento\Email\Model\Source\Variables;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\State;
use Magento\Framework\DataObject;
use Magento\Framework\Escaper;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\StringUtils;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\View\LayoutFactory;
use Magento\Framework\View\LayoutInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Variable\Model\VariableFactory;
use Magento\Widget\Model\Template\Filter as ModelTemplateFilter;
use PluginCompany\ContactForms\Model\CustomerhelperFactory;
use PluginCompany\ContactForms\Model\ProducthelperFactory;
use Psr\Log\LoggerInterface;

class Filter
    extends TemplateFilter 
{
    /**
     * @var Registry
     */
    protected $_frameworkRegistry;

    /**
     * @var ProducthelperFactory
     */
    protected $_modelProducthelperFactory;

    /**
     * @var CustomerhelperFactory
     */
    protected $_modelCustomerhelperFactory;

    /**
     * @var ModelTemplateFilter
     */
    protected $_templateFilter;

    public function __construct(StringUtils $string, 
        LoggerInterface $logger, 
        Escaper $escaper, 
        Repository $assetRepo, 
        ScopeConfigInterface $scopeConfig, 
        VariableFactory $coreVariableFactory, 
        StoreManagerInterface $storeManager, 
        LayoutInterface $layout, 
        LayoutFactory $layoutFactory, 
        State $appState, 
        UrlInterface $urlModel, 
        \Pelago\Emogrifier $emogrifier, 
        Variables $configVariables, 
        Registry $frameworkRegistry, 
        ProducthelperFactory $modelProducthelperFactory, 
        CustomerhelperFactory $modelCustomerhelperFactory, 
        ModelTemplateFilter $templateFilter)
    {
        $this->_frameworkRegistry = $frameworkRegistry;
        $this->_modelProducthelperFactory = $modelProducthelperFactory;
        $this->_modelCustomerhelperFactory = $modelCustomerhelperFactory;
        $this->_templateFilter = $templateFilter;

        parent::__construct($string, $logger, $escaper, $assetRepo, $scopeConfig, $coreVariableFactory, $storeManager, $layout, $layoutFactory, $appState, $urlModel, $emogrifier, $configVariables);
    }

    
    protected $_customer;
    
    protected function _getProduct()
    {
        $product = $this->_frameworkRegistry->registry('current_product');
        if($product && $product->getId()){
            return $this->_modelProducthelperFactory->create()->load($product->getId());
        }
    }
    
    protected function _getCustomer()
    {
        if($this->_customer){
            return $this->_customer;
        }
        
        $customer = ObjectManager::getInstance()->get('Magento\Customer\Model\Session')->getCustomer();
        if($customer && $customer->getId()){
            $this->_customer = $this->_modelCustomerhelperFactory->create()->load($customer->getId());
        }else{
            $this->_customer = new DataObject();
        }
        return $this->_customer;
    }
    
    public function filterContactForm($html)
    {
        $tVars = [];
        $tVars['product'] = $this->_getProduct();
        $tVars['customer'] = $this->_getCustomer();
        $tVars['billing_address'] = $this->_getCustomer()->getDefaultBillingAddress();
        $tVars['shipping_address'] = $this->_getCustomer()->getDefaultShippingAddress();
        $tVars['category'] = $this->_frameworkRegistry->registry('current_category');
        $tVars['store'] = $this->_modelStoreManagerInterface->getStore();

        $this->setVariables($tVars);
        $html = $this->filter($html);
        return $this->_templateFilter->filter($html);
    }
}
