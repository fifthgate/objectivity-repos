<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Repositories\Tests\Mocks;

use Fifthgate\Objectivity\Core\Domain\AbstractSoftDeletingDomainEntity;
use Fifthgate\Objectivity\Core\Domain\Interfaces\SluggableDomainEntityInterface;

class MockSluggableDomainEntity extends AbstractSoftDeletingDomainEntity implements SluggableDomainEntityInterface
{
    protected string $slug;

    protected string $name;

    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
