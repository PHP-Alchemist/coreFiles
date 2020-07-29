# ProperString

## Methods

### Length
 * arguments: none
 * returns: int
 
Returns the length of the string

### Upper
 * arguments: none
 * returns: string
 
Return the value of the string in all upper case.

### Lower
 * arguments: none
 * returns: string
 
Return the value of the string in all lower case.

### Explode
 * arguments: string $delimiter, int $limit
   * defaults: $limit = PHP_INT_MAX
 * returns: ArrayInterface
 
Returns an object inheriting the ArrayInterface based on the string

### GetValue
 * arguments: none
 * returns: string
 
Returns the value of the string

### HasValue
 * arguments: none
 * returns: boolean

Returns a boolean based on if a value is set 

### SetValue
 * arguments: string $value
 * returns: AbstractString|StringInterface

Set the value of the string and returns self