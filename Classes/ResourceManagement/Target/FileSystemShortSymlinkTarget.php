<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Hans Hoechtl <hhoechtl@1drop.de>
 *  All rights reserved
 ***************************************************************/
namespace Onedrop\ShortResourceUri\ResourceManagement\Target;

use Neos\Flow\ResourceManagement\ResourceMetaDataInterface;
use Neos\Flow\ResourceManagement\Target\FileSystemSymlinkTarget;

/**
 * Target which doesn't create a hash in the published file path
 */
class FileSystemShortSymlinkTarget extends FileSystemSymlinkTarget
{
    /**
     * {@inheritdoc}
     */
    protected function getRelativePublicationPathAndFilename(ResourceMetaDataInterface $object): string
    {
        if ($object->getRelativePublicationPath() !== '') {
            $pathAndFilename = $object->getRelativePublicationPath() . $object->getFilename();
        } else {
            $pathAndFilename = $object->getFilename();
        }
        return $pathAndFilename;
    }
}
