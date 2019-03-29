<?php
namespace PluginCompany\ContactForms\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Helper\View;

/**
 * Customer section
 */
class Customer implements SectionSourceInterface
{
    /**
     * @var CurrentCustomer
     */
    protected $currentCustomer;

    /**
     * @var View
     */
    private $customerViewHelper;

    /**
     * @var \Magento\Customer\Model\Data\Customer
     */
    private $customerDataObject;

    /**
     * @param CurrentCustomer $currentCustomer
     * @param View $customerViewHelper
     */
    public function __construct(
        CurrentCustomer $currentCustomer,
        View $customerViewHelper
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->customerViewHelper = $customerViewHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getSectionData()
    {
        if (!$this->currentCustomer->getCustomerId()) {
            return [];
        }

        $this->customerDataObject = $this->currentCustomer->getCustomer();

        return [
            'customer' => $this->getCustomerData(),
            'billing_address' => $this->getBillingAddressData(),
            'shipping_address' => $this->getShippingAddressData(),
        ];
    }

    private function getCustomerData()
    {
        return [
            'fullname' => $this->customerViewHelper->getCustomerName($this->customerDataObject),
            'firstname' => $this->customerDataObject->getFirstname(),
            'name' => $this->customerDataObject->getFirstname(),
            'websiteId' => $this->customerDataObject->getWebsiteId()
        ] + $this->customerDataObject->__toArray();
    }

    private function getBillingAddressData()
    {
        if(empty($this->customerDataObject->getAddresses())) {
            return [];
        }
        $billingId = $this->customerDataObject->getDefaultBilling();
        if(!$billingId) return [];

        return $this->getAddressDataById($billingId);
    }

    private function getShippingAddressData()
    {
        if(empty($this->customerDataObject->getAddresses())) {
            return [];
        }
        $shippingId = $this->customerDataObject->getDefaultShipping();
        if(!$shippingId) return [];

        return $this->getAddressDataById($shippingId);
    }

    private function getAddressDataById($id)
    {
        foreach($this->customerDataObject->getAddresses() as $address) {
            if($address->getId() == $id) {
                return $this->getFormattedAddressData($address);
            }
        }
        return [];
    }

    private function getFormattedAddressData(\Magento\Customer\Model\Data\Address $address)
    {
        $data = $address->__toArray();
        if(!empty($data['region']) && is_array($data['region'])) {
            $data = $data['region'] + $data;
        }
        if(!empty($data['street'])) {
            $streets = $data['street'];
            foreach($streets as $index => $street) {
                if($index == 0 ) {
                    $index = '';
                }
                $data['street' . $index] = $street;
            }
            $data['street_full'] = implode(PHP_EOL, $streets);
        }
        return $data;
    }
}
