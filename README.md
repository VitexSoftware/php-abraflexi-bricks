# Bricks for AbraFlexi
![Project Logo](social-preview.svg?raw=true "Project Logo")

[![Build Status](https://travis-ci.org/VitexSoftware/php-abraflexi-bricks.svg?branch=main)](https://travis-ci.org/VitexSoftware/php-abraflexi-bricks)
[![GitHub stars](https://img.shields.io/github/stars/VitexSoftware/php-abraflexi-bricks.svg)](stargazers)
[![GitHub issues](https://img.shields.io/github/issues/VitexSoftware/php-abraflexi-bricks.svg)](issues)
[![GitHub license](https://img.shields.io/github/license/VitexSoftware/php-abraflexi-bricks.svg)](LICENSE?raw=true)
[![Twitter](https://img.shields.io/twitter/url/https/github.com/VitexSoftware/php-abraflexi-bricks.svg?style=social)](https://twitter.com/intent/tweet?text=Wow:&url=https%3A%2F%2Fgithub.com%2FVitexSoftware%2Fphp-abraflexi-bricks)

Examples of how to use the [php-abraflexi](https://github.com/Spoje-NET/php-abraflexi) Library for AbraFlexi with EasePHP Framework widgets

Examples of using the [php-abraflexi](https://github.com/Spoje-NET/php-abraflexi) library for [AbraFlexi](https://flexibee.eu/)


Installation
------------

    composer require vitexsoftware/abraflexi-bricks


How to run?
-----------

1) composer install
2) cd src
3) modify config.php to use custom AbraFlexi connection
4) open the project URL in the browser


### What do we have here?

So far, a few practical examples intended for use in your applications - hence the name bricks/cihličky

# Classes in php-abraflexi/Bricks/:

| File                                                           | Description                           |
| -------------------------------------------------------------- | ------------------------------------- |
| [Convertor.php](src/php-abraflexi/Bricks/Convertor.php)        | Document converter
| [Customer.php](src/php-abraflexi/Bricks/Customer.php)          | Customer
| [GdprLog.php](src/php-abraflexi/Bricks/GdprLog.php)            | GDPR Logger with support for AbraFlexi
| [GateKeeper.php](src/php-abraflexi/Bricks/GateKeeper.php)      | Checks if the user's company matches the document's company
| [PotvrzeniUhrady.php](src/php-abraflexi/Bricks/HookReciever.php)| Class confirming received payment
| [ParovacFaktur.php](src/php-abraflexi/Bricks/ParovacFaktur.php)| Invoice matcher

# Classes in php-abraflexi/Bricks/ui:

| File                                                           | Description                           |
| -------------------------------------------------------------- | ------------------------------------- |
| [CompanyLogo.php](src/php-abraflexi/Bricks/ui/CompanyLogo.php) | Company Logo
| [DocumentLink.php](src/php-abraflexi/Bricks/ui/DocumentLink.php)| Link to the document in the AbraFlexi web interface
| [AbraFlexiLogo.php](src/php-abraflexi/Bricks/ui/AbraFlexiLogo.php)| AbraFlexi Logo
| [EmbedResponsiveHTML.php](src/php-abraflexi/Bricks/ui/EmbedResponsiveHTML.php)| Class for displaying HTML document on the page
| [EmbedResponsivePDF.php](src/php-abraflexi/Bricks/ui/EmbedResponsivePDF.php)  | Class for displaying PDF document on the page
| [RecordTypeSelect.php](src/php-abraflexi/Bricks/ui/RecordTypeSelect.php)      | Dropdown for selecting document type
| [RecordChooser.php](src/php-abraflexi/Bricks/ui/RecordChooser.php)            | Dropdown for selecting record based on [Selectize.js](https://selectize.github.io/selectize.js/)


Examples in the [Examples](Examples) folder
===========================================

Company Logo: [companylogo.php](Examples/companylogo.php)

![Logo](Examples/companylogo.png?raw=true)

Address Editor: [addresseditor.php](Examples/addresseditor.php)

![Output](Examples/addresseditor.png?raw=true)

Invoice listing on the page: [invoices.php](Examples/invoices.php)

![Output](Examples/invoices.png?raw=true)

Embedding PDF on the page: [embed.php](Examples/embed.php)

![Embedding](Examples/embed.png?raw=true)

Retrieving document from AbraFlexi and sending it to the browser: [getpdf.php](Examples/getpdf.php)

Form for entering AbraFlexi login details and displaying whether the connection was successful: [statussignin.php](Examples/statussignin.php)

![Connection Test](Examples/statussignin.png?raw=true)


Custom button installer [buttonInstaller](src/buttonInstaller.php)

![Custom Button Installer](Examples/buttoninstaller.png?raw=true)

+ these moved originally from src

| File                                                           | Description                           |
| -------------------------------------------------------------- | ------------------------------------- |
| [common.php](Examples/common.php)                              | shared general functions
| [ConnectionInfo.php](Examples/ConnectionInfo.php)              | Connection check to AbraFlexi server
| [ConvertIncomeToZdd.php](Examples/ConvertIncomeToZdd.php)      | Converts bank income to ZDD and creates a link
| [gethtml.php](Examples/gethtml.php)                            | Returns HTML version of the document
| [LogResults.php](Examples/LogResults.php)                      | Logs request results
| [XSLTimporter.php](Examples/XSLTimporter.php)                  | Imports XML via XSLT transformation
| [config.php](Examples/config.php)                              | Example configuration file
| [CurrencyExchange.php](Examples/CurrencyExchange.php)          | Functions for currency exchange in a record
| [getpdf.php](Examples/getpdf.php)                              | Returns PDF version of the document
| [parse-cmdline.php](Examples/parse-cmdline.php)                | Command line parameter parser
| [RegisterAddress.php](Examples/RegisterAddress.php)            | Example of using the registration form
| [UpomenNeplatice.php](Examples/UpomenNeplatice.php)            | Sends reminders to debtors
| [webhook.php](Examples/webhook.php)                            | Endpoint for receiving WebHooks



Debian/Ubuntu
-------------

For Linux, .deb packages are available. Please use the repo:


```shell
sudo apt install lsb-release wget apt-transport-https bzip2

wget -qO- https://repo.vitexsoftware.com/keyring.gpg | sudo tee /etc/apt/trusted.gpg.d/vitexsoftware.gpg
echo "deb [signed-by=/etc/apt/trusted.gpg.d/vitexsoftware.gpg]  https://repo.vitexsoftware.com  $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/vitexsoftware.list
sudo apt update
sudo apt install php-vitexsoftware-abraflexi-bricks
```
