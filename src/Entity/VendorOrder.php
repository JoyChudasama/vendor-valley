<?php

namespace App\Entity;

use App\Repository\VendorOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VendorOrderRepository::class)]
class VendorOrder extends Base
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'vendorOrders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vendor $vendor = null;

    #[ORM\OneToMany(mappedBy: 'vendorOrder', targetEntity: VendorOrderItem::class, cascade: ['persist', 'remove'])]
    private Collection $vendorOrderItems;

    #[ORM\Column(length: 255)]
    private ?string $orderNumber = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $subTotal = null;

    #[ORM\OneToOne(mappedBy: 'vendorOrder', cascade: ['persist', 'remove'])]
    private ?VendorOrderInvoice $vendorOrderInvoice = null;

    public function __construct()
    {
        $this->vendorOrderItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVendor(): ?Vendor
    {
        return $this->vendor;
    }

    public function setVendor(?Vendor $vendor): static
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * @return Collection<int, VendorOrderItem>
     */
    public function getVendorOrderItems(): Collection
    {
        return $this->vendorOrderItems;
    }

    public function addVendorOrderItem(VendorOrderItem $vendorOrderItem): static
    {
        if (!$this->vendorOrderItems->contains($vendorOrderItem)) {
            $this->vendorOrderItems->add($vendorOrderItem);
            $vendorOrderItem->setVendorOrder($this);
        }

        return $this;
    }

    public function removeVendorOrderItem(VendorOrderItem $vendorOrderItem): static
    {
        if ($this->vendorOrderItems->removeElement($vendorOrderItem)) {
            // set the owning side to null (unless already changed)
            if ($vendorOrderItem->getVendorOrder() === $this) {
                $vendorOrderItem->setVendorOrder(null);
            }
        }

        return $this;
    }

    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(string $orderNumber): static
    {
        $this->orderNumber = $orderNumber;

        return $this;
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

    public function getVendorOrderInvoice(): ?VendorOrderInvoice
    {
        return $this->vendorOrderInvoice;
    }

    public function setVendorOrderInvoice(?VendorOrderInvoice $vendorOrderInvoice): static
    {
        // unset the owning side of the relation if necessary
        if ($vendorOrderInvoice === null && $this->vendorOrderInvoice !== null) {
            $this->vendorOrderInvoice->setVendorOrder(null);
        }

        // set the owning side of the relation if necessary
        if ($vendorOrderInvoice !== null && $vendorOrderInvoice->getVendorOrder() !== $this) {
            $vendorOrderInvoice->setVendorOrder($this);
        }

        $this->vendorOrderInvoice = $vendorOrderInvoice;

        return $this;
    }
}
