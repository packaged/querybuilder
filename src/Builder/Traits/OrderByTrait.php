<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\OrderByClause;
use Packaged\QueryBuilder\Statement\IStatement;

trait OrderByTrait
{
  public function orderBy($fields)
  {
    /**
     * @var $this IStatement
     */

    $orderClause = new OrderByClause();
    if(is_array($fields))
    {
      foreach($fields as $field => $order)
      {
        if(contains_any($order, ['asc', 'desc'], false))
        {
          $orderClause->addField($field, $order);
        }
        else
        {
          $orderClause->addField($order);
        }
      }
    }
    else if(func_num_args() > 1)
    {
      foreach(func_get_args() as $field)
      {
        $orderClause->addField($field);
      }
    }
    else
    {
      $orderClause->addField($fields);
    }

    $this->addClause($orderClause);
    return $this;
  }
}
