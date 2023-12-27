<?php

declare(strict_types=1);

namespace Mage2\Blogs\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Mage2\Blogs\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;

class GetAllBlogsCommand extends Command
{
  protected BlogCollectionFactory $blogCollectionFactory;

  /**
   * @param BlogCollectionFactory $blogCollectionFactory
   */
  public function __construct(
    BlogCollectionFactory $blogCollectionFactory
  ) {
    parent::__construct();
    $this->blogCollectionFactory = $blogCollectionFactory;
  }

  /**
   * @inheritDoc
   */
  protected function configure()
  {
    $this->setName('blog:getAll');
    $this->setDescription('Create A Blog Record');

    parent::configure();
  }

  /**
   * @inheritDoc
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $blogCollectionFactory = $this->blogCollectionFactory->create();
    foreach ($blogCollectionFactory->getItems() as $item) {
        foreach ($item->getData() as $key => $value) {
            $output->writeln(__("%1: %2", $key, $value));
        }

        $output->writeln("-----");
    }

    return 0;
  }
}
