<?php

namespace Mage2\Blogs\Controller\View;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Index extends Action implements HttpGetActionInterface
{
    private PageFactory $pageFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,

    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

    public function execute(): ResultInterface
    {
        /** @var Page $pageResult */
        $pageResult = $this->pageFactory->create();
        $pageResult->getConfig()->getTitle()->set(__("Blogs"));
        return $pageResult;
    }
}
