# Twine

## Purpose

With 'string' being a reserved word and other options leading to length class names, such as ProperString, I chose to 
take a differnt approach. What's a synonym of String? Twine! It's basically just a proper object String.

## Methods

### Contains
* arguments: 
   * string $needle, bool $caseInsensitive
   * defaults: $caseInsensitive = false
* returns: bool
 
Test if the Twine contains the needle string. Can be a case insensitive match if second value is true

### EndsWith
* arguments: 
   * string $needle
* returns: bool
 
Test if the Twine contains and ends with the needle string. 
 
### Equals
* arguments: 
   * string|TwineInterface $needle
* returns: bool
 
Test if the Twine equals needle value. 

### Explode
 * arguments: 
   * string $delimiter, int $limit
   * defaults: $limit = PHP_INT_MAX
 * returns: ArrayInterface
 
Returns an object inheriting the ArrayInterface based on the string

### GetValue
 * arguments: none
 * returns: string
 
Returns the value of the string

### HasValue
* arguments: none
* returns: bool

Test to see if the Twine has a value and is not null

### IndexOf
* arguments: string $needle, int $startIndex
* defaults: $startIndex = 0
* returns: int|false

Get the position index of Twine value. Search can be started from startIndex position. Returns false if there is no match
 
### Insert
* arguments: string $insertion, int $offset
* returns: void

Insert the insertion value at the specified offset

### IsNullOrEmpty
* arguments: none
* returns: bool

Test to see if the Twine value is null or empty

### LastIndexOf
* arguments: string $needle, int $startIndex
* defaults: $startIndex = 0
* returns: int|false

Get the position of the last occurrence of $needle in the Twine value. Returns false if no matc. Returns false if no match.
 
### Length
 * arguments: none
 * returns: int
 * Get the length of the Twine
 
Returns the length of the Twine (string)

### Lower
 * arguments: none
 * returns: string
 
Return the value of the string in all lower case.

### Remove
 * arguments: int $offset, int $length
 * returns: void

From a starting position, remove the specified length of characters  

### SetValue
 * arguments: string $value
 * returns: AbstractString|StringInterface

Set the value of the string and returns self

### Split
 * arguments: 
   * string $delimiter, int $limit
   * defaults: $limit = PHP_INT_MAX
 * returns: ArrayInterface
 
Convenience function for explode

### Upper
 * arguments: none
 * returns: string
 
Return the value of the string in all upper case.
