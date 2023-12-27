<?php
namespace Mage2\Blogs\Controller\Adminhtml\Blog;

use Mage2\Blogs\Api\BlogRepositoryInterface;
use Mage2\Blogs\Api\Data\BlogInterfaceFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action implements HttpGetActionInterface
{

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    private BlogInterfaceFactory $blogInterfaceFactory;
    private BlogRepositoryInterface $blogRepository;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        BlogInterfaceFactory $blogInterfaceFactory,
        BlogRepositoryInterface $blogRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->blogInterfaceFactory = $blogInterfaceFactory;
        $this->blogRepository = $blogRepository;

        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Mage2_Blogs::content_blogs_list');
        return $resultPage;
    }

    /**
     * Edit Blog
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('blog_id');
        $blog = $this->blogInterfaceFactory->create();

        // 2. Initial checking
        if ($id) {
            try {
                $blog = $this->blogRepository->getById((int)$id);
            } catch (LocalizedException $exception) {
                $this->messageManager->addErrorMessage(__('This blog no longer exists.'));

                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Blog') : __('New Blog'),
            $id ? __('Edit Blog') : __('New Blog')
        );

        $resultPage->getConfig()->getTitle()->prepend(__('Blogs'));
        $resultPage->getConfig()->getTitle()
            ->prepend($blog->getId() ? $blog->getTitle() : __('New Blog'));

        return $resultPage;
    }
}
