<?php

namespace Mage2\Blogs\Model;

use Mage2\Blogs\Api\Data\BlogInterface;
use Magento\Framework\Model\AbstractModel;

class Blog extends AbstractModel implements BlogInterface
{
    public function _construct()
    {
        $this->_init(\Mage2\Blogs\Model\ResourceModel\Blog::class);
    }

    public function getTitle(): string
    {
        return $this->getData(self::TITLE);
    }

    public function getMetaTitle(): string
    {
        return $this->getData(self::META_TITLE);
    }

    public function getMetaKeywords(): string
    {
        return $this->getData(self::META_KEYWORDS);
    }

    public function getMetaDescription(): string
    {
        return $this->getData(self::META_DESCRIPTION);
    }

    public function getContent(): ?string
    {
        return $this->getData(self::CONTENT);
    }

    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    public function isActive(): bool
    {
        return $this->getData(self::IS_ACTIVE);
    }

    public function setTitle($title): BlogInterface
    {
        $this->setData(self::TITLE, $title);
        return $this;
    }

    public function setMetaTitle($metaTitle): BlogInterface
    {
        $this->setData(self::META_TITLE, $metaTitle);
        return $this;
    }

    public function setMetaKeywords($metaKeywords): BlogInterface
    {
        $this->setData(self::META_KEYWORDS, $metaKeywords);
        return $this;
    }

    public function setMetaDescription($metaDescription): BlogInterface
    {
        $this->setData(self::META_DESCRIPTION, $metaDescription);
        return $this;
    }

    public function setContent($content): BlogInterface
    {
        $this->setData(self::CONTENT, $content);
        return $this;
    }

    public function setCreationTime($creationTime): BlogInterface
    {
        $this->setData(self::CREATION_TIME, $creationTime);
        return $this;
    }

    public function setUpdateTime($updateTime): BlogInterface
    {
        $this->setData(self::UPDATE_TIME, $updateTime);
        return $this;
    }

    public function setIsActive($isActive): BlogInterface
    {
        $this->setData(self::IS_ACTIVE, $isActive);
        return $this;
    }

    public function getAvailableStatuses(): array
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    public function setUrlKey(string $url_key): BlogInterface
    {
        $this->setData(self::URL_KEY, $url_key);
        return $this;
    }

    public function getUrlKey(): ?string
    {
        return $this->getData(self::URL_KEY);
    }

    public function getFeaturedImage(): ?string
    {
        return $this->getData(self::FEATURED_IMAGE);
    }

    public function setFeaturedImage(string $featured_image): BlogInterface
    {
        $this->setData(self::FEATURED_IMAGE, $featured_image);
        return $this;
    }
}
