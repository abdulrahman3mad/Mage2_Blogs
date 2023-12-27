<?php

namespace Mage2\Blogs\Controller\Adminhtml\Blog;

use \Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultFactory;

class MassDelete extends Action
{
  const PAGE_TITLE = 'Page Title';

  private JsonFactory $jsonFactory;

  public function __construct(JsonFactory $jsonFactory, Context $context)
  {
      parent::__construct($context);
      $this->jsonFactory = $jsonFactory;
  }


    /**
   * Index action
   *
   * @return \Magento\Framework\View\Result\Page
   */
  public function execute()
  {
      $resultJson = $this->jsonFactory->create();
      return $resultJson->setData(["blog" => "blog is deleted"]);
  }
}
