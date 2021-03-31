<?php
namespace Packaged\QueryBuilder\Assembler\Segments;

use Packaged\Helpers\Objects;
use Packaged\Helpers\Strings;
use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Statement\IStatementSegment;

abstract class AbstractSegmentAssembler
{
  /**
   * @var QueryAssembler
   */
  protected $_assembler;
  /**
   * @var IStatementSegment
   */
  protected $_segment;

  /**
   * @param QueryAssembler $assembler
   */
  public function setAssembler(QueryAssembler $assembler)
  {
    $this->_assembler = $assembler;
  }

  /**
   * @return QueryAssembler
   */
  public function getAssembler()
  {
    return $this->_assembler;
  }

  /**
   * @param $segments
   *
   * @return string[]
   */
  public function assembleSegments($segments)
  {
    return $this->getAssembler()->assembleSegments($segments);
  }

  /**
   * @param $segment
   *
   * @return string
   * @throws \Exception
   */
  public function assembleSegment($segment)
  {
    return $this->getAssembler()->assembleSegment($segment);
  }

  protected function _assemblePrepared($expr = null)
  {
    if(!$this->getAssembler()->isForPrepare())
    {
      return false;
    }

    $this->getAssembler()->addParameter($expr !== null ? $expr : $this->_segment);
    return '?';
  }

  /**
   * Assemble the segment
   *
   * @return string
   */
  public function assemble()
  {
    throw new \RuntimeException(
      "Unsupported segment '" . get_class($this->_segment) . "' passed to the " .
      ucwords(Strings::humanize(Objects::classShortname(get_called_class())))
    );
  }

  public function escapeField($field)
  {
    return $this->getAssembler()->escapeField($field);
  }

  public function escapeValue($value)
  {
    return !is_string($value) && is_numeric($value) ? $value : $this->getAssembler()->escapeValue($value);
  }
}
