<?php

declare(strict_types=1);

namespace GacelaTest\Feature\Framework\UsingYamlConfigFromGacelaFile\LocalConfig;

use Gacela\Framework\AbstractFacade;

/**
 * @method Factory getFactory()
 */
final class Facade extends AbstractFacade
{
    public function doSomething(): array
    {
        return $this->getFactory()->getArrayConfig();
    }
}
