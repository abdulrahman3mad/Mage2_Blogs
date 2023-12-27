<?php
declare(strict_types=1);

namespace Mage2\Blogs\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\UrlInterface;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class ImageUploader extends Action implements HttpPostActionInterface
{
    private UploaderFactory $uploaderFactory;
    private Filesystem $filesystem;
    private WriteInterface $mediaDirectory;
    private JsonFactory $jsonFactory;
    private LoggerInterface $logger;
    private StoreManagerInterface $storeManager;

    public function __construct(
        Context $context,
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        JsonFactory $jsonFactory,
        ResultFactory $resultFactory,
        LoggerInterface $logger,
        StoreManagerInterface $storeManager
    ){
        parent::__construct($context);
        $this->uploaderFactory = $uploaderFactory;
        $this->filesystem = $filesystem;
        $this->jsonFactory = $jsonFactory;
        $this->logger = $logger;
        $this->storeManager = $storeManager;
        $this->resultFactory = $resultFactory;
    }

    public function execute()
    {
        try {
            // get the uploader, and set the config like what are the allowed extensions, etc.
            $uploader = $this->uploaderFactory->create(["fileId" => "featured_image"]);
            $uploader
                ->setAllowedExtensions(["jpg", "png", "jpeg", "gif"])
                ->setAllowCreateFolders(true)
                ->setAllowRenameFiles(true)
                ->setFilesDispersion(false);

            $this->mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
            $imgPath = "tmp/imageUploader/images/";
            $result = $uploader->save($this->mediaDirectory->getAbsolutePath($imgPath));

            $mediaUrl = $this->storeManager->getStore()->getBaseUrl(URLInterface::URL_TYPE_MEDIA);

            $result['url'] = $mediaUrl . $imgPath . $result['file'];
            $jsonResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            return $jsonResult->setData($result);
        }catch(\Exception $exception){
            $this->logger->error($exception->getMessage(), ["context" => $exception]);
        }
    }
}
