# Runners

Runners are used for looping through files.
They do not know anything about what they are importing, that info is fetched from the `Importer`.

## Methods

These are the methods a runner should have, custom runners should implement the interface: `Luna\Importer\Contracts\Runner`.

```php
/**
 * Things to do before the import
 *
 * @return void
 */
public function beforeImport();
```

```php
/**
 * The import runner
 *
 * @return void
 */
public function import();
```

```php
/**
 * Things to do after the import
 *
 * @return void
 */
public function afterImport();
```

```php
/**
 * Start the import
 *
 * @param  Importer  $importer
 * @return void
 */
public function handle(Importer $importer);
```

```php
/**
 * Check if the file is valid for importing
 *
 * @return bool
 */
public function validateFile(): bool;
```

```php
/**
 * What to do when removing the file
 *
 * @return void
 */
public function removeFile();
```

```php
/**
 * Determine which lines need to be removed by the importer.
 *
 * By default, the lines that were not present in the import file are
 * removed after the other lines are updated, added or remained unchanged
 *
 * @return void
 */
public function removeStale();
```