<?php namespace ProcessWire\GraphQL\Test\Permissions\Superuser\Create\NotAvailable;

use ProcessWire\GraphQL\Test\GraphqlTestCase;
use ProcessWire\GraphQL\Utils;

class ParentTemplateChildTemplatesTest extends GraphqlTestCase
{
  /**
   * + For superuser.
   * + The template is legal.
   * + All the required fields are legal.
   * + The configured parent template is legal.
   * - But the configured parent template has childTemplates without target template id.
   */
  public static function getSettings()
  {
    $architectTemplate = Utils::templates()->get("architect");
    return [
      "login" => "admin",
      "legalTemplates" => ["city", "skyscraper"],
      "legalFields" => ["title"],
      "access" => [
        "templates" => [
          [
            "name" => "city",
            "childTemplates" => [$architectTemplate->id],
          ],
        ],
      ],
    ];
  }

  public function testPermission()
  {
    assertTypePathNotExists(
      ["Mutation", "createSkyscraper"],
      "Create field should not be available if configured parent template has childTemplates that does not match target template."
    );
  }
}
