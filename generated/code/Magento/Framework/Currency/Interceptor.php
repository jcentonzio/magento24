<?php
namespace Magento\Framework\Currency;

/**
 * Interceptor class for @see \Magento\Framework\Currency
 */
class Interceptor extends \Magento\Framework\Currency implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\CacheInterface $appCache, $options = null, $locale = null)
    {
        $this->___init();
        parent::__construct($appCache, $options, $locale);
    }

    /**
     * {@inheritdoc}
     */
    public function toCurrency($value = null, array $options = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toCurrency');
        return $pluginInfo ? $this->___callPlugins('toCurrency', func_get_args(), $pluginInfo) : parent::toCurrency($value, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function setFormat(array $options = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setFormat');
        return $pluginInfo ? $this->___callPlugins('setFormat', func_get_args(), $pluginInfo) : parent::setFormat($options);
    }

    /**
     * {@inheritdoc}
     */
    public function getSymbol($currency = null, $locale = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSymbol');
        return $pluginInfo ? $this->___callPlugins('getSymbol', func_get_args(), $pluginInfo) : parent::getSymbol($currency, $locale);
    }

    /**
     * {@inheritdoc}
     */
    public function getShortName($currency = null, $locale = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getShortName');
        return $pluginInfo ? $this->___callPlugins('getShortName', func_get_args(), $pluginInfo) : parent::getShortName($currency, $locale);
    }

    /**
     * {@inheritdoc}
     */
    public function getName($currency = null, $locale = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getName');
        return $pluginInfo ? $this->___callPlugins('getName', func_get_args(), $pluginInfo) : parent::getName($currency, $locale);
    }

    /**
     * {@inheritdoc}
     */
    public function getRegionList($currency = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getRegionList');
        return $pluginInfo ? $this->___callPlugins('getRegionList', func_get_args(), $pluginInfo) : parent::getRegionList($currency);
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrencyList($region = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCurrencyList');
        return $pluginInfo ? $this->___callPlugins('getCurrencyList', func_get_args(), $pluginInfo) : parent::getCurrencyList($region);
    }

    /**
     * {@inheritdoc}
     */
    public function toString()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toString');
        return $pluginInfo ? $this->___callPlugins('toString', func_get_args(), $pluginInfo) : parent::toString();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, '__toString');
        return $pluginInfo ? $this->___callPlugins('__toString', func_get_args(), $pluginInfo) : parent::__toString();
    }

    /**
     * {@inheritdoc}
     */
    public function setLocale($locale = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setLocale');
        return $pluginInfo ? $this->___callPlugins('setLocale', func_get_args(), $pluginInfo) : parent::setLocale($locale);
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getLocale');
        return $pluginInfo ? $this->___callPlugins('getLocale', func_get_args(), $pluginInfo) : parent::getLocale();
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getValue');
        return $pluginInfo ? $this->___callPlugins('getValue', func_get_args(), $pluginInfo) : parent::getValue();
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value, $currency = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setValue');
        return $pluginInfo ? $this->___callPlugins('setValue', func_get_args(), $pluginInfo) : parent::setValue($value, $currency);
    }

    /**
     * {@inheritdoc}
     */
    public function add($value, $currency = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'add');
        return $pluginInfo ? $this->___callPlugins('add', func_get_args(), $pluginInfo) : parent::add($value, $currency);
    }

    /**
     * {@inheritdoc}
     */
    public function sub($value, $currency = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'sub');
        return $pluginInfo ? $this->___callPlugins('sub', func_get_args(), $pluginInfo) : parent::sub($value, $currency);
    }

    /**
     * {@inheritdoc}
     */
    public function div($value, $currency = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'div');
        return $pluginInfo ? $this->___callPlugins('div', func_get_args(), $pluginInfo) : parent::div($value, $currency);
    }

    /**
     * {@inheritdoc}
     */
    public function mul($value, $currency = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'mul');
        return $pluginInfo ? $this->___callPlugins('mul', func_get_args(), $pluginInfo) : parent::mul($value, $currency);
    }

    /**
     * {@inheritdoc}
     */
    public function mod($value, $currency = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'mod');
        return $pluginInfo ? $this->___callPlugins('mod', func_get_args(), $pluginInfo) : parent::mod($value, $currency);
    }

    /**
     * {@inheritdoc}
     */
    public function compare($value, $currency = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'compare');
        return $pluginInfo ? $this->___callPlugins('compare', func_get_args(), $pluginInfo) : parent::compare($value, $currency);
    }

    /**
     * {@inheritdoc}
     */
    public function equals($value, $currency = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'equals');
        return $pluginInfo ? $this->___callPlugins('equals', func_get_args(), $pluginInfo) : parent::equals($value, $currency);
    }

    /**
     * {@inheritdoc}
     */
    public function isMore($value, $currency = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isMore');
        return $pluginInfo ? $this->___callPlugins('isMore', func_get_args(), $pluginInfo) : parent::isMore($value, $currency);
    }

    /**
     * {@inheritdoc}
     */
    public function isLess($value, $currency = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isLess');
        return $pluginInfo ? $this->___callPlugins('isLess', func_get_args(), $pluginInfo) : parent::isLess($value, $currency);
    }

    /**
     * {@inheritdoc}
     */
    public function getService()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getService');
        return $pluginInfo ? $this->___callPlugins('getService', func_get_args(), $pluginInfo) : parent::getService();
    }

    /**
     * {@inheritdoc}
     */
    public function setService($service)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setService');
        return $pluginInfo ? $this->___callPlugins('setService', func_get_args(), $pluginInfo) : parent::setService($service);
    }
}
