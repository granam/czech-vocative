#Credits
 - All credits belongs to the original author Petr Joachim.
 - This is just port to support PHP 5.4 (and to test it by Travis CI).
 
 ---

Vokativ
=======

* Oslovte své uživatele správně! *


Instalace
=========

    $ composer require granam/czech-vocative

Podporované verze PHP 5.4+

Použití
=======

```
<?php
use Vokativ\Name;
$name = new Name();
$name->vokativ('Petr');		// 'Petře'
$name->vokativ('Novák');	// 'Nováku'
$name->vokativ('Adriana');	// 'Adriano'
$name->vokativ('Fialová');	// 'Fialová'
```

Funkce **Vokativ($name, $isWoman = null, $isLastName = null)** bere jako první argument vlastní jméno v 1. pádu jednotného čísla a vrátí ho vyskloňované v 5. pádu.
Upozorňujeme, že funkce nemusí fungovat správně pro jména cizího původu.

### Další volitelné argumenty jsou:

#### $isWoman

Použijte *true*, pokud si přejete zadané jméno skloňovat jako ženské.

Použijte *false*, pokud si přejete zadané jméno skloňovat jako mužské.

Ve výchozím případě *null* je pohlaví detekováno automaticky.

```
<?php
$name->vokativ('Michel');  			// 'Micheli' - automaticky jako mužské
$name->vokativ('Michel', false);	// 'Micheli'
$name->vokativ('Michel', true);		// 'Michel'
```

#### $isLastName

Použijte *true*, pokud si přejete zadané jméno skloňovat jako příjmení.

Použijte *false*, pokud si přejete zadané jméno skloňovat jako křestní jméno.

Ve výchozím případě *null* je typ jména detekován automaticky.

Hodnota tohoto parametru ovlivňuje pouze skloňování ženských jmen.

```
<?php
$name->vokativ('Ivanova'); 				// 'Ivanova' - automaticky příjmení
$name->vokativ('Ivanova', true, true);	// 'Ivanova'
$name->vokativ('Ivanova', true, false);	// 'Ivanovo'
```

Automatická detekce pohlaví
===========================

Knihovna **vokativ** poskytuje taky jednoduchou funkci na detekci pohlaví podle křestního jména či příjmení.
Pro četnosti jmen v ČR podle [statistického úřadu](http://www.mvcr.cz/clanek/cetnost-jmen-a-prijmeni-722752.aspx)
funkce funguje správně v 99.7% případů.

```
<?php
$name->isMale('Michal'); 	// true
$name->isMale('Novák'); 	// true
$name->isMale('Tereza'); 	// false
$name->isMale('Nováková'); 	// false
```

Kudos
=====

Tato knihovna vznikla jako reimplementace původní implementace Python knihovny Vokativ autora Michala Daniláka <https://github.com/Mimino666/vokativ/>.