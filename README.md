[![Build Status](https://travis-ci.org/jaroslavtyc/granam-czech-vocative.svg?branch=master)](https://travis-ci.org/jaroslavtyc/granam-czech-vocative)
[![Test Coverage](https://codeclimate.com/github/jaroslavtyc/granam-czech-vocative/badges/coverage.svg)](https://codeclimate.com/github/jaroslavtyc/granam-czech-vocative/coverage)
[![License](https://poser.pugx.org/granam/czech-vocative/license)](https://packagist.org/packages/granam/czech-vocative)


## Credits
 - All credits belongs to the original [bigit/vokativ](https://bitbucket.org/bigit/vokativ.git) library author Petr Joachim.
 - This is just port to support PHP 5.4+ (and to test it by [Travis CI](https://travis-ci.com/)).
 
 ---

# Vokativ

*Oslovte své uživatele správně!*


## Instalace

```bash
composer require granam/czech-vocative
```

Podporované verze PHP 5.4+

## Použití

```php
<?php
use Granam\CzechVocative\CzechName;
$name = new CzechName();
$name->vocative('Petr'); // 'Petře'
$name->vocative('Novák'); // 'Nováku'
$name->vocative('Adriana');	// 'Adriano'
$name->vocative('Fialová');	// 'Fialová'
```

Funkce `vocative($name, $isWoman = null, $isLastName = null)` bere jako první argument vlastní jméno v 1. pádu jednotného čísla a vrátí ho vyskloňované v 5. pádu.
Upozorňujeme, že funkce nemusí fungovat správně pro jména cizího původu.

### Další volitelné argumenty jsou:

`$isWoman`

Použijte `true`, pokud si přejete zadané jméno skloňovat jako ženské.

Použijte `false`, pokud si přejete zadané jméno skloňovat jako mužské.

Ve výchozím případě `null` je pohlaví detekováno automaticky.

```php
<?php
use Granam\CzechVocative\CzechName;

$name = new CzechName();
$name->vocative('Michel'); // 'Micheli' - automaticky jako mužské
$name->vocative('Michel', false); // 'Micheli - výslovně mužské'
$name->vocative('Michel', true); // 'Michel - výslovně ženské'
```

`$isLastName`

Použijte `true`, pokud si přejete zadané jméno skloňovat jako příjmení.

Použijte `false`, pokud si přejete zadané jméno skloňovat jako křestní jméno.

Ve výchozím případě `null` je typ jména detekován automaticky.

Hodnota tohoto parametru ovlivňuje pouze skloňování ženských jmen.

```php
<?php
use Granam\CzechVocative\CzechName;

$name = new CzechName();
$name->vocative('Ivanova'); // 'Ivanova' - automaticky příjmení
$name->vocative('Ivanova', true, true); // 'Ivanova'
$name->vocative('Ivanova', true, false); // 'Ivanovo'
```

## Automatická detekce pohlaví

Knihovna **vokativ** poskytuje také jednoduchou funkci na detekci pohlaví podle křestního jména či příjmení.
Pro četnosti jmen v ČR podle [statistického úřadu](http://www.mvcr.cz/clanek/cetnost-jmen-a-prijmeni-722752.aspx)
funkce funguje správně v 99.7% případů.

```php
<?php
use Granam\CzechVocative\CzechName;

$name = new CzechName();
$name->isMale('Michal'); // true
$name->isMale('Novák'); // true
$name->isMale('Tereza'); // false
$name->isMale('Nováková'); // false
```

## Kudos

Tato knihovna vznikla jako reimplementace původní implementace Python knihovny Vokativ autora Michala Daniláka <https://github.com/Mimino666/vokativ/>.
