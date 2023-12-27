<?php

declare(strict_types=1);

namespace Mage2\Blogs\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action implements HttpGetActionInterface
{
    private const PAGE_TITLE = 'Mage2 Blogs';

    /**
     * Index action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute(): Page
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu("Mage2_Blogs::content_blogs_list");
        $resultPage->getConfig()->getTitle()->set(__(self::PAGE_TITLE));
        return $resultPage;
    }
}
