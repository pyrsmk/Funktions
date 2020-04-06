# Funktions

Funktions is a set of useful PHP functions aiming to ease your life by appending missing ones from PHP core.

These functions are designed:

- to be immutables
- to support all iterables, not only arrays
- to support all callables, not only closures
- to use generators first (because it rocks!)

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

- `array_diff_strict (array $array1, array $array2): array`: Strict diff between two arrays by comparing the values at the same index.
- `array_fill_multi (int $dimensions, int $size, mixed $value): array`: Initialize multi-dimensional arrays.
- `array_intersect_strict (array $array1, array $array2): array`: Strict insersection between two arrays by comparing the values at the same index.
- `array_merge_recursive_unique (array ...$arrays): array`: Contrary to `array_merge_recursive()`, it merges array by replacing values of the same key instead of appending them into a new array.
- `immut_sort (array $array, int $flags = SORT_REGULAR): array`: Immutable `sort()`.
- `immut_asort (array $array, int $flags = SORT_REGULAR): array`: Immutable `asort()`.
- `immut_arsort (array $array, int $flags = SORT_REGULAR): array`: Immutable `arsort()`.
- `immut_rsort (array $array, int $flags = SORT_REGULAR): array`: Immutable `rsort()`.
- `immut_ksort (array $array, int $flags = SORT_REGULAR): array`: Immutable `ksort()`.
- `immut_krsort (array $array, int $flags = SORT_REGULAR): array`: Immutable `krsort()`.
- `immut_usort (array $array, callable $compare): array`: Immutable `usort()`.
- `immut_uksort (array $array, callable $compare): array`: Immutable `uksort()`.
- `immut_uasort (array $array, callable $compare): array`: Immutable `uasort()`.
- `immut_natsort (array $array): array`: Immutable `natsort()`.
- `immut_natcasesort (array $array): array`: Immutable `natcasesort()`.
- `drop (array $array, int $offset, int $length): array`: Drop a part of an array (immutable `array_splice`).
- `substitute (array $array, int $offset, int $length, array $replacement): array`: Improved `array_splice()` with full string keys support when replacing.
- `glue (array $array, string $glue = ''): string`: Glue array elements together, like `implode()` but with parameters in the right order.
- `kmax (array $array): mixed`: Return the key of the maximum value.
- `kmin (array $array): mixed`: Return the key of the minimum value.
- `seek (array &$array, int|string $key): void`: Move the array pointer to a specified key (mutable).

### `Funktions\ColorFuncs`

- `rgb2hsl (int $r, int $g, int $b): array`: Convert RGB to HSL color.
- `hsl2rgb (int $h, int $s, int $l): array`: Convert HSL to RGB color.
- `rgb2hsv (int $r, int $g, int $b): array`: Convert RGB to HSV color.
- `hsv2rgb (int $h, int $s, int $v): array`: Convert HSV to RGB color.
- `rgb2hex (int $r, int $g, int $b): string`: Convert RGB to HTML color.
- `hex2rgb (string $hex): array`: Convert HTML to RGB color.

### `Funktions\IterableFuncs`

- `one (iterable $iterable, callable $callable): bool`: Return `true` when at least one element matches the callable's condition.
- `none (iterable $iterable, callable $callable): bool`: Return `true` when no element has matched the callable's condition.
- `select (iterable $iterable, callable $callable): Generator`: Select items that match the callable's condition.
- `reject (iterable $iterable, callable $callable): Generator`: Reject items that match the callable's condition.
- `map (iterable $iterable, callable $callable): Generator`: Like `array_map()` but works on any iterable and with key/value support.
- `reduce (iterable $iterable, callable $callable, $initial = null)`: Like `array_reduce()` but works on any iterable and with key/value support.
- `to_array (Traversable $iterator, bool $use_keys = true): array`: Alias to `iterator_to_array()`.
- `to_generator (iterable $items): Generator`: Convert an iterable to a generator.
- `ensure_generator ($maybe_a_generator): Generator`: Ensure that the passed value will be a generator.

### `Funktions\InstructionFuncs`

- `condition (bool $test, callable $truthy, callable $falsy): mixed`: Return a value based on a test.
- `loop (iterable $iterable, callable $callable): Generator`: Loop over an iterable and yield new values.
- `rescue (callable $callable, array $exceptions): mixed`: Execute a callback and catch exceptions.

### `Funktions\MemoryFuncs`

- `mem_cleaned (callable $callable): mixed`: Collect garbage after callable execution.

### `Funktions\NumberFuncs`

- `is_even (int $value): bool`: Verify if the value is even.
- `is_odd (int $value): bool`: Verify if the value is odd.
- `above (float $value, float $min): float`: Bound a number to a minimum value.
- `under (float $value, float $max): float`: Bound a number to a maximum value.

### `Funktions\OutputFuncs`

- `capture (callable $callable): string`: Capture output on a callable execution.
- `mute (callable $callable): mixed`: Mute output on a callable execution.
- `puts (string $text): void`: Print a one-line text.

### `Funktions\RegexFuncs`

- `regex_count (string $pattern, string $text, int $flags = 0): int`: Count the number of matches for a regex in a string.
- `regex_match (string $pattern, string $text, int $flags = 0): Generator`: Return the matches of a regex, for the first match.
- `regex_match_first (string $pattern, string $text, int $flags = 0): string`: Return the first occurrence of the first match of a regex.
- `regex_match_all (string $pattern, string $text, int $flags = 0): Generator`: Return all the matches of a regex.
- `regex_test (string $pattern, string $text, int $flags = 0): bool`: Test if a regex matches against a string.

### `Funktions\StringFuncs`

<<<<<<< HEAD
- `mb_to_camelcase (string $string): string`: converts a string to camel case
- `mb_ucwords (string $string, string $encoding = null): string`: capitalize all words in a string
- `mb_ucfirst (string $string, string $encoding = null): string`: capitalize a string
- `mb_lcfirst ($string, string $encoding = null): string`: uncapitalize a string
- `mb_truncate (string $string, int $length, string $encoding = null): string`: truncate a string to a specific length and append `...` at the end of the string
- `random_hash (int $length = 5): string`: generate a random hash
- `uuid_v4 (): string`: generate a random v4 UUID
=======
- `mb_to_camelcase (string $string): string`: Converts a string to camelcase (multibyte support).
- `mb_ucwords (string $string, string $encoding = null): string`: Capitalize all words in a string (multibyte support).
- `mb_ucfirst (string $string, string $encoding = null): string`: Capitalize a string (multibyte support).
- `mb_lcfirst ($string, string $encoding = null): string`: Uncapitalize a string (multibyte support).
- `mb_truncate (string $string, int $length, string $encoding = null): string`: Truncate a string to a specific length and append `...` at the end of the string (multibyte support).
- `random_hash (int $length = 5): string`: Generate a random hash.
- `uuid_v4 (): string`: Generate a random v4 UUID.
>>>>>>> 46e018a... Update documentation

### `Funktions\SystemFuncs`

- `dump (mixed $var): mixed` : Formatted variable dumping function with variable passthrough.
- `human_fileperms (string $path): string`: Get human-readable file permissions.
- `human_filesize (string $path): string`: Get human-readable file size.
- `lessdir (string $dir): array`: Like `scandir()` but without `.` and `..`.
- `mimetype (string $path): string`: Get a file's mime type with several mecanism support.
- `rrmdir (string $path): void`: Remove a directory recursively.

## License

[MIT](http://dreamysource.mit-license.org).
