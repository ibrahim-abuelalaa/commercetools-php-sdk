<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */

namespace Commercetools\Core\Model\Cart;

use Commercetools\Core\Model\Common\Context;
use Commercetools\Core\Model\Common\JsonObject;
use Commercetools\Core\Model\CustomField\CustomFieldObjectDraft;
use Commercetools\Core\Model\Common\Address;
use Commercetools\Core\Model\ShippingMethod\ShippingMethodReference;

/**
 * @package Commercetools\Core\Model\Cart
 * @link http://dev.commercetools.com/http-api-projects-me-carts.html#mycartdraft
 * @method string getCurrency()
 * @method MyCartDraft setCurrency(string $currency = null)
 * @method string getCustomerEmail()
 * @method MyCartDraft setCustomerEmail(string $customerEmail = null)
 * @method string getCountry()
 * @method MyCartDraft setCountry(string $country = null)
 * @method string getInventoryMode()
 * @method MyCartDraft setInventoryMode(string $inventoryMode = null)
 * @method MyLineItemDraftCollection getLineItems()
 * @method MyCartDraft setLineItems(MyLineItemDraftCollection $lineItems = null)
 * @method Address getShippingAddress()
 * @method MyCartDraft setShippingAddress(Address $shippingAddress = null)
 * @method Address getBillingAddress()
 * @method MyCartDraft setBillingAddress(Address $billingAddress = null)
 * @method ShippingMethodReference getShippingMethod()
 * @method MyCartDraft setShippingMethod(ShippingMethodReference $shippingMethod = null)
 * @method CustomFieldObjectDraft getCustom()
 * @method MyCartDraft setCustom(CustomFieldObjectDraft $custom = null)
 * @method string getLocale()
 */
class MyCartDraft extends JsonObject
{
    public function fieldDefinitions()
    {
        return [
            'currency' => [static::TYPE => 'string'],
            'customerEmail' => [static::TYPE => 'string'],
            'country' => [static::TYPE => 'string'],
            'inventoryMode' => [static::TYPE => 'string'],
            'lineItems' => [static::TYPE => '\Commercetools\Core\Model\Cart\MyLineItemDraftCollection'],
            'shippingAddress' => [static::TYPE => '\Commercetools\Core\Model\Common\Address'],
            'billingAddress' => [static::TYPE => '\Commercetools\Core\Model\Common\Address'],
            'shippingMethod' => [static::TYPE => '\Commercetools\Core\Model\ShippingMethod\ShippingMethodReference'],
            'custom' => [static::TYPE => '\Commercetools\Core\Model\CustomField\CustomFieldObjectDraft'],
            'locale' => [static::TYPE => 'string'],
        ];
    }

    /**
     * @param string $currency
     * @param Context|callable $context
     * @return CartDraft
     */
    public static function ofCurrency($currency, $context = null)
    {
        $draft = static::of($context);
        return $draft->setCurrency($currency);
    }

    public function setLocale($locale)
    {
        $locale = \Locale::canonicalize($locale);
        parent::setLocale($locale);

        return $this;
    }

    /**
     * @return array
     */
    public function toJson()
    {
        $data = parent::toArray();
        $data['locale'] = str_replace('_', '-', $data['locale']);

        return $data;
    }
}
