<?php

namespace App\Tests\unit;

use App\DTO\LowestPriceEnquiry;
use App\Filter\LowestPriceFilter;
use App\Tests\ServiceTestCase;
use App\Entity\Promotion;



class LowestPriceFilterTest extends ServiceTestCase
{
  public function test_lowest_price_promotions_filtering_is_applied_correctly(): void
  {

    $enquiry = new LowestPriceEnquiry();

    $promotions = $this->promotionsDataProvider();

    $lowestPriceFilter = $this->container->get(LowestPriceFilter::class);

    /** @var LowestPriceEnquiry $filteredEnquiry */
    $filteredEnquiry = $lowestPriceFilter->apply($enquiry, ...$promotions);

    $this->assertSame(100, $filteredEnquiry->getPrice());
    $this->assertSame(50, $filteredEnquiry->getDiscountedPrice());
    $this->assertSame('Black Friday half price sale', $filteredEnquiry->getPromotionName());
  }

  public function promotionsDataProvider(): array
  {
    
    $promotionOne = new Promotion();
    $promotionOne->setName('Black Friday half price sale');
    $promotionOne->setAdjustment(0.5);
    $promotionOne->setCriteria(["from" => "2022-12-13", "to" => "2022-12-18"]);
    $promotionOne->setType('date_range_multiplier');

    $promotionTwo = new Promotion();
    $promotionTwo->setName('Voucher OU812');
    $promotionTwo->setAdjustment(100);
    $promotionTwo->setCriteria(["code" => "OU812"]);
    $promotionTwo->setType('fixed_price_voucher');

    $promotionThree = new Promotion();
    $promotionThree->setName('Buy one get one free');
    $promotionThree->setAdjustment(0.5);
    $promotionThree->setCriteria(["minimum_quantity" => 2]); 
    $promotionThree->setType('even_items_multiplier');

    return [$promotionOne, $promotionTwo, $promotionThree];
  }
}