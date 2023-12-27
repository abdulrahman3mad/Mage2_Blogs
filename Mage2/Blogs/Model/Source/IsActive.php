<?php
namespace Mage2\Blogs\Model\Source;

use Mage2\Blogs\Api\Data\BlogInterface;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 */
class IsActive implements OptionSourceInterface
{
    /** @var BlogInterface  */
    private BlogInterface $blog;

    /**
     * Constructor
     *
     * @param \Mage2\Blogs\Api\Data\BlogInterface $cmsPage
     */
    public function __construct(BlogInterface $blog)
    {
        $this->blog = $blog;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->blog->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
