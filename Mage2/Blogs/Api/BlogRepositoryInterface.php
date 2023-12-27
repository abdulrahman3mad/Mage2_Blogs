<?php
namespace Mage2\Blogs\Api;
interface BlogRepositoryInterface
{
    /**
     * Save Blog.
     *
     * @param \Mage2\Blogs\Api\Data\BlogInterface $blog
     * @return \Mage2\Blogs\Api\Data\BlogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Mage2\Blogs\Api\Data\BlogInterface $blog);

    /**
     * Retrieve blog.
     *
     * @param int $blogId
     * @return \Mage2\Blogs\Api\Data\BlogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById(int $blogId);

    /**
     * Delete blog.
     *
     * @param \Mage2\Blogs\Api\Data\BlogInterface $blog
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Mage2\Blogs\Api\Data\BlogInterface $blog);

    /**
     * Delete blog by ID.
     *
     * @param int $blogId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById(int $blogId);
}
