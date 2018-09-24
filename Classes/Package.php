<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Hans Hoechtl <hhoechtl@1drop.de>
 *  All rights reserved
 ***************************************************************/

namespace Onedrop\ShortResourceUri;

use Neos\Flow\Core\Bootstrap;
use Neos\Flow\Package\Package as BasePackage;
use Neos\Flow\Annotations as Flow;
use Neos\Media\Domain\Service\AssetService;
use Onedrop\ShortResourceUri\Media\DuplicateInterceptor;

/**
 * @Flow\Scope("singleton")
 */
class Package extends BasePackage
{
    /**
     * @param Bootstrap $bootstrap
     */
    public function boot(Bootstrap $bootstrap)
    {
        $dispatcher = $bootstrap->getSignalSlotDispatcher();
        $dispatcher->connect(
            AssetService::class,
            'assetCreated',
            DuplicateInterceptor::class,
            'checkForDuplicateFilename'
        );
    }

}
