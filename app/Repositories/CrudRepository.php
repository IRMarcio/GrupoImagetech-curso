<?php

namespace App\Repositories;

use App\Repositories\Contracts\Operations\CreateRecords as CreateRecordsContract;
use App\Repositories\Contracts\Operations\DeleteRecords as DeleteRecordsContract;
use App\Repositories\Contracts\Operations\ReadRecords as ReadRecordsContract;
use App\Repositories\Contracts\Operations\UpdateRecords as UpdateRecordsContract;
use App\Repositories\Contracts\Repository as RepositoryContract;
use App\Repositories\Operations\CreateRecords;
use App\Repositories\Operations\DeleteRecords;
use App\Repositories\Operations\FindRecords;
use App\Repositories\Operations\ReadRecords;
use App\Repositories\Operations\UpdateRecords;


/**
 * Class CrudRepository.
 */
abstract class CrudRepository extends Repository implements RepositoryContract,
    ReadRecordsContract,
    CreateRecordsContract,
    UpdateRecordsContract,
    DeleteRecordsContract
{

    use CreateRecords,
        ReadRecords,
        UpdateRecords,
        DeleteRecords,
        FindRecords;
}
