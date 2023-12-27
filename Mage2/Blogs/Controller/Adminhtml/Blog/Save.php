<?php

namespace Mage2\Blogs\Controller\Adminhtml\Blog;

use Mage2\Blogs\Api\BlogRepositoryInterface;
use Mage2\Blogs\Api\Data\BlogInterface;
use Mage2\Blogs\Api\Data\BlogInterfaceFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\Manager;
use Psr\Log\LoggerInterface;

class Save extends Action implements HttpPostActionInterface
{
    private BlogRepositoryInterface $blogRepository;
    private BlogInterfaceFactory $blogFactory;
    private RedirectInterface $redirect;
    private RedirectFactory $redirectFactory;
    private LoggerInterface $logger;

    /**
     * @param Context $context
     * @param BlogRepositoryInterface $blogRepository
     * @param BlogInterfaceFactory $blogFactory
     * @param Manager $messageManager
     * @param RedirectInterface $redirect
     * @param RedirectFactory $redirectFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        BlogRepositoryInterface $blogRepository,
        BlogInterfaceFactory $blogFactory,
        Manager $messageManager,
        RedirectInterface $redirect,
        RedirectFactory $redirectFactory,
        LoggerInterface $logger
    ){
        parent::__construct($context);
        $this->blogRepository = $blogRepository;
        $this->blogFactory = $blogFactory;
        $this->messageManager = $messageManager;
        $this->redirect = $redirect;
        $this->redirectFactory = $redirectFactory;
        $this->logger = $logger;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if($data){
            $blog = $this->blogFactory->create();

            if (empty($data[BlogInterface::BLOG_ID])) {
                $data[BlogInterface::BLOG_ID] = null;
            }

            if (!$data[BlogInterface::URL_KEY]) {
                $data[BlogInterface::URL_KEY] = rtrim(implode("-", explode(" ", $data[BlogInterface::TITLE])), '-');
            }

            if (isset($data[BlogInterface::FEATURED_IMAGE][0]) && isset($data[BlogInterface::FEATURED_IMAGE][0]["tmp_name"])) {
                $data[BlogInterface::FEATURED_IMAGE] = $data[BlogInterface::FEATURED_IMAGE][0]['name'];
            } else {
                unset($data[BlogInterface::FEATURED_IMAGE]);
            }

            $blog->setData($data);

            try{
                $this->blogRepository->save($blog);
                $this->messageManager->addSuccessMessage(__("Blog Created Successfully"));
            }catch(LocalizedException $exception){
                $this->messageManager->addExceptionMessage($exception);
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage(__("Something went wrong while saving the blog"));
                $context = ["context" => $exception];
                $this->logger->error($exception->getMessage(), $context);
            }
        }else{
            $this->messageManager->addErrorMessage(__("Missing required fields"));
        }

        $resultRedirect = $this->redirectFactory->create();
        $resultRedirect->setPath("*/*/");
        return $resultRedirect;
    }
}
