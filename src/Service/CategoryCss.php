<?php

namespace App\Service;

use App\Entity\Category;
use App\Helper\FileTools;
use App\Helper\ParamsInServices;
use App\Repository\CategoryRepository;


/**
 * @author Emmanuel SAUVAGE <emmanuel.sauvage@live.fr>
 * @version 1.0.0
 */
class CategoryCss
{
    /** @var Category[]*/
    private $categorys;

    /** @var ParamsInServices */
    private $paramsInServices;

    /**@var FileTools */
    private $fileTools;

    public function __construct(
        CategoryRepository $categoryRepository,
        ParamsInServices $paramsInServices,
        FileTools $fileTools
    ) {
        $this->categorys = $categoryRepository->findAll();
        $this->paramsInServices = $paramsInServices;
        $this->fileTools = $fileTools;
    }

    public function create()
    {
        $dir = $this->paramsInServices->get(ParamsInServices::ES_DIRECTORY_CSS);
        $filecss = "category.css";
        $content = '';

        dump("Dir:" . $dir);

        if ($this->fileTools->exist($dir, $filecss)) {
            $this->fileTools->remove($dir, $filecss);
            dump("suppression");
        }

        foreach ($this->categorys as $category) {
            dump("category " . $category->getid());
            $content = $content . $this->createOne($category);
        }
        dump("write");
        dump("content:" . $content);
        $this->fileTools->write($dir, $filecss, $content, false);
        dump("end");
    }

    private function createOne(Category $category): string
    {
        return '.category_' . $category->getId() .
            '{' .
            (null!==$category->getBgcolor() ? ('background-color:' . $category->getBgcolor() . ';') : '') .
            (null!==$category->getForecolor() ? ('color:' . $category->getForecolor() . ';') : '') .
            '}';
    }
}
