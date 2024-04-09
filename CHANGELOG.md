# Changelog

All notable changes after v2.0.0 to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

 * New Examples for Collections and Numbers

### Changed

 * [Number] - Adds math capabilities 
 * [List] - Adds parseData
 * [KeyValuePair] - Adds extract key and delete functions
 * Corrected API where some function declarations were not typed

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