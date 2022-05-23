<?php
namespace Magento\Customer\Model\Url;

/**
 * Interceptor class for @see \Magento\Customer\Model\Url
 */
class Interceptor extends \Magento\Customer\Model\Url implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Customer\Model\Session $customerSession, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\App\RequestInterface $request, \Magento\Framework\UrlInterface $urlBuilder, \Magento\Framework\Url\EncoderInterface $urlEncoder, ?\Magento\Framework\Url\DecoderInterface $urlDecoder = null, ?\Magento\Framework\Url\HostChecker $hostChecker = null)
    {
        $this->___init();
        parent::__construct($customerSession, $scopeConfig, $request, $urlBuilder, $urlEncoder, $urlDecoder, $hostChecker);
    }

    /**
     * {@inheritdoc}
     */
    public function getLoginUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getLoginUrl');
        return $pluginInfo ? $this->___callPlugins('getLoginUrl', func_get_args(), $pluginInfo) : parent::getLoginUrl();
    }

    /**
     * {@inheritdoc}
     */
    public function getLoginUrlParams()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getLoginUrlParams');
        return $pluginInfo ? $this->___callPlugins('getLoginUrlParams', func_get_args(), $pluginInfo) : parent::getLoginUrlParams();
    }

    /**
     * {@inheritdoc}
     */
    public function getLoginPostUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getLoginPostUrl');
        return $pluginInfo ? $this->___callPlugins('getLoginPostUrl', func_get_args(), $pluginInfo) : parent::getLoginPostUrl();
    }

    /**
     * {@inheritdoc}
     */
    public function getLogoutUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getLogoutUrl');
        return $pluginInfo ? $this->___callPlugins('getLogoutUrl', func_get_args(), $pluginInfo) : parent::getLogoutUrl();
    }

    /**
     * {@inheritdoc}
     */
    public function getDashboardUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDashboardUrl');
        return $pluginInfo ? $this->___callPlugins('getDashboardUrl', func_get_args(), $pluginInfo) : parent::getDashboardUrl();
    }

    /**
     * {@inheritdoc}
     */
    public function getAccountUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAccountUrl');
        return $pluginInfo ? $this->___callPlugins('getAccountUrl', func_get_args(), $pluginInfo) : parent::getAccountUrl();
    }

    /**
     * {@inheritdoc}
     */
    public function getRegisterUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getRegisterUrl');
        return $pluginInfo ? $this->___callPlugins('getRegisterUrl', func_get_args(), $pluginInfo) : parent::getRegisterUrl();
    }

    /**
     * {@inheritdoc}
     */
    public function getRegisterPostUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getRegisterPostUrl');
        return $pluginInfo ? $this->___callPlugins('getRegisterPostUrl', func_get_args(), $pluginInfo) : parent::getRegisterPostUrl();
    }

    /**
     * {@inheritdoc}
     */
    public function getEditUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getEditUrl');
        return $pluginInfo ? $this->___callPlugins('getEditUrl', func_get_args(), $pluginInfo) : parent::getEditUrl();
    }

    /**
     * {@inheritdoc}
     */
    public function getEditPostUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getEditPostUrl');
        return $pluginInfo ? $this->___callPlugins('getEditPostUrl', func_get_args(), $pluginInfo) : parent::getEditPostUrl();
    }

    /**
     * {@inheritdoc}
     */
    public function getForgotPasswordUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getForgotPasswordUrl');
        return $pluginInfo ? $this->___callPlugins('getForgotPasswordUrl', func_get_args(), $pluginInfo) : parent::getForgotPasswordUrl();
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailConfirmationUrl($email = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getEmailConfirmationUrl');
        return $pluginInfo ? $this->___callPlugins('getEmailConfirmationUrl', func_get_args(), $pluginInfo) : parent::getEmailConfirmationUrl($email);
    }
}
