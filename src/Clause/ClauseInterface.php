<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\Statement\StatementSegmentInterface;

interface ClauseInterface extends StatementSegmentInterface
{
  /**
   * @return string
   */
  public function getAction();
}
