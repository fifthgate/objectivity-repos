<?php

namespace Fifthgate\Objectivity\Repositories\Infrastructure\Repository;

use Fifthgate\Objectivity\Repositories\Infrastructure\Repository\Interfaces\CacheingDomainEntityRepositoryInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;
use Illuminate\Support\Facades\Cache;

abstract class AbstractCacheingDomainEntityRepository extends AbstractDomainEntityRepository implements CacheingDomainEntityRepositoryInterface
{

    protected const ITEM_TYPE = '';

    protected $mapper;

    /**
     * @param integer $id
     * @return string
     */
    final protected function getIndividualCacheKey(int $id): string {
        return sprintf("%s_%s", $this::ITEM_TYPE, $id);
    }

    final protected function getCollectionCacheKey(array $ids): string {
        return sprintf(
            "%s_COLLECTION_[%s]",
            $this::ITEM_TYPE,
            implode($ids, ",")
        );
    }

    /**
     * @param integer $id
     * @param boolean $fresh
     * @return DomainEntityInterface|null
     */
    public function find(int $id, bool $fresh = false) : ? DomainEntityInterface
    {
        $entity = Cache::get($this->getIndividualCacheKey($id));
        if (!$entity or $fresh = true) {
            $item  = $this->mapper->find($id);
            if ($item) {
                Cache::put($this->getIndividualCacheKey($id), $item);
            }
            return $item;
        }
        return null;
    }
    
    public function findAll(bool $includeUnpublished = false, bool $fresh = false) : ? DomainEntityCollectionInterface
    {
        return $this->mapper->findAll($includeUnpublished);
    }

    public function findMany(array $ids, bool $fresh = false) : ? DomainEntityCollectionInterface
    {
        if (!$fresh) {
            $collection = Cache::get($this->getCollectionCacheKey($ids));
            if ($collection) {
                return $collection;
            }
        }
        
        
        $collection = $this->mapper->findMany($ids);
        if ($collection) {
            Cache::set($this->getCollectionCacheKey($ids), $collection);
        }
        return $collection;
        
    }

}
