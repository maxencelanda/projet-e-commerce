<?php

namespace App\Entity;

use App\Repository\DetailOrdersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailOrdersRepository::class)]
class DetailOrders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $id_product = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Orders $id_orders = null;

    #[ORM\Column]
    private ?int $quantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProduct(): ?Product
    {
        return $this->id_product;
    }

    public function setIdProduct(Product $id_product): static
    {
        $this->id_product = $id_product;

        return $this;
    }

    public function getIdOrders(): ?Orders
    {
        return $this->id_orders;
    }

    public function setIdOrders(Orders $id_orders): static
    {
        $this->id_orders = $id_orders;

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
}
