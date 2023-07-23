<?php

namespace App\Entity;

use App\Repository\AbstractInvoiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;

#[ORM\Entity(repositoryClass: AbstractInvoiceRepository::class)]
#[InheritanceType('SINGLE_TABLE')]
class AbstractInvoice extends Base
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $subTotal = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $fedTaxAmount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $provincialTaxAmount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $grandTotal = null;

    #[ORM\Column(length: 255)]
    private ?string $invoiceNumber = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubTotal(): ?string
    {
        return $this->subTotal;
    }

    public function setSubTotal(string $subTotal): static
    {
        $this->subTotal = $subTotal;

        return $this;
    }

    public function getFedTaxAmount(): ?string
    {
        return $this->fedTaxAmount;
    }

    public function setFedTaxAmount(string $fedTaxAmount): static
    {
        $this->fedTaxAmount = $fedTaxAmount;

        return $this;
    }

    public function getProvincialTaxAmount(): ?string
    {
        return $this->provincialTaxAmount;
    }

    public function setprovincialTaxAmount(string $provincialTaxAmount): static
    {
        $this->provincialTaxAmount = $provincialTaxAmount;

        return $this;
    }

    public function getGrandTotal(): ?string
    {
        return $this->grandTotal;
    }

    public function setGrandTotal(string $grandTotal): static
    {
        $this->grandTotal = $grandTotal;

        return $this;
    }

    public function getInvoiceNumber(): ?string
    {
        return $this->invoiceNumber;
    }

    public function setInvoiceNumber(string $invoiceNumber): static
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }
}
