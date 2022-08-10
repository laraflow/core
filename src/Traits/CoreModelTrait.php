<?php


namespace Laraflow\Core\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * Trait CoreModelTrait
 * @package Laraflow\Core\Traits
 */
trait CoreModelTrait
{
    use AuditableTrait, HasFactory, SoftDeletes, Sortable, BlameableTrait;
}
