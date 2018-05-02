PHP AJAX Confessions Script by Leo Coding

![1](https://i.imgur.com/a2f40cc.png)


## INSTALLATION INSTRUCTIONS

```
- Place all of these files to folder where you want to install​ Confessions script
- Get your database connection data ready ​
- Open URL where files are located, it should redirect you to Installer right away (if not, installer is located here yoursite.com/install/install.php)​
- RECOMMENDED: DELETE INSTALL FOLDER WHEN YOU FINISH INSTALLATION!​​
```

## Requirements

```
- PHP
- MySQL
- Shared hosting & domain​
```

## Translating

If you want to translate Confessions to your language you just need to edit 2 files:

```
assets/js/lang_strings.js​ & includes/lang_strings.php​
```

### Facebook share buton

For Facebook sharing to work perfectly you need an "APP ID" to specify in: **assets/js/share.js**
You will find this:

```
var appid = "";
```

Just add "APP ID" within "" like this:

```
var appid = "123456789";
```

### Activate Google reCaptcha: 

edit file: **includes/rc_setting.php**

Follow instructions in the file

### Google Analytics 

Edit file: **includes/ganalytics.php**

### Admin Panel - Deleting Confessions

As of 1.9 we made deleting confessions much easier.
Visit /administration
and authenticate with credentials 

user: admin
pass: iloveu

To change credentials edit "administration/login.php" file

**Live Demo:** http://www.codester.com/index.php?url=items/preview/3749/confessions-php-script

[Changelog](https://github.com/RomaniukVadim/confessions_script/blob/master/CHANGELOG.txt)

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests to us.

## Authors

* **Vadim Romaniuk** - *Initial work* - [glicOne](https://github.com/RomaniukVadim)

See also the list of [contributors](https://github.com/RomaniukVadim/confessions_script/contributors) who participated in this project.

## License

This project is licensed under the Do What The F*ck You Want To Public License - see the [LICENSE.md](LICENSE.md) file for details