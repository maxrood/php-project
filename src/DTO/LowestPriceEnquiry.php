<?php

namespace App\DTO;

use App\Entity\Product;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;


class LowestPriceEnquiry implements PriceEnquiryInterface
{
    #[Ignore]
    private ?Product $product;

    #[NotBlank]
    #[Positive]

    private ?int $quantity = 1;
    private ?string $requestLocation;
    private ?string $voucherCode;

    #[NotBlank]
    private ?string $requestDate;

    #[Positive]
    private ?int $price;
    private ?int $discountedPrice;
    private ?int $promotionId;
    private ?string $promotionName;

    /**
    * @return Product|null
    */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
    * @param Product|null $product
    */
    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getRequestLocation(): ?string
    {
        return $this->requestLocation;
    }

    public function setRequestLocation(?string $requestLocation): void
    {
        $this->requestLocation = $requestLocation;
    }

    public function getVoucherCode(): ?string
    {
        return $this->voucherCode;
    }

    public function setVoucherCode(?string $voucherCode): void
    {
        $this->voucherCode = $voucherCode;
    }

    public function getRequestDate(): ?string
    {
        return $this->requestDate;
    }

    public function setRequestDate(?string $requestDate): void
    {
        $this->requestDate = $requestDate;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self //поміняти self на void і видалити return $this;
    {
        $this->price = $price;
        return $this;
    }

    public function getDiscountedPrice(): ?int
    {
        return $this->discountedPrice;
    }

    public function setDiscountedPrice(?int $discountedPrice): self //поміняти self на void і видалити return $this;
    {
        $this->discountedPrice = $discountedPrice;
        return $this;
    }

    public function getPromotionId(): ?int
    {
        return $this->promotionId;
    }

    public function setPromotionId(?int $promotionId): self //поміняти self на void і видалити return $this;
    {
        $this->promotionId = $promotionId;
        return $this;
    }

    public function getPromotionName(): ?string
    {
        return $this->promotionName;
    }

    public function setPromotionName(?string $promotionName): self //поміняти self на void і видалити return $this;
    {
        $this->promotionName = $promotionName;
        return $this;
    }
    
}