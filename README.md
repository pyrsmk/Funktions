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

Note: to ease the use of functions, they're all imported into the global scope.

### `dump()`

We've added the `VarDumper` module from Symfony to have a better `dump()` function (in replacement of `var_dump()`). It can do many things and ease your debug life, go [read the documentation](https://symfony.com/doc/current/components/var_dumper.html) to know more about it ;)

### `array.php`

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
- `push (array $array, ...$elements): array`: Immutable `array_push()`.
- `unshift (array $array, ...$elements): array`: Immutable `array_unshift()`.
- `shake (array $array): array`: Immutable `shuffle()`.

### `color.php`

- `rgb2hsl (int $r, int $g, int $b): array`: Convert RGB to HSL color.
- `hsl2rgb (int $h, int $s, int $l): array`: Convert HSL to RGB color.
- `rgb2hsv (int $r, int $g, int $b): array`: Convert RGB to HSV color.
- `hsv2rgb (int $h, int $s, int $v): array`: Convert HSV to RGB color.
- `rgb2hex (int $r, int $g, int $b): string`: Convert RGB to HTML color.
- `hex2rgb (string $hex): array`: Convert HTML to RGB color.

### `iterable.php`

- `value (iterable $iterable, string $key): mixed`: Retrieve a value from an iterable with a specified key. Note that it should be used with a hash or an array because iterating other an iterable for searching an element is not efficient at all.
- `first (iterable $iterable): mixed`: Return the first element of an iterable. Note that the iterable's pointer will be resetted.
- `last (iterable $iterable): mixed`: Return the last element of an iterable. Note that: if the iterable is an array, then its pointer will be resetted; if the iterable is not an array, it will be converted to one, then have in mind that a complete iteration will be done before being able to get its last element.
- `enumerate (iterable $iterable, ?callable $callable = null): int`: Enumerate elements in an iterable.
- `all (iterable $iterable, callable $callable): bool`: Return `true` when all elements match the callable's condition.
- `any (iterable $iterable, callable $callable): bool`: Return `true` when at least one element matches the callable's condition.
- `none (iterable $iterable, callable $callable): bool`: Return `true` when no element has matched the callable's condition.
- `select (iterable $iterable, callable $callable): Generator`: Select items that match the callable's condition.
- `reject (iterable $iterable, callable $callable): Generator`: Reject items that match the callable's condition.
- `pluck (iterable $iterable, string ...$keys): Generator`: Extract lines from an iterable based on the requested keys.
- `map (iterable $iterable, callable $callable): Generator`: Like `array_map()` but works on any iterable and with key/value support.
- `reduce (iterable $iterable, callable $callable, $initial = null)`: Like `array_reduce()` but works on any iterable and with key/value support.
- `iterable_to_generator (iterable $items): Generator`: Convert an iterable to a generator.
- `itog (iterable $items): Generator`: Alias to `iterable_to_generator()`.
- `itoa (Traversable $iterator, bool $use_keys = true): array`: Alias to `iterator_to_array()`.
- `ensure_generator ($maybe_a_generator): Generator`: Ensure that the passed value will be a generator.

### `instruction.php`

- `condition (bool $test, callable $truthy, callable $falsy): mixed`: Return a value based on a test.
- `loop (iterable $iterable, callable $callable): Generator`: Loop over an iterable and yield new values.
- `rescue (callable $callable, array $exceptions): mixed`: Execute a callback and catch exceptions.

### `memory.php`

- `mem_cleaned (callable $callable): mixed`: Collect garbage after callable execution.

### `number.php`

- `is_even (int $value): bool`: Verify if the value is even.
- `is_odd (int $value): bool`: Verify if the value is odd.
- `above (float $value, float $min): float`: Bound a number to a minimum value.
- `under (float $value, float $max): float`: Bound a number to a maximum value.

### `output.php`

- `capture (callable $callable): string`: Capture output on a callable execution.
- `mute (callable $callable): mixed`: Mute output on a callable execution.
- `puts (string $text): void`: Print a one-line text.

### `regex.php`

- `regex_count (string $pattern, string $text, int $flags = 0): int`: Count the number of matches for a regex in a string.
- `regex_match (string $pattern, string $text, int $flags = 0): Generator`: Return the matches of a regex, for the first match.
- `regex_match_first (string $pattern, string $text, int $flags = 0): string`: Return the first occurrence of the first match of a regex.
- `regex_match_all (string $pattern, string $text, int $flags = 0): Generator`: Return all the matches of a regex.
- `regex_test (string $pattern, string $text, int $flags = 0): bool`: Test if a regex matches against a string.

### `string.php`

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

### `system.php`

- `human_fileperms (string $path): string`: Get human-readable file permissions.
- `human_filesize (string $path): string`: Get human-readable file size.
- `lessdir (string $dir): array`: Like `scandir()` but without `.` and `..`.
- `mimetype (string $path): string`: Get a file's mime type with several mecanism support.
- `rrmdir (string $path): void`: Remove a directory recursively.

## License

[MIT](http://dreamysource.mit-license.org).
