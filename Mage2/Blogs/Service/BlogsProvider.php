<?php

namespace Mage2\Blogs\Service;

use Mage2\Blogs\Api\Data\BlogInterface;
use Mage2\Blogs\Model\ResourceModel\Blog\Collection;
use Mage2\Blogs\Model\ResourceModel\Blog\CollectionFactory as BlogsCollectionFactory;
use Zend_Db_Select;

class BlogsProvider
{
    private BlogsCollectionFactory $blogsCollectionFactory;
    public function __construct(
        BlogsCollectionFactory $blogsCollectionFactory
    ){
        $this->blogsCollectionFactory = $blogsCollectionFactory;
    }

    /**
     * @param int $count
     * @param int $curPage
     * @return Collection
     */
    public function  getAllBlogs(int $count, int $curPage): Collection
    {
        $blogsCollection = $this->blogsCollectionFactory->create();
        $blogsCollection
            ->setPageSize($count)
            ->setOrder("creation_time", Zend_Db_Select::SQL_DESC)
            ->setCurPage($curPage);

        return $blogsCollection;
  }
}
