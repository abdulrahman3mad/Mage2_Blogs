<?php
declare(strict_types=1);

namespace Mage2\Blogs\Service;

use Mage2\Blogs\Api\Data\BlogInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
class BlogImageFullPath
{
    private StoreManagerInterface $storeManager;

    public function __construct(
        StoreManagerInterface   $storeManager
    ){
        $this->storeManager = $storeManager;
    }

    public function get(BlogInterface $blog): string{
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        if($blog["featured_image"]) {
            $imgFullPath = $baseUrl . "tmp/imageUploader/images/" . $blog['featured_image'];
        }else{
            $imgFullPath = $baseUrl . "blogs/" . "blogs_default.jpeg";
        }
        return $imgFullPath;
    }
}
