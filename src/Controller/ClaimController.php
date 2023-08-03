<?php

namespace App\Controller;

use App\Config\ConfigFunc;
use App\Entity\Claim;
use App\Entity\ClaimRow;
use App\Entity\ClaimStatistic;
use App\Form\ClaimType;
use App\Repository\ActualClaimRepository;
use App\Repository\HookRepository;
use App\Repository\ModuleRepository;
use App\Repository\ParameterRepository;
use App\Repository\ClaimRepository;
use App\Repository\ClaimRowRepository;
use App\Repository\ClaimStatisticRepository;
use App\Repository\ClaimStatusRepository;
use App\Repository\WholesaleClaimDetailRepository;
use App\Repository\WidgetRepository;
use DateTimeImmutable;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/claim')]
class ClaimController extends AbstractController
{
    private ClaimRepository $claimRepository;
    private ParameterRepository $parameterRepository;
    private HookRepository $hookRepository;
    private WidgetRepository $widgetRepository;
    private ModuleRepository $moduleRepo;

    private int $limit_for_cancel;
    private int $limit_for_list;
    private array $header_widgets;

    /**
     * @param ModuleRepository $moduleRepo
     * @param ClaimRepository $claimRepository
     * @param ParameterRepository $parameterRepository
     * @param HookRepository $hookRepository
     * @param WidgetRepository $widgetRepository
     */
    public function __construct(ModuleRepository $moduleRepo, ClaimRepository $claimRepository, ParameterRepository $parameterRepository, HookRepository $hookRepository, WidgetRepository $widgetRepository)
    {
        $this->moduleRepo = $moduleRepo;
        $this->claimRepository = $claimRepository;
        $this->parameterRepository = $parameterRepository;
        $this->hookRepository = $hookRepository;
        $this->widgetRepository = $widgetRepository;

        $this->header_widgets = $this->widgetRepository->findByHook($this->hookRepository->findOneBy(['alias' => 'HEADER']));
        $this->limit_for_list = intval($this->parameterRepository->findOneByAlias(['alias' => 'DAY_LIMIT_FOR_LISTING'])->getValue());
        $this->limit_for_cancel = intval($this->parameterRepository->findOneByAlias(['alias' => 'ORDER_CANCEL_DELAY'])->getValue());
    }

    /**
     * @throws Exception
     */
    #[Route('/', name: 'app_claim_index', methods: ['GET'])]
    public function index(): Response
    {
        if ($this->container->has('security.token_storage')) {
            $current_user = $this->getUser();
            if (!$current_user) {
                return $this->redirectToRoute('app_login');
            }
        } else {
            return $this->redirectToRoute('app_login');
        }

        $claim_count = intval($this->claimRepository->getClaimsCount($current_user->getGasStation()));

        return $this->render('claim/index.html.twig', [
            'root_uri' => 'Accueil',
            'title' => 'Tableau de bord',
            'module_mod_menu' => $this->moduleRepo->findByParam("isModule"),
            'dictionnary_mod_menu' => $this->moduleRepo->findByParam("isDictionnary"),
            'parameter_mod_menu' => $this->moduleRepo->findByParam("isParameter"),
            'user' => $current_user,
            'limit_for_list' => $this->limit_for_list,
            'user_role' => $current_user->getRole(),
            'header_widgets' => $this->header_widgets,
            'claims' => $this->claimRepository->getClaimGreaterThan($this->limit_for_list, $current_user),
            'claim_count' => $claim_count,
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/new', name: 'app_claim_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClaimStatusRepository $claimStatusRepository, ClaimStatisticRepository $claimStatisticRepository): Response
    {
        if ($this->container->has('security.token_storage')) {
            $current_user = $this->getUser();
            if (!$current_user) {
                return $this->redirectToRoute('app_login');
            }
        } else {
            return $this->redirectToRoute('app_login');
        }

        $claim_count = intval($this->claimRepository->getClaimsCount($current_user->getGasStation()));
        $claim = new Claim();
        $form = $this->createForm(ClaimType::class, $claim);
        $form->handleRequest($request);

        $max_order_id = 1;
        if($claim_count > 0) {
            $max_order_id_array = explode('-', $this->claimRepository->getMaxClaimId()[0]['reference']);
            $max_order_id = intval($max_order_id_array[1]) + 1;
        }
        $next_ref = ConfigFunc::formatClaimTicket($current_user->getGasStation()->getCodeSap(), $max_order_id);

        if ($request->get('claim_form') && $request->get('claim_form') == 'claim_add') {

            $description = $request->get('description');

            $claim->setReference($next_ref);
            $claim->setGasStation($current_user->getGasStation());
            $claim->setClaimStatus($claimStatusRepository->findOneBy(['id' => 1]));
            $claim->setCreatedAt(new DateTimeImmutable($request->get('proposalAppDate') . ' ' . $request->get('proposalAppTime')));
            $claim->setDescription($description);
            $claim->setIsMailSent(false);
            $claim->setIsNewlyAdded(true);
            $claim->setIsActivated(1);
            $claim->setIsDeleted(1);

            $claimStatistic = new ClaimStatistic();
            $claimStatistic->setSource('Web');
            $ua = ConfigFunc::getBrowser();
            $web_platform = $ua['name'] . "|" . $ua['version'] . "|" . $ua['platform'];
            $claimStatistic->setWebPlateform($web_platform);
            $claimStatisticRepository->save($claimStatistic, true);

            $claim->setClaimStatistic($claimStatistic);
            $this->claimRepository->save($claim, true);

            $this->addFlash('success', 'Vous avez saisi une réclamation en date du ' . date("d/m/Y", strtotime($request->get('proposalAppDate'))) . ' à ' . $request->get('proposalAppTime') . '. Vous pouvez consulter votre historique de proposition sur le panel "Historique"');
            return $this->redirectToRoute('app_claim_index', [], Response::HTTP_SEE_OTHER);

        }

        return $this->render('claim/new.html.twig', [
            'root_uri' => 'Accueil',
            'title' => 'Tableau de bord',
            'module_mod_menu' => $this->moduleRepo->findByParam("isModule"),
            'dictionnary_mod_menu' => $this->moduleRepo->findByParam("isDictionnary"),
            'parameter_mod_menu' => $this->moduleRepo->findByParam("isParameter"),
            'user' => $current_user,
            'limit_for_list' => $this->limit_for_list,
            'user_role' => $current_user->getRole(),
            'header_widgets' => $this->header_widgets,
            'nextCycle' => ConfigFunc::nextCycle($this->parameterRepository),
            'claim_count' => $claim_count,
            'form' => $form,
            'next_ref' => $next_ref,
        ]);
    }

    #[Route('/{id}', name: 'app_claim_show', methods: ['GET'])]
    public function show(Claim $claim): Response
    {
        if ($this->container->has('security.token_storage')) {
            $current_user = $this->getUser();
            if (!$current_user) {
                return $this->redirectToRoute('app_login');
            }
        } else {
            return $this->redirectToRoute('app_login');
        }

        $claim_count = intval($this->claimRepository->getClaimsCount($current_user->getGasStation()));

        return $this->render('claim/show.html.twig', [
            'root_uri' => 'Accueil',
            'title' => 'Tableau de bord',
            'module_mod_menu' => $this->moduleRepo->findByParam("isModule"),
            'dictionnary_mod_menu' => $this->moduleRepo->findByParam("isDictionnary"),
            'parameter_mod_menu' => $this->moduleRepo->findByParam("isParameter"),
            'user' => $current_user,
            'limit_for_list' => $this->limit_for_list,
            'limit_for_cancel' => $this->limit_for_cancel,
            'user_role' => $current_user->getRole(),
            'header_widgets' => $this->header_widgets,
            'claim_count' => $claim_count,
            'claim' => $claim,
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/{id}/edit', name: 'app_claim_edit', methods: ['GET', 'POST'])]
    public function edit(Claim $claim, Request $request, ClaimStatusRepository $claimStatusRepository): Response
    {
        if ($this->container->has('security.token_storage')) {
            $current_user = $this->getUser();
            if (!$current_user) {
                return $this->redirectToRoute('app_login');
            }
        } else {
            return $this->redirectToRoute('app_login');
        }

        $claim_count = intval($this->claimRepository->getClaimsCount($current_user->getGasStation()));
        $form = $this->createForm(ClaimType::class, $claim);
        $form->handleRequest($request);

        if ($request->get('claim_form') && $request->get('claim_form') == 'claim_edit') {

            $description = $request->get('description');
            $claim->setDescription($description);
            $claim->setUpdatedAt(new DateTimeImmutable($request->get('proposalAppDate') . ' ' . $request->get('proposalAppTime')));
            $this->claimRepository->save($claim, true);

            $this->addFlash('success', 'Vous avez modifié votre réclamation en date du ' . date("d/m/Y", strtotime($request->get('proposalAppDate'))) . ' à ' . $request->get('proposalAppTime') . ' avec succès.');
            return $this->redirectToRoute('app_claim_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('claim/edit.html.twig', [
            'root_uri' => 'Accueil',
            'title' => 'Tableau de bord',
            'module_mod_menu' => $this->moduleRepo->findByParam("isModule"),
            'dictionnary_mod_menu' => $this->moduleRepo->findByParam("isDictionnary"),
            'parameter_mod_menu' => $this->moduleRepo->findByParam("isParameter"),
            'user' => $current_user,
            'limit_for_list' => $this->limit_for_list,
            'limit_for_cancel' => $this->limit_for_cancel,
            'user_role' => $current_user->getRole(),
            'header_widgets' => $this->header_widgets,
            'nextCycle' => ConfigFunc::nextCycle($this->parameterRepository),
            'claim_count' => $claim_count,
            'form' => $form,
            'claim' => $claim,
            'next_ref' => $claim->getReference(),
            'button_label' => 'Mettre à jour',
        ]);
    }

    #[Route('/{id}', name: 'app_claim_delete', methods: ['POST'])]
    public function delete(Request $request, Claim $claim, ClaimRepository $claimRepository, ClaimStatisticRepository $claimStatisticRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $claim->getId(), $request->request->get('_token'))) {
            $claimStatistic = $claim->getClaimStatistic();
            $claimRepository->remove($claim, true);
            $claimStatisticRepository->remove($claimStatistic, true);

        }
        return $this->redirectToRoute('app_claim_index', [], Response::HTTP_SEE_OTHER);
    }
}