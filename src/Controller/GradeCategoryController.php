<?php

namespace App\Controller;

use App\Entity\GradeCategory;
use App\Repository\GradeCategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/grade_category')]
class GradeCategoryController extends MasterController
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setObject(new GradeCategory());
        $this->setObjectRepository(new GradeCategoryRepository($registry));
        parent::__construct($registry);
    }

    #[Route('/', name: 'app_grade_category_index', methods: ['GET'])]
    public function index(): Response
    {
        return parent::index();
    }

    #[Route('/new', name: 'app_grade_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        return parent::new($request); // TODO: Change the autogenerated stub
    }

    #[Route('/{id}', name: 'app_grade_category_show', methods: ['GET'])]
    public function show(Request $request): Response
    {
        return parent::show($request); // TODO: Change the autogenerated stub
    }

    #[Route('/{id}/edit', name: 'app_grade_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,): Response
    {
        return parent::edit($request); // TODO: Change the autogenerated stub
    }

    #[Route('/{id}', name: 'app_grade_category_delete', methods: ['POST'])]
    public function delete(Request $request): Response
    {
        return parent::delete($request); // TODO: Change the autogenerated stub
    }

    #[Route('/{id}/enable', name: 'app_grade_category_enable', methods: ['GET', 'POST'])]
    public function enable(Request $request): Response
    {
        return parent::enable($request); // TODO: Change the autogenerated stub
    }

    #[Route('/{id}/disable', name: 'app_grade_category_disable', methods: ['GET', 'POST'])]
    public function disable(Request $request): Response
    {
        return parent::disable($request); // TODO: Change the autogenerated stub
    }

}