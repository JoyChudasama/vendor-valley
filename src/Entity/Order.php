<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order extends Base
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $subTotal = null;

    #[ORM\OneToMany(mappedBy: 'relatedOrder', targetEntity: OrderItem::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $orderItems;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $orderNumber = null;

    #[ORM\OneToOne(mappedBy: 'relatedOrder', cascade: ['persist', 'remove'])]
    private ?OrderInvoice $orderInvoice = null;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): static
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setRelatedOrder($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): static
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getRelatedOrder() === $this) {
                $orderItem->setRelatedOrder(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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

    public function getOrderInvoice(): ?OrderInvoice
    {
        return $this->orderInvoice;
    }

    public function setOrderInvoice(?OrderInvoice $orderInvoice): static
    {
        // unset the owning side of the relation if necessary
        if ($orderInvoice === null && $this->orderInvoice !== null) {
            $this->orderInvoice->setRelatedOrder(null);
        }

        // set the owning side of the relation if necessary
        if ($orderInvoice !== null && $orderInvoice->getRelatedOrder() !== $this) {
            $orderInvoice->setRelatedOrder($this);
        }

        $this->orderInvoice = $orderInvoice;

        return $this;
    }
}
