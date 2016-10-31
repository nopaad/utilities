# utilities
A classic collection of php utilities

### default timestamp is now
```php
$date = jDate::forge();
```

### pass timestamps
```php
$date = jDate::forge(1333857600);
```

### pass strings to make timestamps
```php
$date = jDate::forge('last sunday');
```

### get the timestamp
```php
$date = jDate::forge('last sunday')->time(); // 1333857600
```

### format the timestamp
```php
$date = jDate::forge('last sunday')->format('%B %d، %Y'); // دی 02، 1391
```

### get a predefined format
```php
$date = jDate::forge('last sunday')->format('datetime'); // 1391-10-02 00:00:00
$date = jDate::forge('last sunday')->format('date'); // 1391-10-02
$date = jDate::forge('last sunday')->format('time'); // 00:00:00
```

### amend the timestamp value, relative to existing value
```php
$date = jDate::forge('2012-10-12')->reforge('+ 3 days')->format('date'); // 1391-07-24
```

### get relative 'ago' format
```php
$date = jDate::forge('now - 10 minutes')->ago() // ۱۰ دقیقه پیش
```