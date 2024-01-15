<?php

namespace App\Controller;

use App\Entity\Warranty;
use App\Form\WarrantyFormType;
use App\Repository\WarrantyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WarrantiesController extends AbstractController
{
    private $warrantyRepository;
    private $em;
    public function __construct(WarrantyRepository $warrantyRepository , EntityManagerInterface $em)
    {
        $this->warrantyRepository = $warrantyRepository;
        $this->em = $em;
    }


    #[Route('/warranties', methods:['GET'], name: 'warranties')]
    public function index(): Response
    {
        $warranties = $this->warrantyRepository->findAll();

        return $this->render('/views/warranties.html.twig', [
            'warranties' => $warranties
        ]);
    }

    #[Route('/add_warranty', name: 'add_warranty')]
    public function addWarranty(Request $request): Response
    {
        /*if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        */
        $warranty = new Warranty();
        $form = $this->createForm(WarrantyFormType::class, $warranty);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $newWarranty = $form->getData();
            $newWarranty->setIdUser(3);
            $newWarranty->setActive(1);
            $receipt = $form->get('receipt')->getData();
            if($receipt){
                $newFileName = uniqid() . '.' . $receipt->guessExtension();
                
                try{
                    $receipt->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads',
                        $newFileName
                    );
                } catch(FileException $e){
                    return new Response($e->getMessage());
                }

                $newWarranty->setReceipt($newFileName);
            }
            $this->em->persist($newWarranty);
            $this->em->flush();

            return $this->redirectToRoute('warranties');
        }
        
        return $this->render('/views/add_warranty.html.twig', [
            'form' => $form->createView()
        ]);
    }

}