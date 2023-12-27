<?php
namespace Mage2\Blogs\Ui\Component\Listing\Column;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class prepare Page Actions
 */
class PageActions extends Column
{

    /** @var string  */
    const BLOG_URL_PATH_EDIT = 'mage2_blogs/blog/edit';

    /** @var string  */
    const BLOG_URL_PATH_DELETE = 'mage2_blogs/blog/delete';

    /** @var UrlInterface  */
    private UrlInterface $urlBuilder;

    /** @var array  */
    private array $data;

    /**
     * @var Escaper
     */
    private $escaper;
    public function __construct(
        ContextInterface $context,
        UrlInterface $urlBuilder,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = [],
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->context = $context;
        $this->urlBuilder = $urlBuilder;
        $this->uiComponentFactory = $uiComponentFactory;
        $this->components = $components;
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['blog_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->getEditUrl(['blog_id' => $item['blog_id']]),
                        'label' => __('Edit'),
                    ];
                    $title = $this->getEscaper()->escapeHtml($item['title']);
                    $item[$name]['delete'] = [
                        'href' => $this->getDeleteUrl(['blog_id' => $item['blog_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete %1', $title),
                            'message' => __('Are you sure you want to delete a %1 record?', $title),
                        ],
                        'post' => true,
                    ];
                }
            }
        }

        return $dataSource;
    }

    private function getEditUrl(array $params){
        return $this->urlBuilder->getUrl(self::BLOG_URL_PATH_EDIT, $params);
    }

    private function getDeleteUrl(array $params){
        return $this->urlBuilder->getUrl(self::BLOG_URL_PATH_DELETE, $params);
    }

    /**
     * Get instance of escaper
     *
     * @return Escaper
     * @deprecated 101.0.7
     */
    private function getEscaper()
    {
        if (!$this->escaper) {
            $this->escaper = ObjectManager::getInstance()->get(Escaper::class);
        }
        return $this->escaper;
    }
}
