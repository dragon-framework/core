# Flash

- [FlashBag](#flashbag)
    - [hasFlashBag](#methods-hasFlashBag)
    - [setFlashBag](#methods-setFlashBag)
    - [getFlashBag](#methods-getFlashBag)
- [FlashData](#flashdata)
    - [setFlashData](#methods-setFlashData)
    - [getFlashData](#methods-getFlashData)

## FlashBag {#flashbag}

### hasFlashBag() {#methods-hasFlashBag}

Return true if a flashbag is already defined.

`$this->hasFlashBag()`

### setFlashBag() {#methods-setFlashBag}

Set a flash message.

`$this->setFlashBag(string $state, string $message[, bool $override=true])`

state
: -.

message
: -.

override
: if false, the message will not override flashbag if already defined.

### getFlashBag() {#methods-getFlashBag}

Get a flash message.

`$this->getFlashBag()`

return
: `array`

## FlashData {#flashdata}

### setFlashData() {#methods-setFlashData}

Set a flash data.

`$this->setFlashData(array $data)`

data
: -.

### getFlashData() {#methods-getFlashData}

Get a flash data.

`$this->getFlashData()`

return
: `array`
