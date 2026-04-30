<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\DB\Languages;

use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineModel;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use DateTime;
use DDD\Domain\Base\Repo\DB\Database\DatabaseColumn;

#[ORM\Entity]
#[ORM\ChangeTrackingPolicy('DEFERRED_EXPLICIT')]
#[ORM\Table(name: 'Languages')]
class DBLanguageModel extends DoctrineModel
{
	public const string MODEL_ALIAS = 'Language';

	public const string TABLE_NAME = 'Languages';

	public const string ENTITY_CLASS = 'DDD\Domain\Common\Entities\Languages\Language';

	public static array $virtualColumns = ['virtualNameSearch' => [ 'createIndex' => false, 'stored' => true, 'as' => '( CASE WHEN name IS NULL OR JSON_VALID(name) = 0 THEN \'\' ELSE REGEXP_REPLACE( TRIM( BOTH \' \' FROM REGEXP_REPLACE( REGEXP_REPLACE(JSON_UNQUOTE(name), \'^\\\\{\\\\s*|\\\\s*\\\\}\\\\s*$\', \'\'), \'"[^"]+"\\\\s*:\\\\s*"([^"]*)"\\\\s*(,\\\\s*)?\', \'\\\\1 | \' ) ), \'\\\\s*\\\\|\\\\s*$\', \'\' ) END )', 'referenceColumn' => 'nameSearch', 'referenceColumnStored' => true, ]];

	#[ORM\Column(type: 'string')]
	public ?string $languageCode;

	#[ORM\Column(type: 'string')]
	public ?string $iso3Code;

	#[DatabaseColumn(isMergableJSONColumn: true)]
	#[ORM\Column(type: 'json')]
	public mixed $name;

	#[ORM\Column(type: 'string')]
	public ?string $nativeName;

	#[ORM\Column(type: 'string')]
	public ?string $textDirection = 'LTR';

	#[ORM\Column(type: 'string')]
	public ?string $scriptCode;

	#[ORM\Column(type: 'boolean')]
	public ?bool $isActive = true;

	#[ORM\Column(type: 'integer')]
	public ?int $displayOrder;

	#[ORM\Column(type: 'string')]
	public ?string $supportedWritingStyles = 'INFORMAL';

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	public int $id;

	#[ORM\Column(type: 'string')]
	public string $virtualNameSearch;

}