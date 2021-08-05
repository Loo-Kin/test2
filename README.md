# test2

Лукин Александр, 2021

---

## Тестовое задание №1

### Функция, рекурсивно выводящая иерархию на страницу.

В приложенном файле (json.json) находится пример структуры расположения роликов в иерархическом виде в формате JSON. 

Подразумевается, что файл может меняться и соответственно, вложенность может быть неограниченной.

пример вывода дерева:

```
+Ознакомление с программой
+Создание адресного списка
+Индивидуальные счетчики
+Групповые счетчики
-Создание группового счетчика
-Создание группового счетчика2
-Установка индивидуального счетчика
```

где [ + ] это папка (`isFolder=true`),
[ - ] это элемент, который в папке. 

---

## Тестовое задание №2

Сервис (rest api), осуществляющий следующие действия:
1.	Получение списка записей из БД (например, название книги с именем автора)
2.	Поиск книг по автору, названию, году произведения (один или несколько параметров)
3.	Добавление записи (новой книги)
4.	Обновление записи о книге
5.	Удаление записи книги из БД

PHP7+

БД MySQL или MariaDB
