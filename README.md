<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->

- [Purpose](#purpose)
- [Codebase](#codebase)
- [Pantheon](#pantheon)
- [External resources](#external-resources)
- [Local dev setup using Lando](#local-dev-setup-using-lando)
  - [(Step 1) Install Lando and Docker Desktop](#step-1-install-lando-and-docker-desktop)
  - [(Step 2) Git clone the repo](#step-2-git-clone-the-repo)
  - [(Step 3) Git config](#step-3-git-config)
  - [(Step 4) Configure /etc/hosts](#step-4-configure-etchosts)
  - [(Step 5) Lando start](#step-5-lando-start)
  - [(Step 6) Lando pull](#step-6-lando-pull)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

# Purpose

Wordpress website for the EPIC 2022 Conference (http://2022.epicpeople.org/).

# Codebase

The site is hosted on Pantheon. Out of the box Pantheon provides its own Git repo but it has a very limited UI, so we prefer GitHub. 
In order to use GitHub we have to make some modifications to our project `.git/config` as detailed below.
In order to keep the two repos in sync, we have have to `git checkout master; git pull; git push;` after merging a Pull Request on GitHub.

# Pantheon

This site is hosted on Pantheon. Pantheon provides a Dashboard from which you can manage deploys, create database backups etc.

**Pantheon Dashboard:** https://dashboard.pantheon.io/sites/9de1bfe7-5dde-4061-bac8-45399d9f7d2b#dev/code


# External resources

* Confluence: https://helloworlddevs.atlassian.net/l/c/bzp2ksAZ
* Slack channels:
  * #private-epic-conference
  * #private-epic-people  
* Pantheon dashboard: https://dashboard.pantheon.io/sites/9de1bfe7-5dde-4061-bac8-45399d9f7d2b#dev/code
* Pantheon environments:
  * Dev: https://dev-epic-people-2022.pantheonsite.io/
  * Test: https://test-epic-people-2022.pantheonsite.io/
  * Prod/Live: https://live-epic-people-2022.pantheonsite.io/ or https://2022.epicpeople.org



# Local dev setup using Lando

## (Step 1) Install Lando and Docker Desktop

Follow the recommended instructions for installing Lando if you haven't already. Docker Desktop will be installed as well.

https://docs.lando.dev/basics/installation.html#macos


## (Step 2) Git clone the repo

`git clone` the GitHub repo into whichever directory you prefer.

`cd` into the repo/project root.


## (Step 3) Git config

Modify your `.git/config` to match the following, replacing any existing remotes or `master` branch. This is an attempt to keep the Pantheon and GitHub repos in sync.

```
[checkout]
    defaultRemote = github
[remote "github"]
    url = git@github.com:HelloWorldDevs/epic-people-conf-2022.git
    fetch = +refs/heads/*:refs/remotes/github/*
    pushurl = git@github.com:HelloWorldDevs/epic-people-conf-2022.git
    pushurl = ssh://codeserver.dev.9de1bfe7-5dde-4061-bac8-45399d9f7d2b@codeserver.dev.9de1bfe7-5dde-4061-bac8-45399d9f7d2b.drush.in:2222/~/repository.git
[remote "pantheon"]
    url = ssh://codeserver.dev.9de1bfe7-5dde-4061-bac8-45399d9f7d2b@codeserver.dev.9de1bfe7-5dde-4061-bac8-45399d9f7d2b.drush.in:2222/~/repository.git
    fetch = +refs/heads/*:refs/remotes/pantheon/*
    pushurl = git@github.com:HelloWorldDevs/epic-people-conf-2022.git
    pushurl = ssh://codeserver.dev.9de1bfe7-5dde-4061-bac8-45399d9f7d2b@codeserver.dev.9de1bfe7-5dde-4061-bac8-45399d9f7d2b.drush.in:2222/~/repository.git
[branch "master"]
    remote = github
    merge = refs/heads/master
    rebase = true
```

## (Step 4) Configure /etc/hosts

Edit `/etc/hosts` on your local machine. Add this line:

```
127.0.0.1				epic-people-2022.lando
```

Normally Lando will create site URLs in the format *.lndo.site. Because of the proxy settings we have in `.lando.yml`, those won’t be created. Instead we’ll have this nicer URL, but the trade off is we have to add it to our `/etc/hosts` file.

## (Step 5) Lando start

Run:

```
lando start
```

The first time you run this it will take a while. Eventually you’ll be given some URLs to access the site, however they will not work yet 
because we haven’t pulled the database yet. Lando attempts to create URLs based on the 
available ports on your machine. 

The URLs that will be most reliable/consistent will be https://epic-people-2022.lando or http://epic-people-2022.lando, however you may find that they are instead https://epic-people-2022.lando:444/ or http://epic-people-2022.lando:8000/. 

Make note of whatever URLs you’re given so we can try them later.

## (Step 6) Lando pull

Run:

```
lando pull
```

* You'll be asked whether/where you want to pull code, database and files from. You can select "none" for anything you want to skip.
  * Choose "none" for code (use `git pull` instead).
  * Choose "live" for database.
  * Choose "live" for files.

# Pushing a new branch

To push a new branch, follow this format:

```
git push -u github ECS-[ticket-number]
```

# Merging PRs and deploying

See: https://helloworlddevs.atlassian.net/l/c/znurbqtt
