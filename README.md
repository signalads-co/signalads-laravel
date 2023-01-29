# Signalads Laravel

**First of all you will ned an [API Key](https://sms.signalads.com "API Key") . You can get
one [Here](https://sms.signalads.com).**

##### Supported Laravel Versions:

- V.4
- V.5
- V.6
- V.7
- V.8
- **V.9**
  > We highly recomment you to always use the latest version of laravel

# Installation

## Step 1 - Install the package

- **Method 1**:
  You can install signalads/laravel with Composer directly in your project:

```php
composer require signalads/laravel
```

- **Method 2**:
  Add this line to **Composer.json** file in your project

```php
"signalads/laravel": "*"
```

Then run following command to download extension using **composer**

```php
$ composer update
```

## Step 2

Head to **config/app.php** and add this line to the end of **providers** Array:

```php
Signalads\Laravel\ServiceProvider::class,
```

So that array must me something like this:

```php
'providers' => [
    Signalads\Laravel\ServiceProvider::class
]
```

## Step 3 - Publish

Run this command in your project dirctory:

```
php artisan vendor:publish --tag=signalads-laravel
```

## Step 4 - Api-Key

Now you must define your [API Key](https://sms.signalads.com/user/web-service/web-service-list "API Key") and Your Line
to project. for this head to **config/signalads.php** then put your API KEY in the code:

```
<?php
return [
    'apikey' => '',
    'sender' => '',
];
```

# Usage

You can use the package where ever you want.

- First use the class:

```php
use Signalads\Laravel\Facade\Signalads;
```

- Exception Handler

```php
    try {
        // call SignalAdsApi function
    }
    catch(\SignalAds\Exceptions\ApiException $e){
        // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
        echo $e->errorMessage();
    }
    catch(\SignalAds\Exceptions\HttpException $e){
        // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
        echo $e->errorMessage();
    }
```

- Send Single SMS

```php
$sender = "10004346"; //This is the Sender number

$message = "خدمات پیام کوتاه سیگنال"; //The body of SMS

$receptor = "09191234567"; //Receptors numbers

$result = Signalads::send($sender, $receptor, $message);
```
`Sample Output`

```json
{
  "data": {
    "message_id": "28561b88-8403-45b8-a114-508abdb9c436",
    "price": 120
  },
  "message": "پیام شما با موفقیت در صف ارسال قرار گرفت",
  "error": {
    "message": null,
    "errors": null
  }
}
```

- Send Multiple SMS With Same Text

```php
$sender = "10004346"; //This is the Sender number

$message = "خدمات پیام کوتاه سیگنال"; //The body of SMS

$receptors = array("09361234567","09191234567"); //Receptors numbers

$result = Signalads::sendGroup($sender, $receptors, $message);
```

`Sample Output`

```json
{
  "data": {
    "message_id": "55800454-fe52-44b3-9c44-43c87d6f29b2",
    "price": 240
  },
  "message": "پیام شما با موفقیت در صف ارسال قرار گرفت",
  "error": {
    "message": null,
    "errors": null
  }
}
```
- Send Sms With Pattern

```php
$sender = "10004346"; //This is the Sender number

$patternId = 123; 

$patternParams = ["param 1", "param 2"];

$receptors = array("09361234567","09191234567"); //Receptors numbers

$result = Signalads::sendPattern($sender, $patternId, $patternParams, $receptors);
```

`Sample Output`

```json
{
    "data": {
        "message_id": "28561b88-8403-45b8-a114-508abdb9c436"
    },
    "message": "پیام شما با موفقیت در صف ارسال قرار گرفت",
    "error": {
        "message": null,
        "errors": null
    }
}
```
- Get Message Status
  `Statuses`
```json
PENDING = 1
SENDING = 2
BLACKLIST = 3
DELIVERED = 4
NOT_DELIVERED = 5
NOT_SENDING = 6
ERROR = 7
```
```php
$messageId = 123;

$limit = 10; //optional

$offset = 0; //optional

$receptor = "09191234567"; //optional

$result = Signalads::status($messageId, $limit, $offset, $status, $receptor);
```

`Sample Output`

```json
{
  "data": {
    "items": [
      {
        "number": "09xxxxxxxxx",
        "status": 1
      },
      {
        "number": "09xxxxxxxxx",
        "status": 2
      },
      {
        "number": "09xxxxxxxxx",
        "status": 3
      },
      {
        "number": "09xxxxxxxxx",
        "status": 4
      },
      {
        "number": "09xxxxxxxxx",
        "status": 5
      },
      {
        "number": "09xxxxxxxxx",
        "status": 6
      },
      {
        "number": "09xxxxxxxxx",
        "status": 7
      }
    ],
    "count": 7,
    "sum": 0
  },
  "message": null,
  "error": {
    "message": null,
    "errors": null
  }
}
```

- Get account credit

```php
$result = Signalads::getCredit();
```
`Sample Output`

```json
{
  "data": {
    "credit": 12345
  },
  "message": null,
  "error": {
    "message": null,
    "errors": null
  }
}
```

# Usage in Notifications

create your notification:

```
php artisan make:notification SendOtp
```

extend your notification from SignaladsNotification:

```php
class SendOtp extends SignaladsNotification
{

}
```

overide the toSignalads function:

```php
class SendOtp extends SignaladsNotification
{

   public function __construct(Otp $otp)
   {
       $this->otp = $otp;
   }

    public function toSignalads($notifiable)
    {
        return (new SignaladsMessage("your verify code is $otp->code"))
            ->from('10004346');
    }
}
```

you should add Notifiable trait and routeNotificationForSignalads method in your model

```php
class Otp extends Model
{
    use Notifiable;

    public function routeNotificationForSignalads($driver, $notification = null)
    {
        return $this->number;
    }

}
```

- Send With Pattern

```php
class SendWithPattern extends SignaladsBaseNotification
{
    public function toSignalads(mixed $notifiable): SignaladsMessage
    {
        return (new SignaladsMessage(''))
            ->patternId(123412341234)
            ->patternParams([1,2])
            ->sendMethod(SignalSendMethods::sendPattern);
    }
}
```

- Send Group

```php
class SendWithPattern extends SignaladsBaseNotification
{
    public function toSignalads(mixed $notifiable): SignaladsMessage
    {
        return (new SignaladsMessage('پیام تست'))
            ->to(["09191234567", "09191234567"])
            ->sendMethod(SignalSendMethods::sendGroup);
    }
}
```

### اطالاعات بیشتر

برای مطالعه بیشتر به صفحه معرفی
[وب سرویس اس ام اس ](https://document.signalads.com/)
سیگنال
مراجعه نمایید .

درصورت مشاهده هرگونه اشکال در کارکرد پکیج میتوانید درخواست pull request کنید یا با ایمیل support@signalads.com با ما در ارتباط باشید.

## </div>

[https://signalads.com](http://signalads.com)
