<?php

namespace App\Entity;

use App\Repository\VendorOrderInvoiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VendorOrderInvoiceRepository::class)]
class VendorOrderInvoice extends AbstractInvoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'vendorOrderInvoice')]
    private ?VendorOrder $vendorOrder = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $vendorValleyComissionAmount = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getVendorValleyComissionAmount(): ?string
    {
        return $this->vendorValleyComissionAmount;
    }

    public function setVendorValleyComissionAmount(string $vendorValleyComissionAmount): static
    {
        $this->vendorValleyComissionAmount = $vendorValleyComissionAmount;

        return $this;
    }
}
