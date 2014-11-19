<?php
namespace Packaged\Tests\QueryBuilder\Assembler;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\IClause;
use Packaged\QueryBuilder\Clause\SelectClause;
use Packaged\QueryBuilder\Statement\IStatement;
use Packaged\QueryBuilder\Statement\QueryStatement;

class AssemblerTest extends \PHPUnit_Framework_TestCase
{
  /**
   * @expectedException \Exception
   * @expectedExceptionMessage You must construct the assembler with a statement
   */
  public function testAssemblerNoStatement()
  {
    $assembler = new QueryAssembler();
    $this->assertTrue($assembler->isForPrepare());
    $assembler->assemble();
  }

  public function testAssemblerPrepare()
  {
    $stm = new QueryStatement();
    $stm->addClause(new SelectClause())->from('mytable');
    $assembler = new QueryAssembler($stm, false);
    $this->assertFalse($assembler->isForPrepare());
    $this->assertEquals('SELECT * FROM mytable', (string)$assembler);
  }

  /**
   * @expectedException \Exception
   * @expectedExceptionMessage Unsupported segment type stdClass
   */
  public function testUnknownStatement()
  {
    $assembler = new QueryAssembler(new UnknownStatement());
    $assembler->assemble();
  }

  public function testParameters()
  {
    $assembler = new QueryAssembler();
    $assembler->addParameter('test', 'value');
    $assembler->addParameter('test2', 'value2');

    $result = ['test' => 'value', 'test2' => 'value2'];
    $this->assertEquals(array_values($result), $assembler->getParameters());
    $this->assertEquals($result, $assembler->getNamedParameters());
  }
}

class UnknownStatement implements IStatement
{
  public function addClause(IClause $clause)
  {
  }

  public function getClause($action)
  {
  }

  public function hasClause($action)
  {
  }

  public function removeClause($action)
  {
  }

  public function getSegments()
  {
    return [new \stdClass()];
  }
}