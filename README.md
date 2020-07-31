# Steps to setup the projects

### Installation

```sh
$ git clone https://github.com/Jalpesh009/github-tracker.git
$ cd github-tracker
$ composer install
$ cp .env.example .env - (copy env files).
# Setup database configartion
$ php artisan migrate
$ nmp install
$ nmp run dev
$ php artisan serve
```
Put your github access token, username, password into the .env file.
```sh
GITHUB_ACCESS_TOKEN=
GITHUB_USERNAME=
GITHUB_PASS=
```
Goto : [http://127.0.0.1:8000]

# Work flow
  - Register new user and login with that
  - Goto home using navigation link
  - You will see you github all repository, there you clone existing or create new using forms
  - When you clone the repo you can edit or changes in the repo (All the cloned repo in storage folder)..
  - After changes view all the changes using view button. Also, you can see your changed files listing and push with any message
  - All the commite and repo log save into the database as well.
  

License
----
MIT
