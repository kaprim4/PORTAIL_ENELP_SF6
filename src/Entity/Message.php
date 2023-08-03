<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use App\Trait\DateTimeTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ORM\Table(name: '`message`')]
#[ORM\HasLifecycleCallbacks]
class Message
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    private ?Topic $topic = null;

    #[ORM\ManyToOne(inversedBy: 'senders')]
    private ?User $sender = null;

    #[ORM\ManyToOne(inversedBy: 'receivers')]
    private ?User $receiver = null;

    #[ORM\ManyToOne(inversedBy: 'copies')]
    private ?User $copy = null;

    #[ORM\ManyToOne(inversedBy: 'repliesTo')]
    private ?User $replyTo = null;

    #[ORM\Column(type: Types::INTEGER, options: [
        "default" => 1
    ])]
    private ?int $priority = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $subject = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $body = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $bodyPlainText = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true, options: [
        "default" => false
    ])]
    private ?bool $isStarred = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true, options: [
        "default" => false
    ])]
    private ?bool $isReaded = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    private ?Module $labelType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTopic(): ?Topic
    {
        return $this->topic;
    }

    public function setTopic(?Topic $topic): self
    {
        $this->topic = $topic;
        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;
        return $this;
    }

    public function getReceiver(): ?User
    {
        return $this->receiver;
    }

    public function setReceiver(?User $receiver): self
    {
        $this->receiver = $receiver;
        return $this;
    }

    public function getCopy(): ?User
    {
        return $this->copy;
    }

    public function setCopy(?User $copy): self
    {
        $this->copy = $copy;
        return $this;
    }

    public function getReplyTo(): ?User
    {
        return $this->replyTo;
    }

    public function setReplyTo(?User $replyTo): self
    {
        $this->replyTo = $replyTo;
        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): self
    {
        $this->priority = $priority;
        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBodyPlainText(): ?string
    {
        return $this->bodyPlainText;
    }

    /**
     * @param string|null $bodyPlainText
     */
    public function setBodyPlainText(?string $bodyPlainText): void
    {
        $this->bodyPlainText = $bodyPlainText;
    }

    public function isIsStarred(): ?bool
    {
        return $this->isStarred;
    }

    public function setIsStarred(?bool $isStarred): self
    {
        $this->isStarred = $isStarred;

        return $this;
    }

    public function isIsReaded(): ?bool
    {
        return $this->isReaded;
    }

    public function setIsReaded(?bool $isReaded): self
    {
        $this->isReaded = $isReaded;

        return $this;
    }

    public function getLabelType(): ?Module
    {
        return $this->labelType;
    }

    public function setLabelType(?Module $labelType): self
    {
        $this->labelType = $labelType;

        return $this;
    }
}
