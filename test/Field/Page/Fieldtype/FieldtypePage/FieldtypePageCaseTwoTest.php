<?php

namespace ProcessWire\GraphQL\Test\Field\Page\Fieldtype;

/**
 * When template skyscraper, architect and field architect is
 * the architect page field should return list of architect pages.
 */

use \ProcessWire\GraphQL\Test\GraphQLTestCase;
use \ProcessWire\GraphQL\Test\Field\Page\Fieldtype\Traits\FieldtypeTestTrait;
use \ProcessWire\GraphQL\Test\Field\Page\Fieldtype\Traits\FieldAccessTrait;
use \ProcessWire\GraphQL\Utils;

class FieldtypePageCaseTwoTest extends GraphQLTestCase {

  const TEMPLATE_NAME = 'skyscraper';
  const FIELD_NAME = 'architects';
  const FIELD_TYPE = 'FieldtypePage';

  use FieldtypeTestTrait;

  public static function setUpBeforeClass()
  {
    parent::setUpBeforeClass();
    Utils::module()->legalTemplates = [self::TEMPLATE_NAME, 'architect'];
    Utils::module()->legalFields = [self::FIELD_NAME];
    Utils::session()->login('admin', Utils::config()->testUsers['admin']);
  }

  public static function tearDownAfterClass()
  {
    Utils::session()->logout();
    parent::tearDownAfterClass();
  }

  public function testValue()
  {
  	$skyscraper = Utils::pages()->get("template=skyscraper, architects.count>1");
  	$query = "{
  		skyscraper (s: \"id=$skyscraper->id\") {
  			list {
  				architects {
  					list {
  						id
  						name
  					}
  				}
  			}
  		}
  	}";
  	$res = $this->execute($query);
  	$this->assertEquals(
  		$skyscraper->architects->count,
  		count($res->data->skyscraper->list[0]->architects->list),
  		'Returns architect pages.'
  	);

    $this->assertEquals(
      $skyscraper->architects[0]->id,
      $res->data->skyscraper->list[0]->architects->list[0]->id,
      'Returns correct first architect page.'
    );

    $this->assertEquals(
      $skyscraper->architects[1]->id,
      $res->data->skyscraper->list[0]->architects->list[1]->id,
      'Returns correct second architect page.'
    );
  }

}