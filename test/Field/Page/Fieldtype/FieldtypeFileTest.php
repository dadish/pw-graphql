<?php

namespace ProcessWire\GraphQL\Test\Field\Page\Fieldtype;

use \ProcessWire\GraphQL\Test\GraphQLTestCase;
use \ProcessWire\GraphQL\Test\Field\Page\Fieldtype\FieldtypeTestTrait;
use \ProcessWire\GraphQL\Utils;

class FieldtypeFileTest extends GraphQLTestCase {

  const TEMPLATE_NAME = 'architect';
  const FIELD_NAME = 'resume';
  const FIELD_TYPE = 'FieldtypeFile';

  use FieldtypeTestTrait;

  public function testValue()
  {
  	$architect = Utils::pages()->get("template=architect, resume.count>0");
  	$query = "{
  		architect (s: \"id=$architect->id\") {
  			list {
  				resume {
  					url
  				}
  			}
  		}
  	}";
  	$res = $this->execute($query);
  	$this->assertEquals(
  		$architect->resume->first()->url,
  		$res->data->architect->list[0]->resume[0]->url,
  		'Retrieves files value.'
  	);
  }

}