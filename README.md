# Funktions

Funktions is a set of useful PHP functions aiming to ease your life by appending missing ones from PHP core, or modifying some of them, with immutability in mind.

__WARNING!!! STILL UNDER HEAVY DEVELOPMENT AND NOT TESTED YED__

## Install

```sh
composer require pyrsmk/funktions
```

## Use

```php
use function Funktions\ArrayFuncs\array_sort;

$sorted_array = array_sort($my_array);
```

### `Funktions\ArrayFuncs`

- `array_diff_strict (array $array1, array $array2): array`: strict diff between two arrays by comparing the values at the same index
- `array_drop (array $array, int $offset, int $length): array`: drop a part of an array
- `array_fill_multi (int $dimensions, int $size, mixed $value): array`: initialize multi-dimensional arrays
- `array_intersect_strict (array $array1, array $array2): array`: strict insersection between two arrays by comparing the values at the same index
- `array_kvmap (array $array, callable $callback): array`: `array_map()` with key/value support
- `array_kvreduce (array $array, callable $callback, mixed $initial = null): mixed`: `\array_reduce()` with key/value support
- `array_merge_recursive_unique (array ...$arrays): array`: contrary to `\array_merge_recursive()`, it merges array by replacing values of the same key instead of appending them into a new array
- `array_substitute (array $array, int $offset, int $length, array $replacement): array`: improved `\array_splice()` with full string keys support when replacing
- `array_sort (array $array, int $flags = SORT_REGULAR): array`: immutable `\sort()`
- `array_asort (array $array, int $flags = SORT_REGULAR): array`: immutable `\asort()`
- `array_arsort (array $array, int $flags = SORT_REGULAR): array`: immutable `\arsort()`
- `array_rsort (array $array, int $flags = SORT_REGULAR): array`: immutable `\rsort()`
- `array_ksort (array $array, int $flags = SORT_REGULAR): array`: immutable `\ksort()`
- `array_krsort (array $array, int $flags = SORT_REGULAR): array`: immutable `\krsort()`
- `array_usort (array $array, callable $compare): array`: immutable `\usort()`
- `array_uksort (array $array, callable $compare): array`: immutable `\uksort()`
- `array_uasort (array $array, callable $compare): array`: immutable `\uasort()`
- `array_natsort (array $array): array`: immutable `\natsort()`
- `array_natcasesort (array $array): array`: immutable `\natcasesort()`
- `glue (array $array, string $glue = ''): string`: glue array elements together, like `\implode()` but with parameters in the right order
- `kmax (array $array): mixed`: return the key of the maximum value
- `kmin (array $array): mixed`: return the key of the minimum value
- `seek (array &$array, int|string $key): void`: move the array pointer to a specified key (mutable)

Some useful aliases :

- `map (array $array, callable $callback): array`: alias to `\array_kvmap()`
- `reduce (array $array, callable $callback, $initial = null)`: alias to `\array_kvreduce()`

### `Funktions\ColorFuncs`

- `rgb2hsl (int $r, int $g, int $b): array`: convert RGB to HSL color
- `hsl2rgb (int $h, int $s, int $l): array`: convert HSL to RGB color
- `rgb2hsv (int $r, int $g, int $b): array`: convert RGB to HSV color
- `hsv2rgb (int $h, int $s, int $v): array`: convert HSV to RGB color
- `rgb2hex (int $r, int $g, int $b): string`: convert RGB to HTML color
- `hex2rgb (string $hex): array`: convert HTML to RGB color

### `Funktions\GeneratorFuncs`

- `array_to_generator (array $items): Generator`: convert an array to a generator
- `ensure_generator ($maybe_a_generator): Generator`: ensure that the passed value will be a generator

### `Funktions\InstructionFuncs`

- `condition (bool $test, callable $truthy, callable $falsy): mixed`: return a value based on a test
- `loop (iterable $iterable, callable $callable): Generator`: loop over an iterable and yield new values
- `loop_preserve (iterable $iterable, callable $callable): Generator`: Loop over an iterable and yield new values (with key preservation)
- `rescue (callable $callable, array $exceptions): mixed`: execute a callback and catch exceptions

### `Funktions\MemoryFuncs`

- `mem_cleaned (callable $callable): mixed`: collect garbage after callable execution

### `Funktions\NumberFuncs`

- `is_even (int $value): bool`: verify if the value is even
- `is_odd (int $value): bool`: verify if the value is odd
- `above (float $value, float $min): float`: bound a number to a minimum value
- `under (float $value, float $max): float`: bound a number to a maximum value

### `Funktions\OutputFuncs`

- `capture (callable $callable): string`: capture output on a callable execution
- `mute (callable $callable): mixed`: mute output on a callable execution
- `puts (string $text): void`: print a one-line text

### `Funktions\RegexFuncs`

- `regex_count (string $pattern, string $text, int $flags = 0): int`: count the number of matches for a regex in a string
- `regex_match (string $pattern, string $text, int $flags = 0): array`: return the matches of a regex, for the first match
- `regex_match_first (string $pattern, string $text, int $flags = 0): string`: return the first occurrence of the first match of a regex
- `regex_match_all (string $pattern, string $text, int $flags = 0): array`: return all the matches of a regex
- `regex_test (string $pattern, string $text, int $flags = 0): bool`: test if a regex matches against a string

### `Funktions\StringFuncs`

- `mb_to_camelcase (string $string): string`: converts a string to camel case
- `mb_ucwords (string $string, string $encoding = null): string`: capitalize all words in a string
- `mb_ucfirst (string $string, string $encoding = null): string`: capitalize a string
- `mb_lcfirst ($string, string $encoding = null): string`: uncapitalize a string
- `mb_truncate (string $string, int $length, string $encoding = null): string`: truncate a string to a specific length and append `...` at the end of the string
- `random_hash (int $length = 5): string`: generate a random hash
- `uuid4 (): string`: generate a random v4 UUID

### `Funktions\SystemFuncs`

- `dump (mixed $var): mixed` : formatted variable dumping function with variable passthrough
- `human_fileperms (string $path): string`: get human-readable permissions
- `human_filesize (string $path): string`: get human-readable file size
- `lessdir (string $dir): array`: like `\scandir()` but without `.` and `..`
- `mimetype (string $path): string`: get a file's mime type with several mecanism support
- `rrmdir (string $path): void`: remove a directory recursively

## License

[MIT](http://dreamysource.mit-license.org).
