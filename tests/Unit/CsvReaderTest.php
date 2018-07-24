<?php

namespace LeagueTest\Csv;

use BadMethodCallException;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\Statement;
use PHPUnit\Framework\TestCase;
use SplFileObject;
use SplTempFileObject;
use TypeError;

class CsvReaderTest extends TestCase {

    /**
     * A basic test example.
     *
     * @return void
     */
    private $csv;
    private $expected = [
        ['08/05/2018','17/05/2018','Amy','Mccormick','insurance@doyouinsurance.com','34964830995','c\Ronda Mijares n190 Bis','','Castellon','UK','12002','DYSIH_NL_PLATINUM_8-14','53.12','usd','01/05/2018'],
        ['08/05/2018','17/05/2018','Amy','Mccormick','insurance@doyouinsurance.com','34964830995','c\Ronda Mijares n190 Bis','','Castellon','UK','12002','DYSIH_NL_PLATINUM_8-14','53.12','usd','01/05/2018'],
    ];
    
   public function setUp()
   {
       $tmp = new SplTempFileObject();
       foreach ($this->expected as $row) {
           $tmp->fputcsv($row);
       }
       $this->csv = Reader::createFromFileObject($tmp);
       $this->stmt = new Statement();
   }
   
   public function tearDown()
   {
       $this->csv = null;
       $this->stmt = null;
   }

   
   /**
    * @covers ::getHeader
    */
   public function testGetHeader()
   {
       $expected = ['start_date','end_date','first_name','last_name','email','telnumber','address1','Address2','city','country','postcode','product_name','cost','currency','transaction_date'];
       $this->assertSame([], $this->stmt->process($this->csv)->getHeader());
       $this->assertSame($expected, $this->stmt->process($this->csv, $expected)->getHeader());
       $this->csv->setHeaderOffset(0);
       $this->assertSame($this->expected[0], $this->stmt->process($this->csv)->getHeader());
       $this->assertSame($expected, $this->stmt->process($this->csv, $expected)->getHeader());
   }
   
   /**
    * @covers ::getRecords
    * @covers ::getIterator
    */
   public function testGetRecords()
   {
       $result = $this->stmt->process($this->csv);
       $this->assertEquals($result->getIterator(), $result->getRecords());
   }
   
    /**
     * @covers ::jsonSerialize
     */
    public function testJsonSerialize()
    {
        $expected = [
            ['start_date','end_date','first_name','last_name','email','telnumber','address1','Address2','city','country','postcode','product_name','cost','currency','transaction_date'],
            ["08/05/2018","17/05/2018", "Amy", "Mccormick", "insurance@doyouinsurance.com","34964830995","c\Ronda Mijares 190 Bis","","Castellon", "UK", "12002", "DYSIH_NL_PLATINUM_8-14","53.12","usd","01/05/2018"],
            ["08/05/2018","17/05/2018", "Amy1", "Mccormicks", "insurance@doyouinsurance.com","34964830995","c\Ronda Mijares 190 Bis","","Castellon", "UK", "12002", "DYSIH_NL_PLATINUM_8-14","53.12","usd","01/05/2018"],
        ];
        $tmp = new SplTempFileObject();
        //dd($this->expected);
        foreach ($expected as $row) {
            $tmp->fputcsv($row);
        }
        
        $reader = Reader::createFromFileObject($tmp)->setHeaderOffset(0);
        //Case 1: offset 0 is success test case
        //Case 2: offset 1 is failure test case
        $result = (new Statement())->offset(0)->limit(1)->process($reader);
        
        $resultJson = '[{"start_date":"08/05/2018","end_date":"17/05/2018","first_name":"Amy","last_name":"Mccormick","email":"insurance@doyouinsurance.com","telnumber":"34964830995","address1":"c\Ronda Mijares 190 Bis","Address2":"","city":"Castellon","country":"UK","postcode":"12002","product_name":"DYSIH_NL_PLATINUM_8-14","cost":"53.12","currency":"usd","transaction_date":"01/05/2018"}]';
        
        $this->assertSame($resultJson, stripslashes(json_encode($result)));
    }

}
