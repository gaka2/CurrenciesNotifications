<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\Currency;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=9)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="date")
     */
    private $birthDate;

    /**
     * @ORM\OneToMany(targetEntity=NotificationSettings::class, mappedBy="user", orphanRemoval=true, cascade={"persist"})
     */
    private $notificationsSettngs;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $hashCode;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    public function __construct()
    {
        $this->notificationsSettngs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return Collection|NotificationSettings[]
     */
    public function getNotificationsSettngs(): Collection
    {
        return $this->notificationsSettngs;
    }

    public function addNotificationsSettng(NotificationSettings $notificationsSettng): self
    {
        if (!$this->notificationsSettngs->contains($notificationsSettng)) {
            $this->notificationsSettngs[] = $notificationsSettng;
            $notificationsSettng->setUser($this);
        }

        return $this;
    }

    public function removeNotificationsSettng(NotificationSettings $notificationsSettng): self
    {
        if ($this->notificationsSettngs->removeElement($notificationsSettng)) {
            // set the owning side to null (unless already changed)
            if ($notificationsSettng->getUser() === $this) {
                $notificationsSettng->setUser(null);
            }
        }

        return $this;
    }
	
	public function getNotificationSettingsForCurrency(Currency $currency) : ?NotificationSettings {

		foreach ($this->notificationsSettngs as $notificationsSettng) {
			if ($notificationsSettng->getCurrency()->getId() === $currency->getId()) {
				return $notificationsSettng;
			}
		}
		
		return null;
	}

    public function getHashCode(): ?string
    {
        return $this->hashCode;
    }

    public function setHashCode(string $hashCode): self
    {
        $this->hashCode = $hashCode;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
	
}
