<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use App\Trait\DateTimeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
#[ORM\Table(name: '`module`')]
#[ORM\HasLifecycleCallbacks]
class Module
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameInDb = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    private ?string $icon = null;

    #[ORM\Column(type: Types::BOOLEAN, options: [
        "default" => false
    ])]
    private ?bool $isParameter = null;

    #[ORM\Column(type: Types::BOOLEAN, options: [
        "default" => false
    ])]
    private ?bool $isDictionnary = null;

    #[ORM\Column]
    private ?bool $isModule = null;

    #[ORM\OneToMany(mappedBy: 'module', targetEntity: Widget::class)]
    private Collection $widgets;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'modules')]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $modules;

    #[ORM\OneToMany(mappedBy: 'module', targetEntity: Topic::class)]
    private Collection $topics;

    #[ORM\OneToMany(mappedBy: 'labelType', targetEntity: Message::class)]
    private Collection $messages;

    public function __construct()
    {
        $this->widgets = new ArrayCollection();
        $this->modules = new ArrayCollection();
        $this->topics = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameInDb(): ?string
    {
        return $this->nameInDb;
    }

    public function setNameInDb(string $nameInDb): self
    {
        $this->nameInDb = $nameInDb;
        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;
        return $this;
    }

    public function isIsParameter(): ?bool
    {
        return $this->isParameter;
    }

    public function setIsParameter(bool $isParameter): self
    {
        $this->isParameter = $isParameter;
        return $this;
    }

    public function isIsDictionnary(): ?bool
    {
        return $this->isDictionnary;
    }

    public function setIsDictionnary(bool $isDictionnary): self
    {
        $this->isDictionnary = $isDictionnary;
        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    public function isIsModule(): ?bool
    {
        return $this->isModule;
    }

    public function setIsModule(bool $isModule): self
    {
        $this->isModule = $isModule;
        return $this;
    }

    /**
     * @return Collection<int, Widget>
     */
    public function getWidgets(): Collection
    {
        return $this->widgets;
    }

    public function addWidget(Widget $widget): self
    {
        if (!$this->widgets->contains($widget)) {
            $this->widgets->add($widget);
            $widget->setModule($this);
        }
        return $this;
    }

    public function removeWidget(Widget $widget): self
    {
        if ($this->widgets->removeElement($widget)) {
            // set the owning side to null (unless already changed)
            if ($widget->getModule() === $this) {
                $widget->setModule(null);
            }
        }

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(self $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules->add($module);
            $module->setParent($this);
        }

        return $this;
    }

    public function removeModule(self $module): self
    {
        if ($this->modules->removeElement($module)) {
            // set the owning side to null (unless already changed)
            if ($module->getParent() === $this) {
                $module->setParent(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Topic>
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(Topic $topic): self
    {
        if (!$this->topics->contains($topic)) {
            $this->topics->add($topic);
            $topic->setModule($this);
        }

        return $this;
    }

    public function removeTopic(Topic $topic): self
    {
        if ($this->topics->removeElement($topic)) {
            // set the owning side to null (unless already changed)
            if ($topic->getModule() === $this) {
                $topic->setModule(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setLabelType($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getLabelType() === $this) {
                $message->setLabelType(null);
            }
        }

        return $this;
    }
}
