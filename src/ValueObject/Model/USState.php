<?php

namespace PHPAlchemist\ValueObject\Model;

use InvalidArgumentException;
use PHPAlchemist\ValueObject\Abstract\AbstractString;

final class USState extends AbstractString
{
    const int CODE_LENGTH = 2;

    protected string $code;

    protected array $validOptions = [
        'AL' => 'Alabama',
        'AK' => 'Alaska',
        'AS' => 'American Samoa', // Territory
        'AZ' => 'Arizona',
        'AR' => 'Arkansas',
        'CA' => 'California',
        'CO' => 'Colorado',
        'CT' => 'Connecticut',
        'DE' => 'Delaware',
        'FL' => 'Florida',
        'GA' => 'Georgia',
        'GU' => 'Guam', // Territory
        'HI' => 'Hawaii',
        'ID' => 'Idaho',
        'IL' => 'Illinois',
        'IN' => 'Indiana',
        'IA' => 'Iowa',
        'KS' => 'Kansas',
        'KY' => 'Kentucky',
        'LA' => 'Louisiana',
        'ME' => 'Maine',
        'MD' => 'Maryland',
        'MA' => 'Massachusetts',
        'MI' => 'Michigan',
        'MN' => 'Minnesota',
        'MS' => 'Mississippi',
        'MO' => 'Missouri',
        'MT' => 'Montana',
        'NE' => 'Nebraska',
        'NV' => 'Nevada',
        'NH' => 'New Hampshire',
        'NJ' => 'New Jersey',
        'NM' => 'New Mexico',
        'NY' => 'New York',
        'MP' => 'Northern Mariana Islands', // Territory
        'NC' => 'North Carolina',
        'ND' => 'North Dakota',
        'OH' => 'Ohio',
        'OK' => 'Oklahoma',
        'OR' => 'Oregon',
        'PA' => 'Pennsylvania',
        'PR' => 'Puerto Rico', // Territory
        'RI' => 'Rhode Island',
        'SC' => 'South Carolina',
        'SD' => 'South Dakota',
        'TN' => 'Tennessee',
        'TX' => 'Texas',
        'UT' => 'Utah',
        'VT' => 'Vermont',
        'VA' => 'Virginia',
        'WA' => 'Washington',
        'WV' => 'West Virginia',
        'WI' => 'Wisconsin',
        'WY' => 'Wyoming',
        'VI' => 'US Virgin Islands', // Territory
    ];

    public function __construct(string $value)
    {
        if (!in_array($value, $this->validOptions, true) && !array_key_exists($value, $this->validOptions)) {
            throw new InvalidArgumentException('Invalid US State value.');
        }

        if (strlen($value) !== self::CODE_LENGTH) {
            $code = array_search($value, $this->validOptions, true);
        } elseif (strlen($value) === self::CODE_LENGTH) {
            $code  = $value;
            $value = $this->validOptions[$value];
        }

        $this->code  = $code;
        $this->value = $value;
    }

    public function getName() : string
    {
        return $this->value;
    }

    public function getCode() : string
    {
        return $this->code;
    }
}
