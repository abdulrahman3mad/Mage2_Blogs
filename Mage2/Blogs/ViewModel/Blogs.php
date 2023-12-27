<?php

namespace Mage2\Blogs\ViewModel;

use Mage2\Blogs\Api\Data\BlogInterface;
use Mage2\Blogs\Model\ResourceModel\Blog\Collection as BlogCollection;
use Mage2\Blogs\Service\BlogImageFullPath;
use Mage2\Blogs\Service\BlogsProvider;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\View\Element\Template;
use Magento\Theme\Block\Html\Pager;

class Blogs implements ArgumentInterface
{
    private BlogsProvider $blogsProvider;
    private RequestInterface $request;
    private BlogImageFullPath $blogImageFullPath;

    public function __construct(
        BlogsProvider $blogsProvider,
        RequestInterface  $request,
        BlogImageFullPath $blogImageFullPath
    ){
        $this->blogsProvider = $blogsProvider;
        $this->request = $request;
        $this->blogImageFullPath = $blogImageFullPath;
    }

    /**
     * @param int $count
     * @return BlogCollection
     */
    public function getBlogs(int $count): BlogCollection
    {
        return $this->blogsProvider->getAllBlogs($count, $this->getCurrentPage());
    }

    /**
     * @return int
     */
    private function getCurrentPage(): int
    {
        $page = $this->request->getParam("p") ? (int) $this->request->getParam("p"): 1;
        return $page;
    }

    /**
     * @param BlogCollection $collection
     * @param Pager $pager
     * @return string
     */
    public function preparePager(BlogCollection $collection, Pager $pager): string
    {
        $pager
            ->setAvailableLimit(array(10 => 10, 15 => 15, 20 => 20))
            ->setShowPerPage(true)
            ->setShowAmounts(true)
            ->setUseContainer(true)
            ->setLimit($collection->getPageSize())
            ->setFrameLength(3)
            ->setCollection($collection);

        return $pager->toHtml();
    }

    /**
     * @param Template $block
     * @param BlogInterface $blog
     * @return string
     */
    public function prepareBlog(Template $block, BlogInterface $blog): string
    {
        $blog["featured_image"] = $this->blogImageFullPath->get($blog);
        $block->setData("blog", $blog);
        return $block->toHtml();
    }
}
