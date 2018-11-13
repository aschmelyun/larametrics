# Larametrics

[![Current Version](https://img.shields.io/packagist/v/aschmelyun/larametrics.svg?style=flat-square)](https://packagist.org/packages/aschmelyun/larametrics)
![License](https://img.shields.io/github/license/aschmelyun/larametrics.svg?style=flat-square)
[![Build Status](https://img.shields.io/travis/aschmelyun/larametrics/master.svg?style=flat-square)](https://travis-ci.org/aschmelyun/larametrics)
[![Total Downloads](https://img.shields.io/packagist/dt/aschmelyun/larametrics.svg?style=flat-square)](https://packagist.org/packages/aschmelyun/larametrics)

A self-hosted metrics and notifications platform for Laravel apps, Larametrics records and notifies you of changes made to models, incoming requests, and messages written to the log.

A full version of the docs can be found [here](https://larametrics.com/docs), below you'll find a quick 'Getting Started' guide.

![Screenshot of Larametrics Dashboard](https://i.imgur.com/IsAEsKn.png)

## Requirements
- PHP 5.6.4 or higher
- Laravel 5.2 or higher
- guzzlehttp/guzzle (if notifications enabled) 

## Installation
Larametrics is installed as a standalone package through Composer:

```bash
composer require aschmelyun/larametrics
```

After Composer finishes up, you'll have to add the following line to your `config/app.php` file if you're not on Laravel 5.5 or higher:

```php
Aschmelyun\Larametrics\LarametricsServiceProvider::class
```

Additionally, you'll want to get the config file copied over and add in the necessary database structure with:

```php
php artisan vendor:publish --provider="Aschmelyun\Larametrics\LarametricsServiceProvider"
php artisan migrate
```

**Note:** Notifications use queued jobs when available to prevent delays in app response time. If you don't have this database table set up already for queues, run `php artisan queue:table && php artisan migrate`. 

## Displaying the Dashboard

Once you have the package tied in to your Laravel app, it starts collecting data based off of the default config file and storing it in your database. In order to view the dashboard associated with Larametrics and analyse your metrics and notifications, you'll need to add in a helper method to your routes file of choice.

```php
\Aschmelyun\Larametrics\Larametrics::routes();
```

Include that where (and how) you want the dashboard to appear. For reference, all Larametrics routes are wrapped under a `/metrics` prefix, but you can adjust where you want the routes to appear.

In the following example, the Larametrics dashboard will only be viewable to people who are signed into the application, and visit `/admin/metrics`:

```php
// routes/web.php
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    \Aschmelyun\Larametrics\Larametrics::routes();
});
```

## Configuration

Configuring Larametrics for use within your Laravel app takes place mainly in the `config/larametrics.php` file. Each item is broken down in the comment lines above it, describing what that item does and what value(s) it's anticipating. 

There are also two .env variables you'll need to set depending on if you use notifications:

- **LARAMETRICS_NOTIFICATION_EMAIL**, the address that all email notifications will be routed to
- **LARAMETRICS_NOTIFICATION_SLACK_WEBHOOK**, a Slack webhook configured for receiving requests and adding messages to a specified channel. More info [here](https://get.slack.help/hc/en-us/articles/115005265063-Incoming-WebHooks-for-Slack).

## Roadmap
Larametrics is still in development, constantly being optimized and attempting to be made compatible for older Laravel versions. Here's what's on the path ahead:

- [x] Add the ability to ignore specific request paths
- [ ] Integrate Twilio for text message notifications
- [ ] Integrate Zapier for custom notifications
- [ ] Move listeners out of root directory and into their own namespace
- [ ] Optimize database querying for expired models to improve performance
- [ ] Optimize front-end for mobile devices
- [ ] Add Artisan commands for displaying Larametrics data
- [ ] Add watcher for Queues
- [ ] Add watcher for Scheduled Tasks
- [ ] Expand on the notification filter options
- [ ] Compatibility for Laravel 4.2+

## Difference to Laravel Telescope

In October 2018, Taylor Otwell announced `Laravel Telescope`, which acts as a debugging tool for Laravel applications. For a distinction between `Larametrics` and `Telescope`, please see [this discussion here](https://github.com/aschmelyun/larametrics/issues/11).

## Contact Info

Have an issue? Submit it here! Want to get in touch? Feel free to reach out to me on [Twitter](https://twitter.com/aschmelyun) for any kind of general questions or comments.

## License

The MIT License (MIT). See [LICENSE.md](https://github.com/aschmelyun/larametrics/blob/master/LICENSE.md) for more details.
