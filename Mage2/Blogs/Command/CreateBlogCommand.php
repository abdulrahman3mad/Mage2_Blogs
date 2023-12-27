<?php

declare(strict_types=1);

namespace Mage2\Blogs\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

use Mage2\Blogs\Model\BlogFactory;
use Mage2\Blogs\Model\ResourceModel\Blog as BlogResource;

class CreateBlogCommand extends Command
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
    $this->setName('blog:create');
    $this->setDescription('Create A Blog Record');

    parent::configure();
  }

  /**
   * @inheritDoc
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $blogData = [
      "title" => $this->askForInput($input, $output, "Title: "),
      "content" => $this->askForInput($input, $output, "Content: "),
        "meta_keywords" => $this->askForInput($input, $output, "Meta Keywords: "),
        "url_key" => $this->askForInput($input, $output, "Url Key: ")
    ];

    $blog = $this->blogFactory->create();
    $blog->setData($blogData);
    $this->blogResource->save($blog);

    $output->writeln("A blog created successfully with the id {$blog->getData('blog_id')}");

    return 0;
  }

  private function askForInput(InputInterface $input, OutputInterface $output, $questionText)
  {
    $helper = $this->getHelper('question');
    $question = new Question($questionText);
    return $helper->ask($input, $output, $question);
  }
}
