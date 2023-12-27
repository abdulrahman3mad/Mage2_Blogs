<?php

namespace Mage2\Blogs\Api\Data;
interface BlogInterface
{
    const BLOG_ID                  = 'blog_id';
    const TITLE                    = 'title';
    const META_TITLE               = 'meta_title';
    const META_KEYWORDS            = 'meta_keywords';
    const META_DESCRIPTION         = 'meta_description';
    const CONTENT                  = 'content';
    const CREATION_TIME            = 'creation_time';
    const UPDATE_TIME              = 'update_time';
    const FEATURED_IMAGE = 'featured_image';
    const IS_ACTIVE                = 'is_active';
    const URL_KEY = "identifier";
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle(): string;

    /**
     * Get meta title
     *
     * @return string|null
     */
    public function getMetaTitle(): string;

    /**
     * Get meta keywords
     *
     * @return string|null
     */
    public function getMetaKeywords(): string;

    /**
     * Get meta description
     *
     * @return string|null
     */
    public function getMetaDescription(): string;


    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent(): ?string;

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive(): bool;

    /**
     * Set title
     *
     * @param string $title
     * @return \Mage2\Blogs\Api\Data\BlogInterface
     */
    public function setTitle(string $title): BlogInterface;

    /**
     * Set meta title
     *
     * @param string $metaTitle
     * @return \Mage2\Blogs\Api\Data\BlogInterface
     * @since 101.0.0
     */
    public function setMetaTitle(string $metaTitle): BlogInterface;

    /**
     * Set meta keywords
     *
     * @param string $metaKeywords
     * @return \Mage2\Blogs\Api\Data\BlogInterface
     */
    public function setMetaKeywords(string $metaKeywords): BlogInterface;

    /**
     * Set meta description
     *
     * @param string $metaDescription
     * @return \Mage2\Blogs\Api\Data\BlogInterface
     */
    public function setMetaDescription(string $metaDescription): BlogInterface;

    /**
     * Set content
     *
     * @param string $content
     * @return \Mage2\Blogs\Api\Data\BlogInterface
     */
    public function setContent(string $content): BlogInterface;

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return \Mage2\Blogs\Api\Data\BlogInterface
     */
    public function setCreationTime($creationTime): BlogInterface;

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return \Mage2\Blogs\Api\Data\BlogInterface
     */
    public function setUpdateTime($updateTime): BlogInterface;

    /**
     * @param string $url_key
     * @return BlogInterface
     */
    public function setUrlKey(string $url_key): BlogInterface;

    /**
     * @return string
     */
    public function getUrlKey(): ?string;

    /**
     * Set is active
     *
     * @param int|bool $isActive
     * @return \Mage2\Blogs\Api\Data\BlogInterface
     */
    public function setIsActive($isActive);

    /**
     * @return array
     */
    public function getAvailableStatuses(): array;

    public function getFeaturedImage(): ?string;

    public function setFeaturedImage(string $featured_image): BlogInterface;
}
