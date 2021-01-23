<?php
namespace Services\Core\Infrastructure\Mapper;

use Services\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;
use Services\Core\Infrastructure\Mapper\Interfaces\SluggableDomainEntityMapperInterface;
use Services\Core\Infrastructure\Mapper\AbstractDomainEntityMapper;
use Services\Core\Domain\Interfaces\DomainEntityInterface;
use Carbon\Carbon;

/**
* @codeCoverageIgnoreStart
*/
abstract class AbstractSluggableDomainEntityMapper extends AbstractDomainEntityMapper implements SluggableDomainEntityMapperInterface
{
    public function findBySlug(string $slug, bool $includeUnpublished) : ? DomainEntityInterface
    {
        $query = $this->db->table($this->getTableName())->where('slug', '=', $slug);
        if ($this->publishes() && !$includeUnpublished) {
            $now = new Carbon;
            $query = $query->whereDate('publication_date', '<=', $now->format($this->mysqlDateFormat));
        }
        
        if ($this->softDeletes()) {
            $query = $query->whereNull('deleted_at');
        }
        
        $result = $query->first();

        return $result ? $this->mapEntity((array) $result) : null;
    }
}
