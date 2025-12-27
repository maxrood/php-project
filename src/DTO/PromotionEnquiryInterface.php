<?php

namespace App\DTO;

use App\Entity\Product;

interface PromotionEnquiryInterface
{
    public function getProduct(): ?Product;

    public function getRequestDate(): ?string;
    public function getVoucherCode(): ?string;

    public function setPromotionId(int $promotionId);

    public function setPromotionName(string $promotionName);
}