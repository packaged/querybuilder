<?php
namespace Packaged\QueryBuilder\Assembler\Segments;

use Packaged\QueryBuilder\Statement\IStatement;

class StatementAssembler extends AbstractSegmentAssembler
{
  public function __construct(IStatement $statement)
  {
    $this->_segment = $statement;
  }

  /**
   * Assemble the segment
   *
   * @return string
   */
  public function assemble()
  {
    $parts = [];
    foreach($this->_segment->getSegments() as $name => $segment)
    {
      if(is_array($segment))
      {
        $parts[] = implode(
          $name === 'VALUES' ? ', ' : ' ',
          array_map([$this->getAssembler(), 'assembleSegment'], $segment)
        );
      }
      else
      {
        $parts[] = $this->getAssembler()->assembleSegment($segment);
      }
    }
    return implode(' ', array_filter($parts));
  }
}
