<?php
namespace Packaged\QueryBuilder\Statement;

class QueryStatement extends AbstractStatement
{
  protected function _getOrder()
  {
    return ['SELECT', 'FROM', 'WHERE', 'GROUPBY', 'HAVING', 'ORDERBY', 'LIMIT'];
  }
}
