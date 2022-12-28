# Signalads Laravel

**First of all you will ned an [API Key](http://panel.signalads.com "API Key") . You can get one [Here](https://panel.signalads.com/Client/Membership/Register).**

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
"signalads/php": "*"
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
		/*
		* Laravel Framework Service Providers...
		*/
		.
		.
		.
		Signalads\Laravel\ServiceProvider::class
]
```

Then in the **config/app.php** and add this line to the end of **aliases** Array:

```php
'Signalads' => Signalads\Laravel\Facade::class,
```

## Step 3 - Publish

Run this command in your project dirctory:

```
php artisan vendor:publish
```

In the message appear, find the number of Signalads, enter the related number then hit Enter. for Example in the below case you must enter **9** then enter:

```bash
Which provider or tag files would you like to publish?:
[0 ] Publish files from all providers and tags listed below
[1 ] Provider: Facade\Ignition\IgnitionServiceProvider
[2 ] Provider: Fideloper\Proxy\TrustedProxyServiceProvider
[3 ] Provider: Fruitcake\Cors\CorsServiceProvider
[4 ] Provider: Illuminate\Foundation\Providers\FoundationServiceProvider
[5 ] Provider: Illuminate\Mail\MailServiceProvider
[6 ] Provider: Illuminate\Notifications\NotificationServiceProvider
[7 ] Provider: Illuminate\Pagination\PaginationServiceProvider
**_ [8 ] Provider: Signalads\Laravel\ServiceProviderLaravel9_**
.
.
.
```

## Step 4 - Api-Key

Now you must define your [API Key](http://panel.signalads.com/client/setting/account "API Key") to project. for this head to **config/signalads.php** then put your API KEY in the code:

```
<?php
return [
    'apikey' => ' ',
];
```

### All Set

# Usage

You can use the package where ever you want.

- First use the class:

```php
use Signalads;
```

Then use this pattern to send SMS:

```php
try{
    $sender = "10004346";		//This is the Sender number

    $message = "خدمات پیام کوتاه کاوه نگار";		//The body of SMS

    $receptor = array("09361234567","09191234567");			//Receptors numbers

    $result = Signalads::Send($sender,$receptor,$message);
    if($result){
        foreach($result as $r){
            echo "messageid = $r->messageid";
            echo "message = $r->message";
            echo "status = $r->status";
            echo "statustext = $r->statustext";
            echo "sender = $r->sender";
            echo "receptor = $r->receptor";
            echo "date = $r->date";
            echo "cost = $r->cost";
        }
    }
}
catch(\Signalads\Exceptions\ApiException $e){
    // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
    echo $e->errorMessage();
}
catch(\Signalads\Exceptions\HttpException $e){
    // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
    echo $e->errorMessage();
}
```

Use this pattern to send VerifyLookup SMS:

```php
try{
    $receptor = "09123456789";
    $token = "123";
    $token2 = "456";
    $token3 = "789";
    $template="verify";
    //Send null for tokens not defined in the template
    //Pass token10 and token20 as parameter 6th and 7th
    $result = Signalads::VerifyLookup($receptor, $token, $token2, $token3, $template, $type = null);
    if($result){
        foreach($result as $r){
            echo "messageid = $r->messageid";
            echo "message = $r->message";
            echo "status = $r->status";
            echo "statustext = $r->statustext";
            echo "sender = $r->sender";
            echo "receptor = $r->receptor";
            echo "date = $r->date";
            echo "cost = $r->cost";
        }
    }
}
catch(\Signalads\Exceptions\ApiException $e){
    // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
    echo $e->errorMessage();
}
catch(\Signalads\Exceptions\HttpException $e){
    // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
    echo $e->errorMessage();
}
```

You can find all the **Error handlings** and **API parameters** and **Usage methods** in the [KaveNegar](https://signalads.com) website.

# Usage in Notifications

Also you can use KavengarChannel for your notification:

create your notification:

```
php artisan make:notification InvoicePaid
```

extend your notification from SignaladsBaseNotification:

```php
class InvoicePaid extends SignaladsBaseNotification
{

}
```

overide the toKavengar function:

```php
class InvoicePaid extends SignaladsBaseNotification
{

   public function __construct(Invoice $invoice)
   {
       $this->invoice = $invoice;
   }

    public function toSignalads($notifiable)
    {
        return (new SignaladsMessage("فاکتور شما به شماره $invoice->id پرداخت شد."))->from('10004346');
    }
}
```

you should add Notifiable trait and routeNotificationForSignalads method in your model

```php
class User extends Authenticatable
{
    use Notifiable;

    public function routeNotificationForSignalads($driver, $notification = null)
    {
        return $this->mobile;
    }

}
```

** _Notice: IF you DO NOT add routeNotificationForSignalads in your notifiable model then you should set your receiver in your notification :_ **

```php
class InvoicePaid extends SignaladsBaseNotification
{

    public function toSignalads($notifiable)
    {
        return (new SignaladsMessage('فاکتور شما به شماره ۱۲۳۴ پرداخت شد.'))->from('10004346')->to('092100000');
    }
}
```

for send verify lookup message you should use verifyLookup method for set method name and tokens:

```php
class InvoicePaid extends SignaladsBaseNotification
{

    public function toSignalads($notifiable)
    {
        return (new SignaladsMessage())
            ->verifyLookup('verify_first',['token1','token2']);
    }
}
```

## Contribution

Bug fixes, docs, and enhancements welcome! Please let us know [support@signalads.com](mailto:support@signalads.com?Subject=SDK)

<div  dir="rtl">
## راهنما

### معرفی سرویس کاوه نگار

کاوه نگار یک وب سرویس ارسال و دریافت پیامک و تماس صوتی است که به راحتی میتوانید از آن استفاده نمایید.

### ساخت حساب کاربری

اگر در وب سرویس کاوه نگار عضو نیستید میتوانید از [لینک عضویت](http://panel.signalads.com/client/membership/register) ثبت نام و اکانت آزمایشی برای تست API دریافت نمایید.

### مستندات

برای مشاهده اطلاعات کامل مستندات [وب سرویس پیامک](http://signalads.com/وب-سرویس-پیامک.html) به صفحه [مستندات وب سرویس](http://signalads.com/rest.html) مراجعه نمایید.

### راهنمای فارسی

در صورتی که مایل هستید راهنمای فارسی کیت توسعه کاوه نگار را مطالعه کنید به صفحه [کد ارسال پیامک](http://signalads.com/sdk.html) مراجعه نمایید.

### اطالاعات بیشتر

برای مطالعه بیشتر به صفحه معرفی
[وب سرویس اس ام اس ](http://signalads.com)
کاوه نگار
مراجعه نمایید .

اگر در استفاده از کیت های سرویس کاوه نگار مشکلی یا پیشنهادی داشتید ما را با یک Pull Request یا ارسال ایمیل به support@signalads.com خوشحال کنید.

## </div>

[http://signalads.com](http://signalads.com)
