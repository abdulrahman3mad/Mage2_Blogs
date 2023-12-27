<?php

namespace Mage2\Blogs\Model\ResourceModel\Blog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Mage2\Blogs\Model\ResourceModel\Blog as BlogResource;
use Mage2\Blogs\Model\Blog;

class Collection extends AbstractCollection
{
  protected function _construct()
  {
    $this->_init(Blog::class, BlogResource::class);
  }
}
