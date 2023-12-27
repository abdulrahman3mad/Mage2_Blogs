<?php

namespace Mage2\Blogs\Controller\Adminhtml\Blog;

use Mage2\Blogs\Api\BlogRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class Delete extends Action implements HttpPostActionInterface
{
    private Context $context;
    private BlogRepositoryInterface $blogRepository;
    private LoggerInterface $logger;
    private RedirectFactory $redirectFactory;

    public function __construct(
        Context $context,
        BlogRepositoryInterface $blogRepository,
        LoggerInterface $logger,
        RedirectFactory $redirectFactory
    ){
        parent::__construct($context);
        $this->context = $context;
        $this->blogRepository = $blogRepository;
        $this->logger = $logger;
        $this->redirectFactory = $redirectFactory;
    }

    public function execute()
    {
        $blog_id = $this->context->getRequest()->getParam("blog_id");
        try {
            $isRemoved = $this->blogRepository->deleteById(($blog_id));
            if ($isRemoved) {
                $this->messageManager->addSuccessMessage(__("Blog deleted successfully"));
            } else {
                $this->messageManager->addErrorMessage(__("Something went wrong while deleting the blog"));
            }
        }catch(LocalizedException $exception){
            $this->messageManager->addExceptionMessage($exception);
            $this->logger->error($exception->getMessage(), ["context" => $exception]);
        }catch(\Exception $exception){
            $this->messageManager->addErrorMessage(__("Something went wrong while deleting the blog"));
            $this->logger->error($exception->getMessage(), ["context" => $exception]);
        }

        $resultRedirect = $this->redirectFactory->create();
        $resultRedirect->setPath("*/*");
        return $resultRedirect;
    }
}
