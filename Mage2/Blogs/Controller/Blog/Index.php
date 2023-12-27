<?php

namespace Mage2\Blogs\Controller\Blog;

use Mage2\Blogs\Api\BlogRepositoryInterface;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Index extends Action implements HttpGetActionInterface
{
    private PageFactory $pageFactory;
    private BlogRepositoryInterface $blogRepository;
    private RedirectFactory $redirectFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        BlogRepositoryInterface $blogRepository,
        RedirectFactory $redirectFactory,
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->blogRepository = $blogRepository;
        $this->redirectFactory = $redirectFactory;
    }

    public function execute(): ResultInterface
    {
        /** @var Page $pageResult */
        $pageResult = $this->pageFactory->create();

        try {
            $blog = $this->blogRepository->getById($this->_request->getParam("blog_id"));
            $pageResult->getConfig()->getTitle()->set(__($blog->getTitle()));
        }catch(LocalizedException $exception){
            $redirectResult = $this->redirectFactory->create();
            $redirectResult->setUrl($this->_redirect->getRedirectUrl());
            return $redirectResult;
        }

        return $pageResult;
    }
}
