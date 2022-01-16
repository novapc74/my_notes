### Start
```
$ sudo apt update
$ sudo apt install git-all
```
Ищем более новую версию
```
$ sudo apt install software-properties-common
$ sudo add-apt-repository ppa:git-core/ppa
$ sudo apt update
$ sudo apt install git
```
Выполняется из любой директории
```
$ git config --global user.name "<имя фамилия>"
$ git config --global user.email "<ваш емейл>"
```
Создание ssh-ключей
```
$ ssh-keygen -t rsa -b 4096 -C "your_email@example.com"
$ eval "$(ssh-agent -s)"
$ ssh-add ~/.ssh/id_rsa
$ cat ~/.ssh/id_rsa.pub /* копируем и добавляем в Settings -> Secrets -> New repository secret */
```
Инициализация репозитория
```
$ git init
$ echo 'New project started!' > README.md
$ git commit -m 'add README.md'

$ git branch -M main
$ git remote add origin git@github.com:novapc74/HexletHomeWork.git
$ git push -u origin main

$ git clone git@github.com:novapc74/HexletHomeWork.git
    or
$ git pull --rebase
```
### Use
```
/* равносильно rm + git add */
$ git rm PEOPLE.md
```
Разница
```
$ git diff
$ git log -p /* все коммиты с полным дифом */
$ git show 3119c457cd284a0dde1ebcc795e472dc6291a1d0 /* выводится диф между этим коммитом и предыдущим */
$ git blame README.md /* выводит файл и кто менял */
```
Поиск
```
$ git grep line
INFO.md:new line
```
```
# Флаг i позволяет искать без учета регистра
$ git grep -i hexlet
README.md:Hello, Hexlet! How are you?
```
```
# Поиск в конкретном коммите
$ git grep Hexlet 5120bea3
```
```
# Поиск по всей истории
# rev-list возвращает список хешей коммитов
$ git grep hexlet $(git rev-list --all)
```
Удаление пустых файлов и директорий
```
$ git clean -fd
```
Отмена отправленного коммита
```
$ git revert aa600a43cb164408e4ad87d216bc679d097f1a6c
```
Удаление не отправленного коммита
```
$ git reset --hard HEAD~  /* HEAD~2 - удаляет два посмледних коммита */
```
Добавление в последний коммит новго файла
```
git add README.md
$ git commit --amend --no-edit
```
Перемещение по истории
```
$ git log --oneline
$ git log --graph
```
```
$ git checkout e6f625c
$ git checkout main
$ git branch /*где я */
```
### .gitignore
```
access.log       /* игнорируется файл в любой директории проекта */
node_modules     /* игнорируется директория в любой директории проекта */
/coverage        /* игнорируется директория в корне git-репозитория */
/db/*.sqlite3    /* игнорируются все файлы с расширением sqlite3 в директории db,
                    но не игнорируются такие же файлы внутри любого вложенного каталога в db
                    например, /db/something/lala.sqlite3 */
doc/**/*.txt     /* игнорировать все .txt файлы в каталоге doc/
                    на всех уровнях вложенности */
```
### Stash/Pop
```
hexlet-git$ git stash       /* прячем файлы. После этой команды пропадут все изменённые файлы
                            независимо от того, добавлены они в индекс или нет */
hexlet-git$ git stash pop   /* восстанавливаем */
```
