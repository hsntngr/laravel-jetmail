# laravel-jetmail
Laravel ile jetmail apisi üzerinden mail gönderin. 

```php
JetMail::to('test@example.com')
    ->send(new Welcome('Teoman'));
```

# Kurulum
Laravel 5.6 ve öncesi sürümler için `config/app.php` dosyasında providers bölümü içine
aşağıda jet mail service provider sınıfını ekleyin.

```php
'providers' => [
   //...
   Hsntngr\JetMail\JetMailServiceProvider::class,
   //...
]
```

Sonrasında config dosyasını publish edin. 

```php
php artisan vendor:publish --provider="Hsntngr\JetMail\JetMailServiceProvider" --tag=config
```

Api bilgilerinizi `config/jetmail.php` içerisinde düzenleyin.

```php
'from' => [
    'address' => 'laravel@posta.jetmail.com.tr',
    'name' => 'Laravel',
],

'auth' => [
    'token' => 'jetmailtarafındanverilentoken',
    'username' => 'hsntngr'
],
```
# Kullanım

Bu kütüphaneyi kullanarak artisan komutu jetmail oluşturabilir ve gönderebileceğiniz gibi, laravelin kendi mail yapısı oluşturduğunuz mailleri de gönderebilirbisiniz.

`make:jetmail` artisan komutunu kullanarak JetMail oluşturabilirsiniz. Oluşturulan mailler `app/Mail` dizini altında yer almaktadır.

```php
php artisan make:jetmail Welcome
```

Oluşturulan mailin `build` metodunu kullanarak mail bilgilerini girebilirsiniz.

```php
public function build()
   {
      return $this
          ->replyTo('test@example.com')
          ->subject('Hoşgeldin ' . $this->user)
          ->view('email.welcome');
   }
```

Daha sonra oluşturduğunuz bu mesajları JetMail facadesini kullanarak gönderebilirsiniz.

```php
use App\Mail\Welcome;
use Hsntngr\JetMail\Facade\JetMail;


JetMail::send(new Welcome('Teoman'))
```

Alıcı parametresi build metodu içerisinde düzenlenmek zorunda değildir.
JetMail facadesi üzerinden düzenlenebilir. Mail içerisinde girilen numara varsa bu numara da alıcılar arasına dahil edilir.

```php
JetMail::to('test@example.com')
    ->send(new Welcome('Teoman'))
```

Mail göndermek için JetMail sınıfı oluşturmak zorunlu değildir. Laravel ile oluşturduğunuz mailleri jet mail olarak gönderebilirsiniz.