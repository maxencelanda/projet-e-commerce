<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Account $account = null;

    #[ORM\OneToOne(mappedBy: 'orders', cascade: ['persist', 'remove'])]
    private ?DetailOrders $detailOrders = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateOrder = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeOrder $typeOrder = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): static
    {
        $this->account = $account;

        return $this;
    }

    public function getDetailOrders(): ?DetailOrders
    {
        return $this->detailOrders;
    }

    public function setDetailOrders(DetailOrders $detailOrders): static
    {
        // set the owning side of the relation if necessary
        if ($detailOrders->getOrders() !== $this) {
            $detailOrders->setOrders($this);
        }

        $this->detailOrders = $detailOrders;

        return $this;
    }

    public function getDateOrder(): ?\DateTimeInterface
    {
        return $this->dateOrder;
    }

    public function setDateOrder(\DateTimeInterface $dateOrder): static
    {
        $this->dateOrder = $dateOrder;

        return $this;
    }

    public function getTypeOrder(): ?TypeOrder
    {
        return $this->typeOrder;
    }

    public function setTypeOrder(?TypeOrder $typeOrder): static
    {
        $this->typeOrder = $typeOrder;

        return $this;
    }
}
