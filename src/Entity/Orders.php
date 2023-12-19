<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
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
}
