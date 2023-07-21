<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $availableUnits = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isAvailable = true;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $price = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductImage::class, orphanRemoval: true)]
    private Collection $productImages;

    #[ORM\Column]
    private ?bool $isListed = true;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vendor $vendor = null;

    #[ORM\ManyToMany(targetEntity: VendorOrder::class, mappedBy: 'products')]
    private Collection $vendorOrders;

    public function __construct()
    {
        $this->productImages = new ArrayCollection();
        $this->vendorOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAvailableUnits(): ?int
    {
        return $this->availableUnits;
    }

    public function setAvailableUnits(int $availableUnits): static
    {
        $this->availableUnits = $availableUnits;

        return $this;
    }

    public function isIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(?bool $isAvailable): static
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, ProductImage>
     */
    public function getProductImages(): Collection
    {
        return $this->productImages;
    }

    public function addProductImage(ProductImage $productImage): static
    {
        if (!$this->productImages->contains($productImage)) {
            $this->productImages->add($productImage);
            $productImage->setProduct($this);
        }

        return $this;
    }

    public function removeProductImage(ProductImage $productImage): static
    {
        if ($this->productImages->removeElement($productImage)) {
            // set the owning side to null (unless already changed)
            if ($productImage->getProduct() === $this) {
                $productImage->setProduct(null);
            }
        }

        return $this;
    }

    public function isIsListed(): ?bool
    {
        return $this->isListed;
    }

    public function setIsListed(bool $isListed): static
    {
        $this->isListed = $isListed;

        return $this;
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
     * @return Collection<int, VendorOrder>
     */
    public function getVendorOrders(): Collection
    {
        return $this->vendorOrders;
    }

    public function addVendorOrder(VendorOrder $vendorOrder): static
    {
        if (!$this->vendorOrders->contains($vendorOrder)) {
            $this->vendorOrders->add($vendorOrder);
            $vendorOrder->addProduct($this);
        }

        return $this;
    }

    public function removeVendorOrder(VendorOrder $vendorOrder): static
    {
        if ($this->vendorOrders->removeElement($vendorOrder)) {
            $vendorOrder->removeProduct($this);
        }

        return $this;
    }
}
