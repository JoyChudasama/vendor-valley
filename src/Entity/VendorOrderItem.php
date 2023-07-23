<?php

namespace App\Entity;

use App\Repository\VendorOrderItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VendorOrderItemRepository::class)]
class VendorOrderItem extends Base
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'vendorOrderItems')]
    private ?Product $product = null;

    #[ORM\Column]
    private ?int $quantity = 1;

    #[ORM\ManyToOne(inversedBy: 'vendorOrderItems')]
    private ?VendorOrder $vendorOrder = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getVendorOrder(): ?VendorOrder
    {
        return $this->vendorOrder;
    }

    public function setVendorOrder(?VendorOrder $vendorOrder): static
    {
        $this->vendorOrder = $vendorOrder;

        return $this;
    }

    public function getTotalAmount()
    {
        return $this->quantity * $this->product->getPrice();
    }
}
