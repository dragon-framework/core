# Flash

- [FlashBag](#flashbag)
    - [hasFlashBag](#methods-hasFlashBag)
    - [setFlashBag](#methods-setFlashBag)
    - [getFlashBag](#methods-getFlashBag)
- [FlashData](#flashdata)
    - [setFlashData](#methods-setFlashData)
    - [getFlashData](#methods-getFlashData)

## FlashBag {#flashbag}

Flash message are setted by `setFlashBag` method, and destroyed after `getFlashBag` method calling.

### hasFlashBag() {#methods-hasFlashBag}

Return true if a flashbag is already defined.

```php
$flash = new FlashBag;
$flash->hasFlashBag()
```

### setFlashBag() {#methods-setFlashBag}

Set a flash message.

```php
$flash = new FlashBag;
$flash->setFlashBag(string $state, string $message[, bool $override=true])
```

state
: State of message. Values : `success`, `warning`, `danger`, `info`, `primary`, `secondary`, `light`, `dark`.
.

message
: The message.

override
: if false, the message will not override flashbag if already defined.

### getFlashBag() {#methods-getFlashBag}

Get a flash message.

```php
$flash = new FlashBag;
$flash->getFlashBag()
```

return
: `array`

## FlashData {#flashdata}

Flash data are setted by `setFlashData` method, and destroyed after `getFlashData` method calling.

### setFlashData() {#methods-setFlashData}

Set a flash data.

```php
$flash = new FlashBag;
$flash->setFlashData(array $data)
```

data
: Array of data.

### getFlashData() {#methods-getFlashData}

Get a flash data.

```php
$flash = new FlashBag;
$flash->getFlashData()
```

return
: `array`
