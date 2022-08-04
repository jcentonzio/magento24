<?php

namespace Cento\Automation\Plugin;

class LoginPostPlugin
{

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManagerInterface;

    /**
     * @var \Magento\Store\Api\StoreCookieManagerInterface $_storeCookieManager
     */
    protected $_storeCookieManager;

    /**
     * @var \Magento\Store\Api\StoreRepositoryInterface $_storeRepository
     */
    protected $_storeRepository;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface,
        \Magento\Store\Api\StoreCookieManagerInterface $storeCookieManager,
        \Magento\Store\Api\StoreRepositoryInterface $storeRepository
    ) {
        $this->_storeManagerInterface = $storeManagerInterface;
        $this->_storeCookieManager = $storeCookieManager;
        $this->_storeRepository = $storeRepository;
    }


    public function afterExecute(\Magento\Customer\Controller\Account\LoginPost $subject, $result)
    {
        //-- check group is retail customer or not
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');
        if ($customerSession->isLoggedIn()){
            $groupId = $customerSession->getCustomerGroupId();
            if ($groupId == 2){
                $store = $this->_storeRepository->getActiveStoreByCode('whole');
                $this->_storeCookieManager->setStoreCookie($store);
            }
        }
        return $result;
    }
}
