Vokativ
=======

#### Oslovte své uživatele správně!


Instalace
=========

    $ composer require bigit/vokativ

Podporované verze PHP 5.6+

Použití
=======

```
<?php
php > use Vokativ\Vokativ;
php > echo Vokativ::vokativ('Petr');
petře
php > echo Vokativ::vokativ('Novák');
nováku
php > echo Vokativ::vokativ('Adriana');
adriano
php > echo Vokativ::vokativ('Fialová');
fialová
```

Funkce **Vokativ($name, $isWoman = null, $isLastName = null)** bere jako první argument vlastní jméno v 1. pádu jednotného čísla a vrátí ho vyskloňované v 5. pádu.
Návratová hodnota funkce je vždy řetězec s malými písmeny typu *string*.
Upozorňujeme, že funkce nemusí fungovat správně pro jména cizího původu.

### Další volitelné argumenty jsou:

#### $isWoman

Použijte *true*, pokud si přejete zadané jméno skloňovat jako ženské.

Použijte *false*, pokud si přejete zadané jméno skloňovat jako mužské.

Ve výchozím případě *null* je pohlaví detekováno automaticky.

```
<?php
php > echo Vokativ::vokativ('Michel');  // automaticky skloňuje jako mužské jméno
micheli
php > echo Vokativ::vokativ('Michel', false);
micheli
php > echo Vokativ::vokativ('Michel', true);
michel
```

#### $isLastName

Použijte *true*, pokud si přejete zadané jméno skloňovat jako příjmení.

Použijte *false*, pokud si přejete zadané jméno skloňovat jako křestní jméno.

Ve výchozím případě *null* je typ jména detekován automaticky.

Hodnota tohoto parametru ovlivňuje pouze skloňování ženských jmen.

```
<?php
>>> echo Vokativ::vokativ('Ivanova');  // automaticky skloňuje jako příjmení
ivanova
>>> echo Vokativ::vokativ('Ivanova', true, true);
ivanova
>>> echo Vokativ::vokativ('Ivanova', true, false);
ivanovo
```

Automatická detekce pohlaví
===========================

Knihovna **vokativ** poskytuje taky jednoduchou funkci na detekci pohlaví podle křestního jména či příjmení.
Pro četnosti jmen v ČR podle [statistického úřadu](http://www.mvcr.cz/clanek/cetnost-jmen-a-prijmeni-722752.aspx)
funkce funguje správně v 99.7% případů.

```
php > use Vokativ\Vokativ;
php > echo Vokativ::isMale('Michal');
true
php > echo Vokativ::isMale('Novák');
true
php > echo Vokativ::isMale('Tereza');
false
php > echo Vokativ::isMale('Nováková');
false
```

Kudos
=====

Tato knihovna vznikla jako reimplementace původní implementace Python knihovny Vokativ autora Michala Daniláka <https://github.com/Mimino666/vokativ/>.