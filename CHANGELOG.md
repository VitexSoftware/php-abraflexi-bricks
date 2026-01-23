# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.5.0] - 2026-01-23

### Fixed
- **Critical**: Fixed fatal error `strlen(): Argument #1 ($string) must be of type string, null given` in `getUserEmail()` method
- Fixed inverted conditional logic in `insertToAbraFlexi()` that was overwriting parameter data
- Fixed query builder in `getCustomerDebts()` that was concatenating object instead of ID
- Fixed type safety issues throughout Customer class with proper null checks
- Fixed uninitialized `$firma` property

### Changed
- **Breaking**: Changed property visibility from `public` to `private` for better encapsulation
- Improved return type declarations (`mixed` instead of incorrect `int`/`bool`)
- Constructor now accepts optional `$firma` parameter
- Refactored constructor logic into `loadByUsername()` and `loadByEmail()` helper methods
- Improved error handling with proper status messages

### Added
- Added `setFirma()` and `getFirma()` accessor methods
- Added proper null-safe string operations throughout
- Added comprehensive PHPDoc comments

## [1.4.1] - 2025-06-24

### Removed
- UI components removed

## [1.3.1] - 2025-06-24

### Changed
- Customer class modernized

## [1.3.0] - 2025-02-28

### Changed
- Version 1.3.0 release

## [1.2.1] - 2024-10-10

### Added
- New rule FakturaPrijataPolozka_to_Cenik

## [1.2.0] - 2024-07-31

### Added
- New Cloner and its rules
- FakturaPrijata_to_Zavazek update

### Fixed
- Composer JSON fix
- Convert rule fixes
- Debian package fixed
- Typo fixed

### Changed
- Repack for Buster
- twbootstrap renamed to bootstrap
- Logo file renamed according to AbraFlexi current name

## [0.24] - 2019-06-06

### Changed
- ease-core-based release

## [0.21] - 2019-05-23

### Added
- New gatekeeper
- GDPR Logger Class added
- \Ease\ui\Selectizer based RecordChooser && RecordSelector

## [0.19] - 2019-05-23

### Added
- New GateKeeper
- New RecordSelector
- Button Installer example

## [0.13] - 2018-11-27

### Added
- New Order listing widget added
- CompanyLogo added

### Changed
- getCustomerDebts return only invoices after due date

## [0.8] - 2018-01-30

### Added
- EUR support

### Changed
- Packaging improvements
