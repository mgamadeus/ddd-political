<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\DB\Locales;

use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineModel;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use DateTime;
use DDD\Domain\Common\Repo\DB\Languages\DBLanguageModel;
use DDD\Domain\Common\Repo\DB\PoliticalEntities\Countries\DBCountryModel;
use DDD\Domain\Base\Repo\DB\Database\DatabaseColumn;

#[ORM\Entity]
#[ORM\ChangeTrackingPolicy('DEFERRED_EXPLICIT')]
#[ORM\Table(name: 'Locales')]
class DBLocaleModel extends DoctrineModel
{
	public const string MODEL_ALIAS = 'Locale';

	public const string TABLE_NAME = 'Locales';

	public const string ENTITY_CLASS = 'App\Domain\Common\Entities\Locales\Locale';

	#[DatabaseColumn(isMergableJSONColumn: true)]
	#[ORM\Column(type: 'json')]
	public mixed $name;

	#[ORM\Column(type: 'string')]
	public ?string $languageCode;

	#[ORM\Column(type: 'integer')]
	public ?int $languageId;

	#[ORM\Column(type: 'integer')]
	public ?int $countryId;

	#[ORM\Column(type: 'string')]
	public ?string $countryShortCode;

	#[ORM\Column(type: 'boolean')]
	public ?bool $isDefaultLocaleForLanguage = false;

	#[ORM\Column(type: 'boolean')]
	public ?bool $isDefaultLocaleForCountry = false;

	#[ORM\Column(type: 'boolean')]
	public ?bool $isActive = true;

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	public int $id;

	#[ORM\ManyToOne(targetEntity: DBLanguageModel::class)]
	#[ORM\JoinColumn(name: 'languageId', referencedColumnName: 'id')]
	public ?DBLanguageModel $language;

	#[ORM\ManyToOne(targetEntity: DBCountryModel::class)]
	#[ORM\JoinColumn(name: 'countryId', referencedColumnName: 'id')]
	public ?DBCountryModel $country;

}