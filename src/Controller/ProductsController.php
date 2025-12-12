<?php

namespace App\Controller;

use App\DTO\LowestPriceEnquiry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route as AttributeRoute;
use Symfony\Component\Serializer\SerializerInterface;

class ProductsController extends AbstractController
{
  #[AttributeRoute('/products/{id}/lowest-price', name: 'lowest-price', methods: 'POST')]
  public function lowestPrice(Request $request, int $id, SerializerInterface $serializer): Response
  {
    if($request->headers->has('force_fail')){
      
      return new JsonResponse(
        ['error' => 'Promotions Engine failure message'],
        $request->headers->get('force-fail')
      );
    }

    dd($serializer);

    $lowestPriceEnquiry = $serializer->deserialize($request->getContent(), LowestPriceEnquiry::class, 'json');
    dd($lowestPriceEnquiry);
    
    return new JsonResponse([
      'quantity' => 5,
      'request_location' => 'PL',
      'voucher_code' => 'OU812',
      'request_date' => '2025-01-12',
      'product_id' => $id,
      'price' => 100,
      'discounted_price' => 50,
      'promotion_id' => 3,
      'promotion_name' => 'Black Friday half price sale'

    ], 200);
  }




  #[AttributeRoute('/products/{id}/promotions', name: 'promotions', methods: 'GET')]
  public function promotions()
  {

  }
}