# Pràctica 3 M07 (WEB SERVICE)

## Enunciat:

### Es tracta de crear un WS que retorni totes les activitats que hi ha a la BdD d'activitats del Projecte 1.

Ho farem amb dos pasos:

- Crida HTTP GET /GetToken per obtenir token de següent crida
- Crida HTTP GET /Activitats per obtenir activitats, cal passar token per capçalera JSON.

Per fer la 1a crida HTTP GET Token caldrà passar per la URL una API-KEY de 11 caràcters alfanumèrics igual a "Pràctica-WS" (ull amb l'accent) i ens generarà un token que contingui, com a mínim:

- 2 lletres majúscules
- 2 lletres minúscules
- 4 números
- i algun caràcter especial: \*?!#

Aquest Token serà el que enviarem a al crida HTTP GET Activitats i que la API validarà per a poder retornar el JSON d'activitats. si el format és vàlid, tornarà dades, en cas contrari. codi 403.

Totes les accions sobre la BdD caldrà que siguin mètodes a dins de la classe de l'arxiu bdd.php

Desenvolupar un petit HTML amb tres botons per a provar-ho.

- Un per obtenir token (de l'estil identificar-me)
- Un segon per obtenir les activitats, passant-li el token generat.
- Un tercer per cridar una funció més de la API WS, que li passem el Token generat en la crida /getToken. I a mena de força bruta que esbrini quants segons trigaria en descobrir-la. És a dir que generi combinacions de valors mínim fins a fer match. Més de 60 segons de processament ja la definiriem com a Molt robusta!

Cal enviar:

- Documentació inicial de la API
- Codi PHP // PHP Doc
- Exemple d'execució i proves

## Coses a tenir en compte a l'hora de voler provar l'exercici:

- Credencials accés base de dades

  - /API/BdD.php > `__constructor()`

- Importar la taula `ofertes` a la base de dades `ganga` (A l'arrel del projecte hi ha un arxiu `ofertes.sql`). Ja que el `connect` es fa a aquesta base de dades. Si tingués un altre nom, canvia el nom de la base de dades al `__construct`
