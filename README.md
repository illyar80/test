# test
## Тестовое задание

### 1) Command line:
- Write a one-line command that displays the first 20 characters of a user's ssh public key:
```sh
$ cut -d " " -f2  .ssh/my_key.pub | cut -b 1-20
```
- Write a one-line command that checks the syntax of all php files in the current folder:
```sh
$ for i in *.php; do php -l $i; done
```


### 2) Git:
- Write a git command that displays the hash of the current revision:
```sh
$ git log -1 --pretty=format:"%H"
```
- Write a git command that displays the code changes of the last 5 commits for the file index.php (in the current folder)

```sh
$ git log -p -5 composer.json
```

### 3) PHP
- See file index.php
