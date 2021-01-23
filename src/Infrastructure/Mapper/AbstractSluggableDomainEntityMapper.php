<?php
namespace Fifthgate\Objectivity\Repositories\Infrastructure\Mapper;

use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;

use Fifthgate\Objectivity\Repositories\Infrastructure\Mapper\Interfaces\SluggableDomainEntityMapperInterface;
use Fifthgate\Objectivity\Repositories\Infrastructure\Mapper\AbstractDomainEntityMapper;

use Carbon\Carbon;

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
