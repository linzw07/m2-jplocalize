<?php
/**
 * Plugin for modify currency format
 *
 * PHP version 5, 7
 *
 * @category Plugin
 * @package  Veriteworks\Price\Observer
 * @author   Veriteworks Inc. <info@veriteworks.co.jp>
 * @license  Open Software License 3.0
 * @link     https://principle-works.jp/
 */
namespace Veriteworks\Price\Model\Directory\Plugin;

use Magento\Directory\Model\PriceCurrency;
use \Magento\Framework\View\Element\Context;

/**
 * Class Format
 *
 * @category Plugin
 * @package  Veriteworks\Price\Observer
 * @author   Veriteworks Inc. <info@veriteworks.co.jp>
 * @license  Open Software License 3.0
 * @link     https://principle-works.jp/
 */
class Format
{

    /**
     * Scope Config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * ModifyPrice constructor.
     *
     * @param Context $context Context
     */
    public function __construct(Context $context)
    {
        $this->scopeConfig = $context->getScopeConfig();
    }

    /**
     * Modify Currency Format
     *
     * @param PriceCurrency $subject          Price Currency Object
     * @param \Closure      $proceed          Closure
     * @param float         $amount           Price Amount
     * @param bool          $includeContainer Include Container Flag
     * @param int           $precision        Precision digits
     * @param null          $scope            Data scope
     * @param null          $currency         Currency Code
     *
     * @return mixed
     */
    public function aroundFormat(
        PriceCurrency  $subject,
        \Closure $proceed,
        $amount,
        $includeContainer = true,
        $precision = \Magento\Directory\Model\PriceCurrency::DEFAULT_PRECISION,
        $scope = null,
        $currency = null
    ) {
        if ($subject->getCurrency()->getCode() == 'JPY') {
            $precision = '0';
            return $subject->getCurrency($scope, $currency)
                ->formatPrecision($amount, $precision, [], $includeContainer);
        }
        return $proceed($amount, $includeContainer, $precision, $scope, $currency);
    }
}