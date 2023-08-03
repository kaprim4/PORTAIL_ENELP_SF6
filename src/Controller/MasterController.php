<?php

namespace App\Controller;

use App\Form\SegmentType;
use App\Repository\HookRepository;
use App\Repository\ModuleRepository;
use App\Repository\RoleRepository;
use App\Repository\WidgetRepository;
use App\Security\EmailVerifier;
use DateTimeImmutable;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Error;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MasterController extends AbstractController
{
    private object $object;
    private object $objectRepository;
    private ManagerRegistry $registry;
    private string $class_name;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
        $this->class_name = (new \ReflectionClass($this->getObject()))->getShortName();
    }

    private function checkClasses(): bool
    {
        if (!\is_object($this->object)) {
            if (null === $this->object) {
                $message = 'Impossible to invoke a method on a null variable.';
            } elseif (\is_array($this->object)) {
                $message = 'Impossible to invoke a method on an array.';
            } else {
                $message = 'Impossible to invoke a method on a variable.';
            }
            throw new Error($message);
        } else if ($this->object instanceof ServiceEntityRepository) {
            throw new Error('The current object is not an instance of ServiceEntityRepository.');
        } else {
            return true;
        }
    }

    public function index(): Response
    {
        if (!$this->checkClasses())
            return $this->redirectToRoute('app_home');

        $current_user = $this->getUser();
        if (!$current_user) {
            return $this->redirectToRoute('app_login');
        }

        $moduleRepo = new ModuleRepository($this->registry);
        $elm = $moduleRepo->findOneByNameInDb($this->classToLower($this->getClassName()));

        $hookRepository = new HookRepository($this->registry);
        $widgetRepository = new WidgetRepository($this->registry);
        $hook = $hookRepository->findOneBy(['alias' => 'HEADER']);
        $header_widgets = $widgetRepository->findByHook($hook);

        $form = $this->createForm('App\Form\\' . $this->getClassName() . 'Type', $this->getObject());
        $fieldNames = ['#'];
        $attributes = ['id'];
        foreach ($form->all() as $column) {
            if ($column->getName() != "password" && $column->getConfig()->getOptions()['mapped']) {
                $fieldNames[] = $column->getConfig()->getOptions()['label'];
                $attributes[] = $column->getName();
            }
        }
        $elements = $this->getObjectRepository()->findAll();
        return $this->render('datatable/index.html.twig', [
            'user' => $current_user,
            'user_role' => $current_user->getRole(),
            'root_uri' => 'Modules',
            'module_mod_menu' => $moduleRepo->findByParam("isModule"),
            'dictionnary_mod_menu' => $moduleRepo->findByParam("isDictionnary"),
            'parameter_mod_menu' => $moduleRepo->findByParam("isParameter"),
            'title' => 'Liste des entrées' . ($elm != null ? ' (' . $elm->getLibelle() . ')' : ''),
            'element_name' => ($elm != null ? ' (' . $elm->getLibelle() . ')' : ' (Module)'),
            'element_icon' => ($elm != null ? $elm->getIcon() : 'la-info'),
            'fieldNames' => $fieldNames,
            'attributes' => $attributes,
            'elements' => $elements,
            'header_widgets' => $header_widgets,
            'add_link' => $this->generateUrl('app_' . $this->classToLower($this->getClassName()) . '_new'),
            'list_link' => $this->generateUrl('app_' . $this->classToLower($this->getClassName()) . '_index'),
        ]);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function new(Request $request): Response
    {
        if (!$this->checkClasses())
            return $this->redirectToRoute('app_home');

        $current_user = $this->getUser();
        if (!$current_user) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm('App\Form\\' . $this->getClassName() . 'Type', $this->object);
        $form->handleRequest($request);

        $hookRepository = new HookRepository($this->registry);
        $widgetRepository = new WidgetRepository($this->registry);
        $hook = $hookRepository->findOneBy(['alias' => 'HEADER']);
        $header_widgets = $widgetRepository->findByHook($hook);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->objectRepository->save($this->object, true);
            $this->addFlash('success', 'Cette entrée a été ajoutée avec succès.');
            return $this->redirectToRoute('app_' . $this->classToLower($this->getClassName()) . '_index', [], Response::HTTP_SEE_OTHER);
        }

        $moduleRepo = new ModuleRepository($this->registry);
        $elm = $moduleRepo->findOneByNameInDb(strtolower($this->getClassName()));
        $option = [
            'user' => $current_user,
            'user_role' => $current_user->getRole(),
            'root_uri' => 'Modules',
            'module_mod_menu' => $moduleRepo->findByParam("isModule"),
            'dictionnary_mod_menu' => $moduleRepo->findByParam("isDictionnary"),
            'parameter_mod_menu' => $moduleRepo->findByParam("isParameter"),
            'title' => 'Nouvelle entrée' . ($elm != null ? ' (' . $elm->getLibelle() . ')' : ''),
            'element_icon' => ($elm != null ? $elm->getIcon() : 'la-info'),
            'module' => $this->object,
            'form' => $form,
            'header_widgets' => $header_widgets,
            'add_link' => $this->generateUrl('app_' . $this->classToLower($this->getClassName()) . '_new'),
            'list_link' => $this->generateUrl('app_' . $this->classToLower($this->getClassName()) . '_index'),
        ];
        return $this->render('datatable/new.html.twig', $option);
    }

    public function edit(Request $request): Response
    {
        if (!$this->checkClasses())
            return $this->redirectToRoute('app_home');

        $current_user = $this->getUser();
        if (!$current_user) {
            return $this->redirectToRoute('app_login');
        }

        $element_to_edit = $this->registry->getRepository("App\Entity\\" . $this->getClassName())->find($request->get('id'));

        $form = $this->createForm('App\Form\\' . $this->getClassName() . 'Type', $element_to_edit);
        $form->handleRequest($request);

        $hookRepository = new HookRepository($this->registry);
        $widgetRepository = new WidgetRepository($this->registry);
        $hook = $hookRepository->findOneBy(['alias' => 'HEADER']);
        $header_widgets = $widgetRepository->findByHook($hook);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->objectRepository->save($element_to_edit, true);
            $this->addFlash('success', 'Cette entrée a été modifiée avec succès.');
            return $this->redirectToRoute('app_' . $this->classToLower($this->getClassName()) . '_edit', [
                'id' => $request->get('id'),
            ], Response::HTTP_SEE_OTHER);
        }

        $moduleRepo = new ModuleRepository($this->registry);
        $elm = $moduleRepo->findOneByNameInDb(strtolower($this->getClassName()));

        $option = [
            'user' => $current_user,
            'user_role' => $current_user->getRole(),
            'root_uri' => 'Modules',
            'module_mod_menu' => $moduleRepo->findByParam("isModule"),
            'dictionnary_mod_menu' => $moduleRepo->findByParam("isDictionnary"),
            'parameter_mod_menu' => $moduleRepo->findByParam("isParameter"),
            'title' => 'Modifier cette entrée' . ($elm != null ? ' (' . $elm->getLibelle() . ')' : ''),
            'element_icon' => ($elm != null ? $elm->getIcon() : 'la-info'),
            'module' => $element_to_edit,
            'form' => $form,
            'header_widgets' => $header_widgets,
            'add_link' => $this->generateUrl('app_' . $this->classToLower($this->getClassName()) . '_new'),
            'list_link' => $this->generateUrl('app_' . $this->classToLower($this->getClassName()) . '_index'),
        ];
        return $this->render('datatable/edit.html.twig', $option);
    }

    public function delete(Request $request): Response
    {
        if (!$this->checkClasses())
            return $this->redirectToRoute('app_home');

        $element_to_delete = $this->registry->getRepository("App\Entity\\" . $this->getClassName())->find($request->get('id'));
        if ($this->isCsrfTokenValid('delete' . $element_to_delete->getId(), $request->request->get('_token'))) {
            $this->objectRepository->remove($element_to_delete, true);
            $this->addFlash('success', 'Cette entrée a été supprimée avec succès.');
        }
        return $this->redirectToRoute('app_' . $this->classToLower($this->getClassName()). '_index', [], Response::HTTP_SEE_OTHER);
    }

    public function enable(Request $request): Response
    {
        if (!$this->checkClasses())
            return $this->redirectToRoute('app_home');
        $element_to_enable = $this->registry->getRepository("App\Entity\\" . $this->getClassName())->find($request->get('id'));
        $element_to_enable->setIsActivated(true);
        $element_to_enable->setUpdatedAt(new DateTimeImmutable());
        $this->objectRepository->save($element_to_enable, true);
        $this->addFlash('success', 'Cette entrée a été activée avec succès.');
        return $this->redirectToRoute('app_' . $this->classToLower($this->getClassName()) . '_index', [], Response::HTTP_SEE_OTHER);
    }

    public function disable(Request $request): Response
    {
        if (!$this->checkClasses())
            return $this->redirectToRoute('app_home');
        $element_to_enable = $this->registry->getRepository("App\Entity\\" . $this->getClassName())->find($request->get('id'));
        $element_to_enable->setIsActivated(false);
        $element_to_enable->setUpdatedAt(new DateTimeImmutable());
        $this->objectRepository->save($element_to_enable, true);
        $this->addFlash('success', 'Cette entrée a été désactivée avec succès.');
        return $this->redirectToRoute('app_' . $this->classToLower($this->getClassName()) . '_index', [], Response::HTTP_SEE_OTHER);
    }

    public function show(Request $request): Response
    {
        if (!$this->checkClasses())
            return $this->redirectToRoute('app_home');

        $current_user = $this->getUser();
        if (!$current_user) {
            return $this->redirectToRoute('app_login');
        }

        $hookRepository = new HookRepository($this->registry);
        $widgetRepository = new WidgetRepository($this->registry);
        $hook = $hookRepository->findOneBy(['alias' => 'HEADER']);
        $header_widgets = $widgetRepository->findByHook($hook);

        $element_to_show = $this->registry->getRepository("App\Entity\\" . $this->getClassName())->find($request->get('id'));

        $moduleRepo = new ModuleRepository($this->registry);
        $elm = $moduleRepo->findOneByNameInDb(strtolower($this->getClassName()));

        $form = $this->createForm('App\Form\\' . $this->getClassName() . 'Type', $this->getObject());
        $fieldNames = ['#'];
        $attributes = ['id'];
        foreach ($form->all() as $column) {
            if ($column->getName() != "password" && $column->getConfig()->getOptions()['mapped']) {
                $fieldNames[] = $column->getConfig()->getOptions()['label'];
                $attributes[] = $column->getName();
            }
        }

        return $this->render('datatable/show.html.twig', [
            'user' => $current_user,
            'user_role' => $current_user->getRole(),
            'root_uri' => 'Modules',
            'module_mod_menu' => $moduleRepo->findByParam("isModule"),
            'dictionnary_mod_menu' => $moduleRepo->findByParam("isDictionnary"),
            'parameter_mod_menu' => $moduleRepo->findByParam("isParameter"),
            'title' => 'Détail de cette entrée' . ($elm != null ? ' (' . $elm->getLibelle() . ')' : ''),
            'element_icon' => ($elm != null ? $elm->getIcon() : 'la-info'),
            'module' => $element_to_show,
            'header_widgets' => $header_widgets,
            'fieldNames' => $fieldNames,
            'attributes' => $attributes,
            'element' => $element_to_show,
            'add_link' => $this->generateUrl('app_' . $this->classToLower($this->getClassName()) . '_new'),
            'edit_link' => $this->generateUrl('app_' . $this->classToLower($this->getClassName()) . '_edit', [
                'id' => $request->get('id')
            ]),
            'list_link' => $this->generateUrl('app_' . $this->classToLower($this->getClassName()) . '_index'),
        ]);
    }

    /**
     * @return Object
     */
    public function getObject(): object
    {
        return $this->object;
    }

    /**
     * @param Object $object
     */
    public function setObject(object $object): void
    {
        $this->object = $object;
    }

    /**
     * @return Object
     */
    public function getObjectRepository(): object
    {
        return $this->objectRepository;
    }

    /**
     * @param Object $objectRepository
     */
    public function setObjectRepository(object $objectRepository): void
    {
        $this->objectRepository = $objectRepository;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->class_name;
    }

    /**
     * @param string $class_name
     */
    public function setClassName(string $class_name): void
    {
        $this->class_name = $class_name;
    }

    function object_to_array($data)
    {
        if (is_array($data) || is_object($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                $result[$key] = (is_array($value) || is_object($value)) ? object_to_array($value) : $value;
            }
            return $result;
        }
        return $data;
    }

    function clean($string)
    {
        $string = str_replace(" ", "-", $string); // Replaces all spaces with hyphens.
        return preg_replace("/[^A-Za-z0-9\-]/", '', $string); // Removes special chars.
    }

    function classToLower($string): string
    {
        $res = [];
        $array = preg_split('#([A-Z][^A-Z]*)#', $string, null, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        foreach ($array as $str) {
            $res[] = strtolower($str);
        }
        return implode('_', $res);
    }
}