<?php

namespace ProcessWire\GraphQL\Field\Page\Fieldtype;

use Youshido\GraphQL\Type\Scalar\StringType;
use ProcessWire\GraphQL\Field\Page\Fieldtype\AbstractFieldtype;
use ProcessWire\GraphQL\Field\Traits\DatetimeResolverTrait;

class FieldtypeDatetime extends AbstractFieldtype {

  public function getDefaultType()
  {
    return new StringType();
  }

  use DatetimeResolverTrait;

}
