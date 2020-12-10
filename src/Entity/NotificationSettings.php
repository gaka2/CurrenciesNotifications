<?php

namespace App\Entity;

use App\Repository\NotificationSettingsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotificationSettingsRepository::class)
 */
class NotificationSettings
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Currency::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $currency;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=10)
     */
    private $minimumRateThreshold;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=10)
     */
    private $maximumRateThreshold;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="notificationsSettngs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(?Currency $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getMinimumRateThreshold(): ?string
    {
        return $this->minimumRateThreshold;
    }

    public function setMinimumRateThreshold(string $minimumRateThreshold): self
    {
        $this->minimumRateThreshold = $minimumRateThreshold;

        return $this;
    }

    public function getMaximumRateThreshold(): ?string
    {
        return $this->maximumRateThreshold;
    }

    public function setMaximumRateThreshold(string $maximumRateThreshold): self
    {
        $this->maximumRateThreshold = $maximumRateThreshold;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
