### Elvis
```php
function generateGreeting($name, $nickname)
{
  $user = $name ?: $nickname;
  return "Hello, {$user}!";
}
```
```php
function generateGreeting($name, $nickname)
{
  return $name ? "Hello, {$name}!" : "Hello, {$nickname}!";
}
```
```php
$ages = [3, 2];
$age = $ages[3] ?? 5; // 5 - значение по умолчанию
// Эквивалентно этой строчке
$age = isset($ages[3]) ? $ages[3] : 5;
```
### Reverse Array
```php
function reverseArray($coll)
{
    $size = count($coll);
    $maxIndex = floor($size / 2);
    for ($i = 0; $i < $maxIndex; $i++) {
        $mirrorIndex = $size - $i - 1;
        $temp = $coll[$i];
        $coll[$i] = $coll[$mirrorIndex];
        $coll[$mirrorIndex] = $temp;
    }

    return $coll;
}
```
### Calculate MAX
```php
function calculateMax($coll)
{
    if (empty($coll)) {
        return null;
    }

    $max = $coll[0]; // Принимаем за максимальное первый элемент
    // Обход начинаем со второго элемента
    for ($i = 1; $i < sizeof($coll); $i++) {
        if ($coll[$i] > $max) {
            $max = $coll[$i];
        }
    }
    return $max;
}

print_r(calculateMax([]));
print_r(calculateMax([3, 2, -10, 38, 0]));

// => 38
```
### String generator
```php
$parts = [];
foreach ($coll as $item) {
    $parts[] = "<li>{$item}</li>";
}
$innerValue = implode('', $parts);
$result = "<ul>{$innerValue}</ul>";
```
### Capitalize words
```php
function capitalizeWords($sentence)
{
    $words = explode(' ', $sentence);
    $capitalizedWords = [];
    foreach ($words as $word) {
        $capitalizedWords[] = ucfirst($word);
    }
    return implode(' ', $capitalizedWords);
}

$greeting = 'hello from Malasia';
print_r(capitalizeWords($greeting));
// => Hello From Malasia
```
### Flatten
```php
function flatten($coll)
{
    $result = [];
    foreach ($coll as $item) {
        if (is_array($item)) {
            $result = array_merge($result, $item);
        } else {
            $result[] = $item;
        }
    }

    return $result;
}

print_r(flatten([3, 2, [], [3, 4, 2], 3, [123, 3]]));
```
### Array Intersect
```php
$friends1 = ['vasya', 'kolya', 'petya'];
$friends2 = ['igor', 'petya', 'sergey', 'vasya', 'sasha'];

array_intersect($friends1, $friends2); // ['vasya', 'petya']
```
### Array Merge
```php
$friends1 = ['vasya', 'kolya', 'petya'];
$friends2 = ['igor', 'petya', 'sergey', 'vasya', 'sasha'];

// merge выполняет слияние двух массивов. В отличие от пересечения,
// в нём повторяются элементы, которые встречаются там и там (а не должны)
$friends = array_merge($friends1, $friends2);
// ['vasya', 'kolya', 'petya', 'igor', 'petya', 'sergey', 'vasya', 'sasha'];

// unique удаляет дубли
$sharedFriends = array_unique($friends);
// ['vasya', 'kolya', 'petya', 'igor', 'sergey', 'sasha']
```
### Array Diff
```php
$friends1 = ['vasya', 'kolya', 'petya'];
$friends2 = ['igor', 'petya', 'sergey', 'vasya', 'sasha'];

array_diff($friends1, $friends2); // ['kolya']
```
### Bubbl sort
```php
function bubbleSort($coll)
{
    $size = count($coll);
    do {
        $swapped = false;
        for ($i = 0; $i < $size - 1; $i++) {
            if ($coll[$i] > $coll[$i + 1]) {
                $temp = $coll[$i];
                $coll[$i] = $coll[$i + 1];
                $coll[$i + 1] = $temp;
                $swapped = true;
            }
        }
        $size--;
    } while ($swapped); // продолжаем, пока swapped === true
    return $coll;
}
$data = range(1, 30);
shuffle($data);
print_r(bubbleSort($data));
```
### Check if balanced
```php
function checkIfBalanced($expression)
{
    $stack = [];
    $startSymbols = ['{', '(', '<', '['];
    $pairs = ['{}', '()', '<>', '[]'];
    $len = strlen($expression);

    for ($i = 0; $i < $len; $i++) {
        $curr = $expression[$i];
        if (in_array($curr, $startSymbols)) {
            array_push($stack, $curr);
        } else {
            $prev = array_pop($stack);
            $pair = "{$prev}{$curr}";
            if (!in_array($pair, $pairs)) {
                return false;
            }
        }
    }
    return count($stack) === 0;
}
```
### FizzBuzz
```php
function stringifyFizzBuzz(array $data): void
{
    foreach ($data as $vaue) {
        $isFizz = (0 === $vaue % 3);
        $isBuzz = (0 === $vaue % 5);

        if (!$isFizz && !$isBuzz) {
            echo $vaue;
        }

        if ($isFizz) {
            echo 'Fizz';
        }

        if ($isBuzz) {
            echo 'Buzz';
        }
        echo PHP_EOL;
    }
}

$data = range(1, 100);

print_r(stringifyFizzBuzz($data));
```
