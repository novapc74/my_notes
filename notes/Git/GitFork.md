
### Поддержание GitHub репозитория в актуальном состоянии
После создания форка, ваш репозиторий будет существовать независимо от оригинального репозитория. В частности, при появлении в оригинальном репозитории новых коммитов GitHub информирует вас следующим сообщением:
```angular2html
This branch is 5 commits behind progit:master.
```
При этом GitHub никогда не обновляет ваш репозиторий — это вы должны делать сами. К счастью, это очень просто сделать.
Первый способ не требует конфигурации. Например, если вы сделали форк репозитория https://github.com/progit/progit2.git, то актуализировать ветку master можно следующим образом:
```angular2html
$ git checkout master (1)
$ git pull https://github.com/progit/progit2.git (2)
$ git push origin master (3)
```
Если вы находитесь на другой ветке — перейти на ветку master.
Получить изменения из репозитория https://github.com/progit/progit2.git и слить их с веткой master.
Отправить локальную ветку master в ваш форк origin.
Каждый раз писать URL репозитория для получения изменений достаточно утомительно. Этот процесс можно автоматизировать слегка изменив настройки:
```angular2html
$ git remote add progit https://github.com/progit/progit2.git (1)
$ git fetch progit (2)
$ git branch --set-upstream-to=progit/master master (3)
$ git config --local remote.pushDefault origin (4)
```
Добавить исходный репозиторий как удалённый и назвать его progit.
Получить ветки репозитория progit, в частности ветку master.
Настроить локальную ветку master на получение изменений из репозитория progit.
Установить origin как репозиторий по умолчанию для отправки.
После этого, процесс обновления становится гораздо проще:
```angular2html
$ git checkout master (1)
$ git pull (2)
$ git push (3)
```
Если вы находитесь на другой ветке — перейти на ветку master.
Получить изменения из репозитория progit и слить их с веткой master.
Отправить локальную ветку master в ваш форк origin.

Данный подход не лишён недостатков. Git будет молча выполнять указанные действия и не предупредит вас в случае, когда вы добавили коммит в master, получили изменения из progit и отправили всё вместе в origin — все эти операции абсолютно корректны. Поэтому вам стоит исключить прямое добавление коммитов в ветку master, поскольку эта ветка фактически принадлежит другому репозиторию.