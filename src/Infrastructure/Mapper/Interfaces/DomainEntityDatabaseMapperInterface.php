<?php

namespace Fifthgate\Objectivity\Repositories\Infrastructure\Mapper\Interfaces;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;

use Fifthgate\Objectivity\Repositories\Infrastructure\Mapper\Interfaces\DomainEntityMapperInterface;

interface DomainEntityDatabaseMapperInterface extends DomainEntityMapperInterface
{
    public function getIDColumnName() : string;

    public function getTableName() : string;
}
