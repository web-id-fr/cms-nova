# CMS^ID

<a href="./LICENCE">
    <img src="https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square" alt="MIT Licence Logo" />
</a>

---

## Requirements

* PHP >= 8.2
* Laravel >= 9
* Nova >= 4
* Composer 2
* MariaDB / MySQL

## Installation

### 1. Install the package

This package can be installed as a [Composer](https://getcomposer.org/) dependency.

#### The standard way (if you are just using this package)

```bash
"repositories": [
    {
        "type": "vcs",
        "url" : "git@github.com:web-id-fr/cms-nova.git"
    }
]
```

#### the contributor way (If you want the package to live in your main project instead of in the vendor directory)

Inside your project main directory

```bash
git clone git@github.com:web-id-fr/cms-nova.git
```

Add the git repository directory in the composer repositories as follows:

```bash
    "repositories": [
        {
            "type": "path",
            "url": "./cms-nova"
        },
```

Then, for both of the standard and contributor ways,

```bash
composer require webid/cms-nova
```

### 2. Publish files
#### Case 1 : First install
```bash
php artisan vendor:publish --provider="Webid\CmsNova\CmsServiceProvider" --force
```
#### Case 2 : Second install (or after)
```bash
php artisan vendor:publish --provider="Webid\CmsNova\CmsServiceProvider"
```


### 3. Run migrations

```bash
php artisan migrate
```

### 4. Composer update

```bash
composer update
```

### 5. Link storage files

Run command `php artisan storage:link`.

### 6. Configure sitemap.xml

If you want to allow robots to access your sitemap, add this line in the `robots.txt` file :
```
Sitemap: https://www.your-domain.com/sitemap.xml
```
⚠ Replace `www.your-domain.com` by your actual website domain.

## ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) ⚠ ⚠ Do not delete existing code in nova-components !!!  ⚠ ⚠ ![#f03c15](https://placehold.it/15/f03c15/000000?text=+)

---

## Customization

### Disable robots follow
To disable the tracking of robots, you must add in the .env `DISABLE_ROBOTS_FOLLOW=true`


Edit the `helper.js` file with the form front information to display errors and the success message.
Added to `package.json` :
```bash
"dropzone": "^5.7.0",
"lang.js": "^1.1.14"
```
In the `webpack.mix` file, add the `send_form_js` file. The file is already linked in the front.
#### front-end
You can change the form frontend but DO NOT TOUCH the `submit_form` class for sending forms.

### Internationalization
Don't forget to create a service to display the languages as you need them.
Use this service into a ViewServiceProvider to share both languages and translated slugs to views.

To create the service provider, you can run :
```bash
php artisan make:provider ViewServiceProvider
```

⚠ Don't forget to add the service provider in the file `config/app.php`.

### Update email template
#### Template email in `resources/views/mail/form.blade.php`
You can change the design of the mail template but do not delete or modify the existing code! The present code allows you to display the fields of the form sent in the email.

### Add images for components

```bash
public/cms/images/components/gallery_component.png
```

---

## Extending functionalities
### Create a new component
##### 1. create Models, migration, repositories, Nova, Resource for the new component (register all elements in a Components folder)
##### 2. update `config\component.php` with the information of the new component and add the image of the component in `public/components/`
##### 3. update `App\Models\Page` with the information of the new component
##### 4. update `Services\ComponentsService.php` with the information of the new component
##### 5. update `nova-components\ComponentField` with the information of the new component

---

## Modules
### Module form
#### 1. Add in your `.env` file the `SEND_EMAIL_CONFIRMATION` key, to send or not to send a confirmation email
