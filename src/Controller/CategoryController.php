<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class CategoryController extends AbstractGController
{
    /**
     * @Route("/ajax/getcontentofcategory/{id}", name="ajax_get_content_of_category", methods={"GET","POST"})
     */
    public function AjaxGetContentOfCategory(Request $request, Category $cat): Response
    {
        return $this->json(
            $cat->getContent(),
            200
        );
    }

}
