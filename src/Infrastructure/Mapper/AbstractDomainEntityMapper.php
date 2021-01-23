<?php
namespace Fifthgate\Objectivity\Repositories\Infrastructure\Mapper;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;
use Fifthgate\Objectivity\Repositories\Infrastructure\Mapper\Interfaces\DomainEntityMapperInterface;
use Carbon\Carbon;
use Illuminate\Database\DatabaseManager as DB;

/**
 * @codeCoverageIgnore
 */
abstract class AbstractDomainEntityMapper implements DomainEntityMapperInterface
{
    protected $mysqlDateFormat = 'Y-m-d H:i:s';

    protected string $tableName;

    protected bool $publishes = false;

    protected bool $softDeletes = true;

    protected bool $usesSlugs = false;

    protected $idColumnName = 'id';

    protected $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    abstract public function makeCollection() : DomainEntityCollectionInterface;
    
    abstract protected function update(DomainEntityInterface $domainEntity) : DomainEntityInterface;

    abstract protected function create(DomainEntityInterface $domainEntity) : DomainEntityInterface;
    
    public function softDeletes() : bool
    {
        return $this->softDeletes;
    }

    public function publishes() : bool
    {
        return $this->publishes;
    }

    public function getIDColumnName() : string
    {
        return $this->idColumnName;
    }

    public function getTableName() : string
    {
        return $this->tableName;
    }

    public function findAll(bool $includeUnpublished = false) : ? DomainEntityCollectionInterface
    {
        $query = $this->db->table($this->getTableName());
        if ($this->softDeletes()) {
            $query = $query->whereNull('deleted_at');
        }
        if (!$includeUnpublished && $this->publishes()) {
            $now = new Carbon;
            $query = $query->whereDate('publication_date', '<=', $now->format('Y-m-d H:i:s'));
        }
        $results = $query->get()->toArray();

        return $results ? $this->mapMany($results) : null;
    }

    public function findMany(array $ids) : ? DomainEntityCollectionInterface
    {
        $query = $this->db->table($this->getTableName())->whereIn($this->getIDColumnName(), $ids);

        if ($this->softDeletes()) {
            $query = $query->whereNull('deleted_at');
        }
            
        $results = $query ->get()->toArray();
        return $results ? $this->mapMany($results) : null;
    }

    public function mapMany(array $results) : DomainEntityCollectionInterface
    {
        $collection = $this->makeCollection();
        foreach ($results as $result) {
            $collection->add($this->mapEntity((array) $result));
        }
        return $collection;
    }

    public function queryOne(array $queryArray) : ? DomainEntityInterface
    {
        $query = $this->db->table($this->getTableName());
        foreach ($queryArray as $col => $value) {
            $query = $query->where($col, '=', $value);
        }
        if ($this->softDeletes()) {
            $query = $query->whereNull('deleted_at');
        }
        $result = $query->first();

        return $result ? $this->mapEntity((array) $result) : null;
    }

    public function queryMany(array $queryArray) : ? DomainEntityCollectionInterface
    {
        $query = $this->db->table($this->getTableName());
        foreach ($queryArray as $col => $value) {
            $query = $result->where($col, '=', $value);
        }
        if ($this->softDeletes()) {
            $query = $query->whereNull('deleted_at');
        }
        $results = $query->get()->toArray();
        return $results ? $this->mapMany($results) : null;
    }

    public function find(int $id) : ? DomainEntityInterface
    {
        $query = $this->db->table($this->getTableName())
            ->where($this->getIDColumnName(), '=', $id);

        if ($this->softDeletes()) {
            $query = $query->whereNull('deleted_at');
        }
        $result = $query->first();
        
        return $result ? $this->mapEntity((array) $result) : null;
    }

    public function delete(DomainEntityInterface $domainEntity)
    {
        $query = $this->db->table($this->getTableName())
            ->where($this->getIDColumnName(), '=', $domainEntity->getID());
        if ($this->softDeletes()) {
            $deletedAt = new Carbon;
            $query = $query->update(['deleted_at' => $deletedAt->format($this->mysqlDateFormat)]);
        } else {
            $query = $query->delete();
        }
    }

    public function save(DomainEntityInterface $domainEntity) : DomainEntityInterface
    {
        return $domainEntity->getID() && $domainEntity->isDirty() ? $this->update($domainEntity) : $this->create($domainEntity);
    }

    public function findDeleted(int $id) : ? DomainEntityInterface
    {
        $query = $this->db->table($this->getTableName())
            ->where($this->getIDColumnName(), '=', $id);
        $result = $query->first();
        
        return $result ? $this->mapEntity((array) $result) : null;
    }
}
