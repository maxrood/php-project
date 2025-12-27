<?php

namespace App\Controller;

use App\Cache\PromotionCache;
use App\DTO\LowestPriceEnquiry;
use App\Filter\PriceFilterInterface;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route as AttributeRoute;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Promotion;
use JsonException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class ProductsController extends AbstractController
{
  public function __construct(
    private ProductRepository $repository,
    private EntityManagerInterface $entityManager  
  )
  {
    
  }

  #[AttributeRoute('/products/{id}/lowest-price', name: 'lowest-price', methods: 'POST')]
  public function lowestPrice(Request $request, int $id, SerializerInterface $serializer, PriceFilterInterface $promotionsFilter, PromotionCache $promotionCache): Response
  {

    $lowestPriceEnquiry = $serializer->deserialize($request->getContent(), LowestPriceEnquiry::class, 'json');

    $product = $this->repository->findOrFail($id);

    $lowestPriceEnquiry->setProduct($product);

    $promotions =$promotionCache->findValidForProduct($product, $lowestPriceEnquiry->getRequestDate());

    $modifiedEnquiry = $promotionsFilter->apply($lowestPriceEnquiry, ...$promotions);

    $responseContent = $serializer->serialize($modifiedEnquiry, 'json');

    return new JsonResponse(data: $responseContent, status: Response::HTTP_OK, json: true);
  }


  #[AttributeRoute('/products/{id}/promotions', name: 'promotions', methods: 'GET')]
  public function promotions()
  {

  }
}