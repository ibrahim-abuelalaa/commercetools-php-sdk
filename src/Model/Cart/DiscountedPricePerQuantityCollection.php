<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */

namespace Commercetools\Core\Model\Cart;

use Commercetools\Core\Model\Common\Collection;

/**
 * @package Commercetools\Core\Model\Cart
 * @link https://dev.commercetools.com/http-api-projects-carts.html#discountedlineitempriceforquantity
 * @method DiscountedPricePerQuantityCollection add(DiscountedPricePerQuantity $element)
 * @method DiscountedPricePerQuantity current()
 * @method DiscountedPricePerQuantity getAt($offset)
 */
class DiscountedPricePerQuantityCollection extends Collection
{
    protected $type = '\Commercetools\Core\Model\Cart\DiscountedPricePerQuantity';
}
