<?php

namespace Mage2\Blogs\ViewModel;

use Mage2\Blogs\Api\BlogRepositoryInterface;
use Mage2\Blogs\Api\Data\BlogInterface;
use Mage2\Blogs\Service\BlogImageFullPath;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManagerInterface;

class Blog implements ArgumentInterface
{
    /**
     * @var UrlInterface
     */

    private BlogInterface $blog;
    private UrlInterface $url;
    private RequestInterface $request;
    private BlogRepositoryInterface $blogRepository;
    private BlogImageFullPath $blogImageFullPath;

    /**
     * @param UrlInterface $url
     */
    public function __construct(
        UrlInterface            $url,
        RequestInterface        $request,
        BlogRepositoryInterface $blogRepository,
        BlogImageFullPath       $blogImageFullPath
    ){
        $this->url = $url;
        $this->request = $request;
        $this->blogRepository = $blogRepository;
        $this->blogImageFullPath = $blogImageFullPath;
    }

    /**
     * @param BlogInterface $blog
     * @return string
     */
    public function getBlogUrl(BlogInterface $blog): string
    {
        return $this->url->getBaseUrl() . "blogs/blog/" . $blog->getUrlKey();
    }

    public function getBlog(): ?BlogInterface
    {
        if (isset($this->blog)) {
            return $this->blog;
        }

        $blog_id = $this->request->getParam("blog_id");
        try {
            $blog = $this->blogRepository->getById($blog_id);
            $blog["featured_image"] = $this->blogImageFullPath->get($blog);

            return $blog;
        } catch (LocalizedException $exception) {
            return null;
        }
    }
}
