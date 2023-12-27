<?php

declare(strict_types=1);

namespace Mage2\Blogs\Controller;

use Mage2\Blogs\Service\CheckPostExist;
use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\Url;

class Router implements RouterInterface
{
    private CheckPostExist $checkPostExist;
    private ActionFactory $actionFactory;

    public function __construct(
        CheckPostExist $checkPostExist,
        ActionFactory $actionFactory
    ){
        $this->checkPostExist = $checkPostExist;
        $this->actionFactory = $actionFactory;
    }

    public function match(RequestInterface $request)
    {
        $path = trim((string) $request->getPathInfo(), "/");

        $path_parts = explode("/", $path);
        if(isset($path_parts[1]) && $path_parts[1] === "blog"){
            $blogId = $this->checkPostExist->execute($path_parts[2]);
        }else{
            return null;
        }

        if(!$blogId){
            return null;
        }

        $request
            ->setModuleName("blogs")
            ->setControllerName("blog")
            ->setActionName("index")
            ->setParam("blog_id", $blogId)
            ->setAlias(Url::REWRITE_REQUEST_PATH_ALIAS, $path);

        return $this->actionFactory->create(Forward::class);
    }
}
