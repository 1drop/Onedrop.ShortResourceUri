<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Hans Hoechtl <hhoechtl@1drop.de>
 *  All rights reserved
 ***************************************************************/
namespace Onedrop\ShortResourceUri\Media;

use Neos\Error\Messages\Error;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\FlashMessage\FlashMessageContainer;
use Neos\Media\Domain\Model\AssetInterface;
use Neos\Media\Domain\Repository\AssetRepository;
use Neos\Media\Domain\Service\AssetService;

class DuplicateInterceptor
{
    /**
     * @var AssetService
     * @Flow\Inject()
     */
    protected $assetService;
    /**
     * The flash messages. Use $this->flashMessageContainer->addMessage(...) to add a new Flash
     * Message.
     *
     * @Flow\Inject
     * @var FlashMessageContainer
     */
    protected $flashMessageContainer;

    /**
     * This is used to intercept the creation of a new asset
     * if an asset with the same filename already exists.
     *
     * @param  AssetInterface             $asset
     * @throws DuplicateFilenameException
     */
    public function checkForDuplicateFilename(AssetInterface $asset)
    {
        $newAssetFilename = $asset->getResource()->getFilename();
        /** @var AssetRepository $assetRepo */
        $assetRepo = $this->assetService->getRepository($asset);
        $query = $assetRepo->createQuery();
        $query->matching($query->equals('resource.filename', $newAssetFilename));
        if ($query->execute()->count() > 0) {
            $message = new Error('File with name already exists', 1537793717);
            $this->flashMessageContainer->addMessage($message);
            throw new DuplicateFilenameException(
                sprintf('File with name %s already exists', $newAssetFilename),
                1537793717
            );
        }
    }
}
