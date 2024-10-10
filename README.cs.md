# php-vitexsoftware-abraflexi-bricks
![Project Logo](social-preview.svg?raw=true "Project Logo")

[![Build Status](https://travis-ci.org/VitexSoftware/php-abraflexi-bricks.svg?branch=main)](https://travis-ci.org/VitexSoftware/php-abraflexi-bricks)
[![GitHub stars](https://img.shields.io/github/stars/VitexSoftware/php-abraflexi-bricks.svg)](stargazers)
[![GitHub issues](https://img.shields.io/github/issues/VitexSoftware/php-abraflexi-bricks.svg)](issues)
[![GitHub license](https://img.shields.io/github/license/VitexSoftware/php-abraflexi-bricks.svg)](LICENSE?raw=true)
[![Twitter](https://img.shields.io/twitter/url/https/github.com/VitexSoftware/php-abraflexi-bricks.svg?style=social)](https://twitter.com/intent/tweet?text=Wow:&url=https%3A%2F%2Fgithub.com%2FVitexSoftware%2Fphp-abraflexi-bricks)

Examples how to use [php-abraflexi](https://github.com/Spoje-NET/php-abraflexi) Library for AbraFlexi with EasePHP Framework widgets

Příklady použití knihovny [php-abraflexi](https://github.com/Spoje-NET/php-abraflexi) pro [AbraFlexi](https://flexibee.eu/)


Instalace
----------

    composer require vitexsoftware/abraflexi-bricks


How to run ?
------------

1) composer install
2) cd src
3) modify config.php to use custom AbraFlexi connection
4) open the project url in browser


### Co tady máme ?

Zatím několik málo praktických ukázek určený k použití ve vašich aplikacích - odtud název bricks/cihličky

# Třídy v php-abraflexi/Bricks/:

| Soubor                                                          | Popis                                 |
| --------------------------------------------------------------- | --------------------------------------|
| [Convertor.php](src/php-abraflexi/Bricks/Convertor.php)          | Konvertor dokladů
| [Customer.php](src/php-abraflexi/Bricks/Customer.php)            | Zákazník
| [GdprLog.php](src/php-abraflexi/Bricks/GdprLog.php)              | GDPR Logger s podporou pro AbraFlexi
| [GateKeeper.php](src/php-abraflexi/Bricks/GateKeeper.php)        | Kontroluje zdali je shodná firma uživatele a dokladu
| [PotvrzeniUhrady.php](src/php-abraflexi/Bricks/HookReciever.php) | Třída potvrzující došlou úhradu
| [ParovacFaktur.php](src/php-abraflexi/Bricks/ParovacFaktur.php)  | Párovač faktur

# Třídy v php-abraflexi/Bricks/ui:

| Soubor                                                        | Popis                                 |
| ------------------------------------------------------------- | --------------------------------------|
| [CompanyLogo.php](src/php-abraflexi/Bricks/ui/CompanyLogo.php)   | Logo Firmy
| [DocumentLink.php](src/php-abraflexi/Bricks/ui/DocumentLink.php) | Odkaz na dokument ve webovém rozhraní AbraFlexi
| [AbraFlexiLogo.php](src/php-abraflexi/Bricks/ui/AbraFlexiLogo.php) | Logo AbraFlexi
| [EmbedResponsiveHTML.php](src/php-abraflexi/Bricks/ui/EmbedResponsiveHTML.php)| Třída pro zobrazení HTML dokumentu na stránce 
| [EmbedResponsivePDF.php](src/php-abraflexi/Bricks/ui/EmbedResponsivePDF.php)  | Třída pro zobrazení PDF dokumentu na stránce 
| [RecordTypeSelect.php](src/php-abraflexi/Bricks/ui/RecordTypeSelect.php)      | Nabídka pro výběr typu dokumnetu 
| [RecordChooser.php](src/php-abraflexi/Bricks/ui/RecordChooser.php)            | Nabídka pro výběr záznamu zaleožený na [Selectize.js](https://selectize.github.io/selectize.js/)


Ukázky ve složce [Examples](Examples)
=====================================

Logo Firmy: [companylogo.php](Examples/companylogo.php)

![Logo](Examples/companylogo.png?raw=true)

Editor Adresy: [addresseditor.php](Examples/addresseditor.php)

![Výpis](Examples/addresseditor.png?raw=true)

Výpis faktur do stránky: [invoices.php](Examples/invoices.php)

![Výpis](Examples/invoices.png?raw=true)

Vložení PDF do stránky: [embed.php](Examples/embed.php)

![Vložení](Examples/embed.png?raw=true)

Převzetí dokladu z AbraFlexi a jeho odeslání do prohlížeče: [getpdf.php](Examples/getpdf.php)

Formulář pro zadání přihlašovacích údajů AbraFlexi a zobrazení zdali bylo připojení úspěšné: [statussignin.php](Examples/statussignin.php)

![Test Připojení](Examples/statussignin.png?raw=true)


Instalátor uživatelských tlačítek [buttonInstaller](src/buttonInstaller.php)

![Custom Button Installer](Examples/buttoninstaller.png?raw=true)

+ tyto přesunuté původně z src

| Soubor                                                        | Popis                                 |
| ------------------------------------------------------------- | --------------------------------------|
| [common.php](Examples/common.php)                             | sdílené obecné funkce
| [ConnectionInfo.php](Examples/ConnectionInfo.php)             | Kontrola připojení k AbraFlexi serveru   
| [ConvertIncomeToZdd.php](Examples/ConvertIncomeToZdd.php)     | Zkonvertuje příjem v bance na ZDD a vytvoří vazbu
| [gethtml.php](Examples/gethtml.php)                           | Vrací HTML verzi dokumentu 
| [LogResults.php](Examples/LogResults.php)                     | Loguje výsledky requestu      
| [XSLTimporter.php](Examples/XSLTimporter.php)                 | Importuje XML přez XSLT transformaci
| [config.php](Examples/config.php)                             | Ukázka konfiguračního souboru 
| [CurrencyExchange.php](Examples/CurrencyExchange.php)         | Funkce pro směnu měny v záznamu 
| [getpdf.php](Examples/getpdf.php)                             | Vrací PDF verzi dokumentu  
| [parse-cmdline.php](Examples/parse-cmdline.php)               | Parser parametrů příkazové řádky
| [RegisterAddress.php](Examples/RegisterAddress.php)           | Ukázka použití registračního formuláře
| [UpomenNeplatice.php](Examples/UpomenNeplatice.php)           | Rozešle neplatičům upomínky
| [webhook.php](Examples/webhook.php)                           | Endpoint pro příjem WebHooků



Debian/Ubuntu
-------------

Pro Linux jsou k dispozici .deb balíčky. Prosím použijte repo:


```shell
sudo apt install lsb-release wget apt-transport-https bzip2

wget -qO- https://repo.vitexsoftware.com/keyring.gpg | sudo tee /etc/apt/trusted.gpg.d/vitexsoftware.gpg
echo "deb [signed-by=/etc/apt/trusted.gpg.d/vitexsoftware.gpg]  https://repo.vitexsoftware.com  $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/vitexsoftware.list
sudo apt update
sudo apt install php-vitexsoftware-abraflexi-bricks
```
