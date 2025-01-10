# Changelog

All notable changes after v2.0.0 to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.1.1] - 2025-01-10

### Added

 * No additions

### Changed

 * `Array` types now have `isEmpty()`
 * `String` types now have `isEmpty()`
 * [AbstractString] - Fixed some nullable issues created by empty data 
 * [CSVUtil] - fixed some PHP 8.4 compatability issues with `fputcsv()` as:
   * 8.4.0 - "Relying on the default value of escape is now deprecated."

## [2.1.0] - 2024-10-01

### Added

 * New Examples for Collections and Numbers
 * [Types\Number] - Adds equals() functionality
 * [Traits\Array] - Adds the following traits used within the scope of the project or added to other classes:
   * OnSetTrait - Callback functions that can be run on setting of data
   * OnClearTrait - Callback functions that can be run on clearing of data
   * OnInsertTrait - Callback functions that can be run on insertion of an entry
   * OnRemoveTrait - Callback functions that can be run on removal of an entry
 * [Code Quality] Added Psalm and other code quality tools
 * Updated to PHP 8.3 compatibility 

### Changed

 * [Types\Number] - Adds math capabilities 
 * [Types\List] - Adds parseData
 * [KeyValuePair] - Adds extract key and delete functions
 * Corrected API where some function declarations were not typed
 * [Types] - Corrects missing final modifier on classes
 * [Traits\GetSetTrait] - Marked as deprecated with plans to move to `AccessorTrait`

## [2.0.0] - 2023-10-27

### Added

 * `\Types\Number`
 * `\Types\Double`
 * `\Abstracts\AbstractNumber`
 * `\Contracts\NumberInterface`
 * `\Contracts\ArrayInterface`
 * `\Exceptions\UnmatchedClassException`
 * `\Exceptions\UnmatchedVersionException`

### Changed

 * Twine->split($delimiter) becomes Twine->splitOn($delimiter) while Twine->split($position) becomes the new split functionality
 * Fixes MagicGetSetTrait where getter/setter -s were not accounting for capitalization the member name e.g. setdata() vs setData()
 * `\Type\Base\Contracts` moved to `\Contracts`
 * `\Type\Base` moved to `\Abstracts`
 * `\Type` moved to `\Types`
 * Interfaces names were made more generic

### Removed

 * `\Type\Base\AbstractKeyValuePair` (`\Abstracts\AbstractKeyValuePair`)

## [1.1.0] 2023-10-25

### Changed

 * Updates twine documentation (Still incomplete)
 * Last version before v2.0.0
