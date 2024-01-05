<?php

namespace App\Controller;

use App\Entity\Warranty;
use App\Repository\WarrantyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WarrantiesController extends AbstractController
{
    private $warrantyRepository;
    public function __construct(WarrantyRepository $warrantyRepository)
    {
        $this->warrantyRepository = $warrantyRepository;
    }


    #[Route('/warranties', name: 'warranties')]
    public function index(): Response
    {
        $warranties = $this->warrantyRepository->findAll();

        return $this->render('/views/warranties.html.twig', [
            'warranties' => $warranties
        ]);
    }

}