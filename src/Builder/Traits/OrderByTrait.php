<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\OrderByClause;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Statement\StatementInterface;

trait OrderByTrait
{
  public function orderBy($fields)
  {
    /**
     * @var $this StatementInterface
     */

    $orderClause = new OrderByClause();
    if(is_array($fields))
    {
      foreach($fields as $field => $order)
      {
        if(contains_any($order, ['asc', 'desc'], false))
        {
          $orderClause->addField(FieldExpression::create($field), $order);
        }
        else if(is_scalar($field))
        {
          $orderClause->addField(FieldExpression::create($order));
        }
        else
        {
          $orderClause->addField(FieldExpression::create($field));
        }
      }
    }
    else if(is_scalar($fields))
    {
      $orderClause->addField(FieldExpression::create($fields));
    }

    $this->addClause($orderClause);
    return $this;
  }
}
