<?php
namespace Mage2\Blogs\Block\Adminhtml\Blog\Create;

use Mage2\Blogs\Api\BlogRepositoryInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var BlogRepositoryInterface
     */
    private BlogRepositoryInterface $blogRepository;

    /**
     * @param Context $context
     * @param BlogRepositoryInterface $blogRepository
     */
    public function __construct(
        Context $context,
        BlogRepositoryInterface $blogRepository
    ) {
        $this->context = $context;
        $this->blogRepository = $blogRepository;
    }

    /**
     * Return Blog ID
     *
     * @return int|null
     */
    public function getBlogId()
    {
        try {
            return $this->blogRepository->getById(
                $this->context->getRequest()->getParam('blog_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
