<?php

namespace Mage2\Blogs\Model;

use Mage2\Blogs\Api\BlogRepositoryInterface;
use Mage2\Blogs\Api\Data\BlogInterface;
use Mage2\Blogs\Api\Data\BlogInterfaceFactory;
use Mage2\Blogs\Model\ResourceModel\Blog as ResourceBlog;
use Mage2\Blogs\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class BlogRepository implements BlogRepositoryInterface
{
    private ResourceBlog $resource;
    private BlogInterfaceFactory $dataBlockFactory;
    private BlogCollectionFactory $blogCollectionFactory;

    /**
     * @param ResourceBlog $resource
     * @param BlogInterfaceFactory $dataBlockFactory
     * @param BlogCollectionFactory $blogCollectionFactory
     */
    public function __construct(
        ResourceBlog $resource,
        BlogInterfaceFactory $dataBlockFactory,
        BlogCollectionFactory $blogCollectionFactory,
    ) {

        $this->resource = $resource;
        $this->dataBlockFactory = $dataBlockFactory;
        $this->blogCollectionFactory = $blogCollectionFactory;
    }

    /**
     * Save Block data
     *
     * @param \Mage2\Blogs\Api\Data\BlogInterface $blog
     * @return \Mage2\Blogs\Api\Data\BlogInterface
     * @throws CouldNotSaveException
     */
    public function save(\Mage2\Blogs\Api\Data\BlogInterface $blog)
    {
        try {
            $this->resource->save($blog);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $blog;
    }

    /**
     * Load Blog data by given Blog Identity
     *
     * @param int $blogId
     * @return BlogInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $blogId)
    {
        $blog = $this->dataBlockFactory->create();
        $this->resource->load($blog, $blogId);
        if (!$blog->getId()) {
            throw new NoSuchEntityException(__('The blog with the "%1" ID doesn\'t exist.', $blogId));
        }
        return $blog;
    }

    /**
     * Delete Blog
     *
     * @param \Mage2\Blogs\Api\Data\BlogInterface $blog
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(\Mage2\Blogs\Api\Data\BlogInterface $blog)
    {
        try {
            $this->resource->delete($blog);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete Block by given Block Identity
     *
     * @param int $blogId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $blogId)
    {
        return $this->delete($this->getById($blogId));
    }
}
