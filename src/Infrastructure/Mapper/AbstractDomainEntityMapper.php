<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Repositories\Infrastructure\Mapper;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;
use Fifthgate\Objectivity\Repositories\Infrastructure\Mapper\Interfaces\DomainEntityDatabaseMapperInterface;
use Carbon\Carbon;
use Illuminate\Database\DatabaseManager as DB;

/**
 * This class provides base functionality for almost all objectivity-compatible mappers.
 */
abstract class AbstractDomainEntityMapper implements DomainEntityDatabaseMapperInterface
{
    //The MySQL Date format
    protected string $mysqlDateFormat = 'Y-m-d H:i:s';

    //The name of the table. Will be different for every mapper.
    protected string $tableName;

    //Does the domain entity the inheriting mapper manages use publication dates?
    protected bool $publishes = false;

    //Does the entity this mapper manages softdelete?
    protected bool $softDeletes = true;

    //Does the entity this mapper manages use slugs?
    protected bool $usesSlugs = false;

    //What's the name of the ID key on the primary table for the entity this mapper manages?
    protected $idColumnName = 'id';

    //This is where the database connection will be injected
    protected $db;

    //@codeCoverageIgnoreStart
    public function __construct(DB $db)
    {
        $this->db = $db;
    }
    //@codeCoverageIgnoreEnd

    //Make a DomainEntityCollectionInterface Compatible collection in which the mapper can store result sets.
    abstract public function makeCollection(): DomainEntityCollectionInterface;

    //Update an entity's record from a fully-hydrated object
    abstract protected function update(DomainEntityInterface $domainEntity): DomainEntityInterface;

    //Create a new record from a fully hydrated domain object.
    abstract protected function create(DomainEntityInterface $domainEntity): DomainEntityInterface;


    /**
     * Does this mapper use slugs?
     *
     * @return bool
     */
    public function usesSlugs(): bool
    {
        return $this->usesSlugs;
    }

    /**
     * Does this mapper softdelete?
     *
     * @return bool
     */
    public function softDeletes(): bool
    {
        return $this->softDeletes;
    }

    /**
     * Does this mapper publish content?
     *
     * @return bool
     */
    public function publishes(): bool
    {
        return $this->publishes;
    }

    /**
     * What is the name of primary key?
     *
     * @return string The column name of the primary key.
     */
    public function getIDColumnName(): string
    {
        return $this->idColumnName;
    }

    /**
     * What primary table are we managing?
     *
     * @return string the Table's name, as the DB knows it.
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * Find all active entries.
     *
     * @param bool $includUnpublished If this mapper use publication functionality, should unpublished items be included. This parameter is ignored if this mapper doesn't use this functionality.
     *
     * @return DomainEntitycollectionInterface|null, a hydrated collection of Domain entites, or null if none found.
     */
    public function findAll(bool $includeUnpublished = false): ?DomainEntityCollectionInterface
    {
        $query = $this->db->table($this->getTableName());
        if ($this->softDeletes()) {
            $query = $query->whereNull('deleted_at');
        }
        //@codeCoverageIgnoreStart
        if (!$includeUnpublished && $this->publishes()) {
            $now = new Carbon();
            $query = $query->whereDate('publication_date', '<=', $now->format('Y-m-d H:i:s'));
        }
        //@codeCoverageIgnoreEnd
        $results = $query->get()->toArray();

        return $results ? $this->mapMany($results) : null;
    }

    /**
     * Find many items from an array of ids.
     *
     * @param array $ids, a flat array of entity ids. E.G [12,35,9]
     *
     * @return DomainEntitycollectionInterface|null A collection of hydrated domain objects or null, if not found.
     */
    public function findMany(array $ids): ?DomainEntityCollectionInterface
    {
        $query = $this->db->table($this->getTableName())->whereIn($this->getIDColumnName(), $ids);

        if ($this->softDeletes()) {
            $query = $query->whereNull('deleted_at');
        }

        $results = $query ->get()->toArray();
        return $results ? $this->mapMany($results) : null;
    }

    /**
     * Map many database results into a collection of fully-hydrated objects.
     *
     * @param array $results An array of results, as captured from the database.
     *
     * @return DomainEntityCollectionInterface A collection of fully-hydrated objects.
     */
    public function mapMany(array $results): DomainEntityCollectionInterface
    {
        $collection = $this->makeCollection();
        foreach ($results as $result) {
            $collection->add($this->mapEntity((array) $result));
        }
        return $collection;
    }

    /**
     * Find a single Domain entity based on a simple column => value query.
     *
     * @param $queryArray an array of values to check with the format $column => $value. EG [, "title" => "Something or other"]
     *
     * @return DomainEntityInterface|null A fully-hydrated domain object, or null if the query returned no results.
     */
    public function queryOne(array $queryArray): ?DomainEntityInterface
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

    /**
     * Find every domain entity result for a simple column => value query
     *
     * @param $queryArray an array of values to check with the format $column => $value. EG [, "title" => "Something or other"]
     *
     * @return DomainEntityCollectionInterface|null A collection of fully-hydrated domain objects, or null if the query returned no results.
     */
    public function queryMany(array $queryArray): ?DomainEntityCollectionInterface
    {
        $query = $this->db->table($this->getTableName());
        foreach ($queryArray as $col => $value) {
            $query = $query->where($col, '=', $value);
        }
        if ($this->softDeletes()) {
            $query = $query->whereNull('deleted_at');
        }
        $results = $query->get()->toArray();
        return $results ? $this->mapMany($results) : null;
    }

    /**
     * Find every domain entity for a simple column => value query, along with a list of parameters to exclude.
     * @param  array  $includeParameters an array of values to include with the format $column => $value. EG [, "title" => "Something or other"]
     * @param  array  $excludeParameters an array of values to *exclude* with the format $column => $value. EG [, "title" => "Something or other"]
     *
     * @return DomainEntityCollectionInterface|null A collection of fully-hydrated domain objects, or null if the query returned no results.
     */
    public function queryExcluding(array $includeParameters, array $excludeParameters): ?DomainEntityCollectionInterface
    {
        $query = $this->db->table($this->getTableName());

        if (!empty($includeParameters)) {
            foreach ($includeParameters as $col => $value) {
                $query = $query->where($col, '=', $value);
            }
        }

        if (!empty($excludeParameters)) {
            foreach ($excludeParameters as $col => $value) {
                $query = $query->where($col, '!=', $value);
            }
        }

        if ($this->softDeletes()) {
            $query = $query->whereNull('deleted_at');
        }
        $results = $query->get()->toArray();
        return $results ? $this->mapMany($results) : null;
    }

    /**
     * Find a single entity from its primary key
     *
     * @param mixed $id The Primary key value.
     *
     * @return DomainEntityInterface|null A fully-hydrated DomainEntityINterface or null if not found.
     */
    public function find($id): ?DomainEntityInterface
    {
        $query = $this->db->table($this->getTableName())
            ->where($this->getIDColumnName(), '=', $id);

        if ($this->softDeletes()) {
            $query = $query->whereNull('deleted_at');
        }
        $result = $query->first();

        return $result ? $this->mapEntity((array) $result) : null;
    }

    /**
     * Delete a domain entity
     *
     * @param DomainEntityInterface The domain entity to be deleted.
     *
     * @return void
     */
    public function delete(DomainEntityInterface $domainEntity)
    {
        $query = $this->db->table($this->getTableName())
            ->where($this->getIDColumnName(), '=', $domainEntity->getID());
        if ($this->softDeletes()) {
            $deletedAt = new Carbon();
            $query = $query->update(['deleted_at' => $deletedAt->format($this->mysqlDateFormat)]);
        } else {
            //@codeCoverageIgnoreStart
            $query = $query->delete();
            //@codeCoverageIgnoreEnd
        }
    }

    /**
     * Save a domain entity.
     *
     * @param DomainEntityInterface the Entity to be saved.
     *
     * @return DomainEntityInterface The saved domain entity, populated with any extra properties its save produced, such as an ID, a creation date or an updated date.
     */
    public function save(DomainEntityInterface $domainEntity): DomainEntityInterface
    {
        if ($domainEntity->getID()) {
            return $domainEntity->isDirty() ? $this->update($domainEntity) : $domainEntity;
        } else {
            return $this->create($domainEntity);
        }
    }

    /**
     * Find a softdeleted entity by id.
     *
     * @param mixed $id The ID of the seleted entity.
     *
     * @return DomainEntityInterface|null A fully-hydrated domain entity, or null if not found. If this mapper doesn't use softdeletion, the result will ALWAYS be null.
     */
    public function findDeleted($id): ?DomainEntityInterface
    {
        //@codeCoverageIgnoreStart
        if (!$this->softDeletes()) {
            return null;
        }
        //@codeCoverageIgnoreEnd
        $query = $this->db->table($this->getTableName())
            ->where($this->getIDColumnName(), '=', $id);
        $result = $query->first();

        return $result ? $this->mapEntity((array) $result) : null;
    }

    /**
     * Save an entire collection of domain entity items.
     *
     * @param DomainEntityCollectionInterface The collection to be saved.
     *
     * @return DomainEntityCollectionInterface The saved collection, the constituents of which will have been updated with any metadata altered by the act of saving them, such as IDs and update dates.
     */
    public function saveCollection(DomainEntityCollectionInterface $collection): DomainEntityCollectionInterface
    {
        $savedCollection = $this->makeCollection();
        foreach ($collection as $item) {
            $savedCollection->add($this->save($item));
        }
        return $savedCollection;
    }
}
