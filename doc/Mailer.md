# Mailer

- [Configuration](#configuration)
- [Example](#example)
- [Methods](#methods)
    - Bridge
        - [getTransport()](#methods-getTransport)
        - [getAuth()](#methods-getAuth)
        - [getTls()](#methods-getTls)
        - [getHost()](#methods-getHost)
        - [getUsername()](#methods-getUsername)
        - [getPassword()](#methods-getPassword)
        - [getPort()](#methods-getPort)
        - [getSender()](#methods-getSender)
        - [getSender_address()](#methods-getSender_address)
        - [getSender_name()](#methods-getSender_name)
        - [getNoreply()](#methods-getNoreply)
    - Mailer class
        - Sender
            - [setFrom()](#methods-setFrom)
        - Recipients
            - [addAddress()](#methods-addAddress)
            - [addReplyTo()](#methods-addReplyTo)
            - [addCC()](#methods-addCC)
            - [addBCC()](#methods-addBCC)
        - Attachement
            - [addAttachment()](#methods-addAttachment)
        - Subject
            - [setSubject()](#methods-setSubject)
        - Content
            - [setParams()](#methods-setParams)
            - [setBody()](#methods-setBody)
            - [setBodyTemplate()](#methods-setBodyTemplate)
            - [setAltBody()](#methods-setAltBody)
            - [setAltBodyTemplate()](#methods-setAltBodyTemplate)
        - Sending
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
|`sender_address`|`string`|""|Defaut sender email.|
|`sender_name`|`string`|""|Default sender name.|
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

### Bridge Methods

#### getTransport() {#methods-getTransport}

```php
agetApp()->mailer()->getTransport();
```

#### getAuth() {#methods-getAuth}

```php
agetApp()->mailer()->getAuth();
```

#### getTls() {#methods-getTls}

```php
agetApp()->mailer()->getTls();
```

#### getHost() {#methods-getHost}

```php
agetApp()->mailer()->getHost();
```

#### getUsername() {#methods-getUsername}

```php
agetApp()->mailer()->getUsername();
```

#### getPassword() {#methods-getPassword}

```php
agetApp()->mailer()->getPassword();
```

#### getPort() {#methods-getPort}

```php
agetApp()->mailer()->getPort();
```

#### getSender() {#methods-getSender}

```php
agetApp()->mailer()->getSender();
```

#### getSender_address() {#methods-getSender_address}

```php
agetApp()->mailer()->getSender_address();
```

#### getSender_name() {#methods-getSender_name}

```php
agetApp()->mailer()->getSender_name();
```

#### getNoreply() {#methods-getNoreply}

```php
agetApp()->mailer()->getNoreply();
```


### Mailer Class

#### setFrom() {#methods-setFrom}

Override sender address email from the Mailer configuration.

```php
$mailer->setFrom(string $address[, string $name])
```

address
: Sender email address.

name
: Sender name.

#### addAddress() {#methods-addAddress}

Add a recipients email address

```php
$mailer->addAddress(string $address[, string $name])
```

address
: Recipient email address.

name
: Recipient name.

#### addReplyTo() {#methods-addReplyTo}

Add a Reply-To email address

```php
$mailer->addReplyTo(string $address[, string $name])
```

address
: Recipient email address.

name
: Recipient name.

#### addCC() {#methods-addCC}

Add a recipient email address for a copy

```php
$mailer->addCC(string $address[, string $name])
```

address
: Recipient email address.

name
: Recipient name.

#### addBCC() {#methods-addBCC}

Add a recipient email address for a blinded copy

```php
$mailer->addBCC(string $address[, string $name])
```

address
: Recipient email address.

name
: Recipient name.

#### addAttachment() {#methods-addAttachment}

Add an attachment file

```php
$mailer->addAttachment(string $file[, string $name])
```

file
: Attachement file path.

name
: Optional attachement file name.

#### setSubject() {#methods-setSubject}

Set the email subject

```php
$mailer->setSubject(string $subject)
```

subject
: the email subject.

#### setParams() {#methods-setParams}

Set the email subject

```php
$mailer->setParams(array $params)
```

params
: Array of parameters rendered in views.

#### setBody() {#methods-setBody}

Set the HTML content has a text

```php
$mailer->setBody(string $content)
```

content
: HTML content text.

#### setBodyTemplate() {#methods-setBodyTemplate}

Set the HTML content has a template

```php
$mailer->setBodyTemplate(string $template)
```

template
: Path of the HTML content template.

#### setAltBody() {#methods-setAltBody}

Set the HTML content has a text

```php
$mailer->setAltBody(string $content)
```

content
: Text content text.

#### setAltBodyTemplate() {#methods-setAltBodyTemplate}

Set the Text content has a template

```php
$mailer->setAltBodyTemplate(string $template)
```

template
: Path of the Text content template.

#### send() {#methods-send}

Send the email

```php
$mailer->send()
```