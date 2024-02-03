<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Repositories\Infrastructure\Mapper\Interfaces;


interface DomainEntityDatabaseMapperInterface extends QueryableDomainEntityMapperInterface
{
    public function getIDColumnName() : string;

    public function getTableName() : string;
}
