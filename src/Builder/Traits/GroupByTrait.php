<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\GroupByClause;
use Packaged\QueryBuilder\Statement\IStatement;

trait GroupByTrait
{
  public function groupBy($fields)
  {
    /**
     * @var $this IStatement
     */

    $groupClause = new GroupByClause();
    if(func_num_args() > 1)
    {
      foreach(func_get_args() as $field)
      {
        $groupClause->addField($field);
      }
    }
    else if(is_array($fields))
    {
      foreach($fields as $field)
      {
        $groupClause->addField($field);
      }
    }
    else
    {
      $groupClause->addField($fields);
    }

    $this->addClause($groupClause);
    return $this;
  }
}
