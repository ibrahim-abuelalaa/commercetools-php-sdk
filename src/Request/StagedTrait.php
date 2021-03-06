<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 * @created: 02.02.15, 15:03
 */

namespace Commercetools\Core\Request;

use Commercetools\Core\Request\Query\Parameter;
use Commercetools\Core\Request\Query\ParameterInterface;

/**
 * @package Commercetools\Core\Request
 * @method $this addParamObject(ParameterInterface $param)
 */
trait StagedTrait
{
    /**
     * @param bool $staged
     * @return $this
     */
    public function staged($staged)
    {
        if (is_bool($staged)) {
            $this->addParamObject(new Parameter('staged', $staged));
        }

        return $this;
    }
}
