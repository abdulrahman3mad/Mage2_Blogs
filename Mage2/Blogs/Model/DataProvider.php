<?php
namespace Mage2\Blogs\Model;

use Mage2\Blogs\Api\BlogRepositoryInterface;
use Mage2\Blogs\Api\Data\BlogInterface;
use Mage2\Blogs\Model\ResourceModel\Blog\CollectionFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File\Mime;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Magento\Framework\Filesystem\Directory\ReadInterface;
use Psr\Log\LoggerInterface;

class DataProvider extends ModifierPoolDataProvider
{
    private array $loadedData = [];
    private BlogRepositoryInterface $blogRepository;
    private LoggerInterface $logger;
    private RequestInterface $request;
    private StoreManagerInterface $storeManager;
    private ReadInterface $mediaDirectory;
    private Filesystem $filesystem;
    private Mime $mime;

    public function __construct(
         $name,
         $primaryFieldName,
         $requestFieldName,
         CollectionFactory $collectionFactory,
         BlogRepositoryInterface $blogRepository,
         LoggerInterface $logger,
         RequestInterface $request,
         StoreManagerInterface $storeManager,
         Filesystem            $filesystem,
         Mime                  $mime,
         array $meta = [],
         array $data = [],
         PoolInterface $pool = null
     ) {
         parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
         $this->collection = $collectionFactory->create();
         $this->blogRepository = $blogRepository;
         $this->logger = $logger;
         $this->request = $request;
        $this->storeManager = $storeManager;
        $this->filesystem = $filesystem;
        $this->mime = $mime;
    }

     public function getData(): array
     {
         if(isset($this->loadedData)){
             return $this->loadedData;
         }

         $postData = $this->getCurrentBlog();
         if ($postData) {
             $this->prepareBlogImage($postData);
             $this->loadedData[$this->getBlogId()] = $postData;
         }
         return $this->loadedData;
     }

    private function getBlogId(): int
    {
        return (int) $this->request->getParam($this->getRequestFieldName());
    }

     private function getCurrentBlog(){
         try {
             return $this->blogRepository->getById($this->getBlogId())->getData();
         }catch(LocalizedException $exception){
             return null;
         }
     }

    private function prepareBlogImage(array $postData): array
    {
        $image = $postData[BlogInterface::FEATURED_IMAGE];

        // Format image url
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        $path = "tmp/imageUploader/images/";
        $imgUrl = $baseUrl . $path . $image;

        // Get image size
        $this->mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
        $fullPath = $this->mediaDirectory->getAbsolutePath($path);
        $stat = $this->mediaDirectory->stat($fullPath);

        $postData[BlogInterface::FEATURED_IMAGE] = null;

        $postData[BlogInterface::FEATURED_IMAGE][0] = [
            'url' => $imgUrl,
            'name' => $image,
            'size' => $stat['size'],
            'type' => $this->mime->getMimeType($fullPath . $image)
        ];

        return $postData;
    }
}
