<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\Inquiry\Domain\Enum\InquiryOrigin;
use Impexta\User\Domain\Entity\AdminUserInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface InquiryInterface extends EntityInterface
{
    public function getId(): int;

    public function getAssignee(): ?AdminUserInterface;

    public function setAssignee(?AdminUserInterface $assignee): void;

    public function getOrigin(): InquiryOrigin;

    public function getReceivedAt(): \DateTimeImmutable;

    public function getExpiration(): \DateTimeImmutable;

    public function getClient(): ClientInterface;

    public function getSale(): float;

    public function setSale(float $sale): void;

    public function getNote(): ?string;

    public function setNote(?string $note): void;

    /**
     * @return ArrayCollection<int, InquiryItemRequestInterface>
     */
    public function getItemRequests(): Collection;

    public function addItemRequest(InquiryItemRequestInterface $itemRequest): void;

    public function removeItemRequest(InquiryItemRequestInterface $itemRequest): void;
}
