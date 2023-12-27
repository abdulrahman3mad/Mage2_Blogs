<?php

namespace Mage2\Blogs\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Blog extends AbstractDb
{
  private const TABLE_NAME = "mage2_blogs";
  private const PRIMARY_KEY = "blog_id";

  protected function _construct()
  {
    $this->_init(self::TABLE_NAME, self::PRIMARY_KEY);
  }
}
