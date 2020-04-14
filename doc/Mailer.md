# Mailer

- [Configuration](#configuration)
- [Example](#example)
- [Methods](#methods)
    - [setFrom()](#methods-setFrom)
    - [addAddress()](#methods-addAddress)
    - [addReplyTo()](#methods-addReplyTo)
    - [addCC()](#methods-addCC)
    - [addBCC()](#methods-addBCC)
    - [addAttachment()](#methods-addAttachment)
    - [setSubject()](#methods-setSubject)
    - [setParams()](#methods-setParams)
    - [setBody()](#methods-setBody)
    - [setBodyTemplate()](#methods-setBodyTemplate)
    - [setAltBody()](#methods-setAltBody)
    - [setAltBodyTemplate()](#methods-setAltBodyTemplate)
    - [send()](#methods-send)

## Configuration {#configuration}

|Key|Type|Default|Description|
|--|--|--|--|
|`transport`|`string`|"smtp"|.|
|`auth`|`bool`|true|.|
|`tls`|`bool`|true|.|
|`host`|`string`|""|.|
|`username`|`string`|""|.|
|`password`|`string`|""|.|
|`port`|`integer`|587|.|
|`from_address`|`string`|""|Defaut sender email.|
|`from_name`|`string`|""|Default sender name.|
|`noreply`|`string`|""|Default no-reply address.|

## Example {#example}

```php
use Dragon\Component\Mailer\Mailer;
// ...
$mailer = new Mailer;
$mailer->addAddress('john@doe.com', 'John DOE');
$mailer->setSubject("The email subject");
$mailer->setBody("The HTML content");
$mailer->setAltBody("The Text content");
$mailer->send();
```

## Methods {#methods}

### setFrom() {#methods-setFrom}

Override sender address email from the Mailer configuration.

`$mailer->setFrom(string $address[, string $name])`

address
: Sender email address.

name
: Sender name.

### addAddress() {#methods-addAddress}

Add a recipients email address

`$mailer->addAddress(string $address[, string $name])`

address
: Recipient email address.

name
: Recipient name.

### addReplyTo() {#methods-addReplyTo}

Add a Reply-To email address

`$mailer->addReplyTo(string $address[, string $name])`

address
: Recipient email address.

name
: Recipient name.

### addCC() {#methods-addCC}

Add a recipient email address for a copy

`$mailer->addCC(string $address[, string $name])`

address
: Recipient email address.

name
: Recipient name.

### addBCC() {#methods-addBCC}

Add a recipient email address for a blinded copy

`$mailer->addBCC(string $address[, string $name])`

address
: Recipient email address.

name
: Recipient name.

### addAttachment() {#methods-addAttachment}

Add an attachment file

`$mailer->addAttachment(string $file[, string $name])`

file
: Attachement file path.

name
: Optional attachement file name.

### setSubject() {#methods-setSubject}

Set the email subject

`$mailer->setSubject(string $subject)`

subject
: the email subject.

### setParams() {#methods-setParams}

Set the email subject

`$mailer->setParams(array $params)`

params
: Array of parameters rendered in views.

### setBody() {#methods-setBody}

Set the HTML content has a text

`$mailer->setBody(string $content)`

content
: HTML content text.

### setBodyTemplate() {#methods-setBodyTemplate}

Set the HTML content has a template

`$mailer->setBodyTemplate(string $template)`

template
: Path of the HTML content template.

### setAltBody() {#methods-setAltBody}

Set the HTML content has a text

`$mailer->setAltBody(string $content)`

content
: Text content text.

### setAltBodyTemplate() {#methods-setAltBodyTemplate}

Set the Text content has a template

`$mailer->setAltBodyTemplate(string $template)`

template
: Path of the Text content template.

### send() {#methods-send}

Send the email

`$mailer->send()`