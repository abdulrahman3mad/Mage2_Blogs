<?php

namespace Mage2\Blogs\Service;

use Mage2\Blogs\Model\Blog;
use Mage2\Blogs\Model\ResourceModel\Blog\Collection;
use Mage2\Blogs\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;

class CheckPostExist
{
    private BlogCollectionFactory $blogCollectionFactory;

    public function __construct(
        BlogCollectionFactory $blogCollectionFactory
    ){
        $this->blogCollectionFactory = $blogCollectionFactory;
    }

    public function execute(string $urlKey): ?int
    {
        /** @var Collection $blogCollection */
        $blogCollection = $this->blogCollectionFactory->create();
        $blogCollection->addFieldToFilter("identifier", ["eq" => $urlKey]);

        /** @var Blog $item */
        $item = $blogCollection->getFirstItem();
        if($item){
            return $item->getId();
        }

        return null;
    }
}
