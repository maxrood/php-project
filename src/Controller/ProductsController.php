<?php

namespace App\Controller;

use App\DTO\LowestPriceEnquiry;
use App\Filter\PromotionsFilterInterface;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route as AttributeRoute;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Promotion;

class ProductsController extends AbstractController
{
  public function __construct(
    private ProductRepository $repository,
    private EntityManagerInterface $entityManager  
  )
  {
    
  }

  #[AttributeRoute('/products/{id}/lowest-price', name: 'lowest-price', methods: 'POST')]
  public function lowestPrice(Request $request, int $id, SerializerInterface $serializer, PromotionsFilterInterface $promotionsFilter): Response
  {
    if($request->headers->has('force_fail')){
      
      return new JsonResponse(
        ['error' => 'Promotions Engine failure message'],
        $request->headers->get('force-fail')
      );
    }

    $lowestPriceEnquiry = $serializer->deserialize($request->getContent(), LowestPriceEnquiry::class, 'json');

    $product = $this->repository->find($id);

    $lowestPriceEnquiry->setProduct($product);

    $promotions = $this->entityManager->getRepository(Promotion::class)->findValidForProduct(
      $product,
      date_create_immutable($lowestPriceEnquiry->getRequestDate())
    );

    $modifiedEnquiry = $promotionsFilter->apply($lowestPriceEnquiry, $promotions);

    $responseContent = $serializer->serialize($modifiedEnquiry, 'json');

    return new Response($responseContent, 200);
  }




  #[AttributeRoute('/products/{id}/promotions', name: 'promotions', methods: 'GET')]
  public function promotions()
  {

  }
}