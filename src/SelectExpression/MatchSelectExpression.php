<?php
namespace Packaged\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Expression\MatchExpression;
use Packaged\QueryBuilder\SelectExpression\Traits\AliasTrait;

class MatchSelectExpression extends MatchExpression implements ISelectExpression
{
  use AliasTrait;
}
