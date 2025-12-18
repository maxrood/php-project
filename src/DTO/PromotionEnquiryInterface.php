<?php

namespace App\DTO;

use JsonSerializable;

interface PromotionEnquiryInterface
{
  //подумати над вирішенням, можливо видалити пізніше
    public function setDiscountedPrice(?int $discountedPrice): self;
    public function setPrice(?int $price): self;
    public function setPromotionId(?int $promotionId): self;
    public function setPromotionName(?string $promotionName): self;
}