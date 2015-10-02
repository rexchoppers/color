# Color
Color is a package to convert between color types.

## Install
Via Composer

``` bash
$ composer require xxx
```

## Usage
### HEX
``` php
$hex = new \Color\Types\HEX('ff0000'); // New HEX color
$hex = new \Color\Types\HEX('ff0000', '#{code}'); // New HEX color with template
echo $hex->code(); // 'FF0000'
echo $hex; // '#FF0000'
echo $hex->withTemplate('color: #{code};'); // 'color: #FF0000;'

$hex  = $hex->toHEX(); // Convert the color to \Color\Types\HEX
$rgb  = $hex->toRGB(); // Convert the color to \Color\Types\RGB
$hsl  = $hex->toHSL(); // Convert the color to \Color\Types\HSL
$c256 = $hex->to256(); // Convert the color to \Color\Types\C256
```

#### Default template
`#{code}`

#### Sanitizing
HEX does some sanitizing to support all the various ways a hex color can be written.

Example:
```
123       => '112233'
987654    => '987654'
'aBc'     => 'AABBCC'
'FeDcBa'  => 'FEDCBA'
'#1B5'    => '11BB55'
'#1a2b3c' => '1A2B3C'
```

### RGB
``` php
$rgb = new \Color\Types\RGB(255, 0, 0); // New RGB color
$rgb = new \Color\Types\RGB(255, 0, 0, '{red},{green},{blue}'); // New RGB color with template
echo $rgb->red(); // 255
echo $rgb->green(); // 0
echo $rgb->blue(); // 0
echo $rgb->rgb(); // [255, 0, 0]
echo $rgb; // '255,0,0'
echo $rgb->withTemplate('color: rgb({red}, {green}, {blue});'); // 'color: rgb(255, 0, 0);'

$rgb = $rgb->withRed(0); // New instance with red set to 0
$rgb = $rgb->withGreen(255); // New instance with green set to 255
$rgb = $rgb->withBlue(255); // New instance with blue set to 255

$hex  = $rgb->toHEX(); // Convert the color to \Color\Types\HEX
$rgb  = $rgb->toRGB(); // Convert the color to \Color\Types\RGB
$hsl  = $rgb->toHSL(); // Convert the color to \Color\Types\HSL
$c256 = $rgb->to256(); // Convert the color to \Color\Types\C256
```

#### Default template
`{red},{green},{blue}`

### HSL
``` php
$hsl = new \Color\Types\HSL(0, 100, 50); // New HSL color
$hsl = new \Color\Types\HSL(0, 100, 50, '{hue}° {saturation}% {lightness}%'); // New HSL color with template
echo $hsl->hue(); // 0
echo $hsl->saturation(); // 100
echo $hsl->lightness(); // 50
echo $hsl->hsl(); // [0, 100, 50]
echo $hsl; // '0° 100% 50%'
echo $hsl->withTemplate('color: ({hue}, {saturation}%, {lightness}%);'); // 'color: hsl(0, 100%, 50%);'

$hsl = $hsl->withHue(180); // New instance with hue set to 180
$hsl = $hsl->withSaturation(50); // New instance with saturation set to 50
$hsl = $hsl->withLightness(25); // New instance with lightness set to 25

$hex  = $hsl->toHEX(); // Convert the color to \Color\Types\HEX
$rgb  = $hsl->toRGB(); // Convert the color to \Color\Types\RGB
$hsl  = $hsl->toHSL(); // Convert the color to \Color\Types\HSL
$c256 = $hsl->to256(); // Convert the color to \Color\Types\C256

$hsl = $hsl->lighten(10); // New instance that is lightened by 10%
$hsl = $hsl->darken(10); // New instance that is darkened by 10%

$hsl = $hsl->saturate(10); // New instance that is saturated by 10%
$hsl = $hsl->desaturate(10); // New instance that is desaturated by 10%

$mix = $hsl->mix(new \Color\Types\HSL(120, 100, 50)); // Get a new color that is a mix between two colors
```

#### Default template
`{hue}° {saturation}% {lightness}%`

### 256
``` php
$c256 = new \Color\Types\C256(196); // New 256 color
$c256 = new \Color\Types\C256(196, '{code}'); // New 256 color with template
echo $c256->code(); // 196
echo $c256; // '196'
echo $c256->withTemplate('\e[48;{code}m'); // '\e[48;196m'

$hex  = $c256->toHEX(); // Convert the color to \Color\Types\HEX
$rgb  = $c256->toRGB(); // Convert the color to \Color\Types\RGB
$hsl  = $c256->toHSL(); // Convert the color to \Color\Types\HSL
$c256 = $c256->to256(); // Convert the color to \Color\Types\C256
```

#### Default template
`{code}`

## Change log
Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Scripts
### Testing
Run the phpunit test suite.

``` bash
$ composer test
```

### Fixing
Run the PHP Coding Standards Fixer.

``` bash
$ composer fix
```

## Security
If you discover any security related issues, please email martindilling@gmail.com instead of using the issue tracker.

## Credits
- [Martin Dilling-Hansen][link-author]
- [All Contributors][link-contributors]

## License
Please see [License File](LICENSE.md) for more information.

