<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Repositories\Infrastructure\Mapper;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Repositories\Infrastructure\Mapper\Interfaces\SluggableDomainEntityMapperInterface;
use Carbon\Carbon;

abstract class AbstractSluggableDomainEntityMapper extends AbstractDomainEntityMapper implements SluggableDomainEntityMapperInterface
{
    public function findBySlug(string $slug, bool $includeUnpublished = false): ?DomainEntityInterface
    {
        $query = $this->db->table($this->getTableName())->where('slug', '=', $slug);
        //@codeCoverageIgnoreStart
        if ($this->publishes() && !$includeUnpublished) {
            $now = new Carbon();
            $query = $query->whereDate('publication_date', '<=', $now->format($this->mysqlDateFormat));
        }
        //@codeCoverageIgnoreEnd
        if ($this->softDeletes()) {
            $query = $query->whereNull('deleted_at');
        }

        $result = $query->first();

        return $result ? $this->mapEntity((array) $result) : null;
    }

    public function slugExists(string $slug): bool
    {
        $query = $this->db->table($this->getTableName())->where('slug', '=', $slug);
        return $query->first() !== null;
    }
}
