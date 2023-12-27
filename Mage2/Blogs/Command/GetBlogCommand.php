<?php

declare(strict_types=1);

namespace Mage2\Blogs\Command;

use Mage2\Blogs\Api\Data\BlogInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

use Mage2\Blogs\Model\BlogFactory;
use Mage2\Blogs\Model\ResourceModel\Blog as BlogResource;

class GetBlogCommand extends Command
{

  protected BlogFactory $blogFactory;

  protected BlogResource $blogResource;

  /**
   * @param BlogFactory $blogFactory
   * @param BlogResource $blogResource
   */
  public function __construct(
    BlogFactory $blogFactory,
    BlogResource $blogResource
  ) {
    parent::__construct();

    $this->blogFactory = $blogFactory;
    $this->blogResource = $blogResource;
  }

  /**
   * @inheritDoc
   */
  protected function configure()
  {
    $this->setName('blog:get');
    $this->setDescription('Create A Blog Record');

    parent::configure();
  }

  /**
   * @inheritDoc
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
      $blogId = $this->askForInput($input, $output, (string)__('Enter the blog id: '));
    $blog = $this->blogFactory->create();
    $this->blogResource->load($blog, $blogId);

    if ($blog->getData("blog_id")) {
        foreach ($blog->getData() as $key => $value) {
            $output->writeln(__("%1: %2", $key, $value));
        };
    } else {
        $output->writeln(__("not found"));
    }

    return 0;
  }

  private function askForInput(InputInterface $input, OutputInterface $output, $questionText)
  {
    $helper = $this->getHelper('question');
    $question = new Question($questionText);
    return $helper->ask($input, $output, $question);
  }
}
