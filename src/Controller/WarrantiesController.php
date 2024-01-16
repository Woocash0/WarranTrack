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
            }else{
                $newWarranty->setReceipt('no-image.svg');
            }
            $this->em->persist($newWarranty);
            $this->em->flush();

            return $this->redirectToRoute('warranties');
        }
        
        return $this->render('/views/add_warranty.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/edit_warranty/{id}', name: 'edit_warranty')]
    public function editWarranty($id, Request $request): Response{
        
        $warranty = $this->warrantyRepository->find($id);
        $form = $this->createForm(WarrantyFormType::class, $warranty);

        $form->handleRequest($request);
        $receipt = $form->get('receipt')->getData();
        if($form->isSubmitted() && $form->isValid()){
            if($receipt){
                if($warranty->getReceipt() !== null){
                        $this->getParameter('kernel.project_dir') . $warranty->getReceipt();

                        $newFileName = uniqid() . '.' . $receipt->guessExtension();

                        try{
                            $receipt->move(
                                $this->getParameter('kernel.project_dir') . '/public/uploads',
                                $newFileName
                            );
                        } catch(FileException $e){
                            return new Response($e->getMessage());
                        }

                        $warranty->setReceipt($newFileName);
                        $this->em->flush();
                        return $this->redirectToRoute('warranties');
                } else{
                    dd('jest nullem');
                }

            } else{
                $warranty->setCategory($form->get('category')->getData());
                $warranty->setProductName($form->get('product_name')->getData());
                $warranty->setPurchaseDate($form->get('purchase_date')->getData());
                $warranty->setWarrantyPeriod($form->get('warranty_period')->getData());

                $this->em->flush();
                return $this->redirectToRoute('warranties');

            }
        }

        return $this->render('/views/edit_warranty.html.twig', [
            'warranty' => $warranty,
            'form' => $form->createView()
        ]);

    }

}