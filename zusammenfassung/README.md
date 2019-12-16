# WebDev II Zusammenfassung

## Artisan Kommandos

### Model erstellen

Erstellt ein Model, je nachdem ob das Flag `-m` mitgegeben worden wurde mit oder ohne Migration.

```bash
php artisan make:model Book -m
```

### Controller erstellen

Erstellt einen Controller, je nachdem ob das Flag `-r` mitgegeben worden wurde, wird dieser als Resource-Controller erstellt.

```bash
php artisan make:controller BookController -r
```

## Models

Models repräsentieren unsere Tabellen in der Datenbank aus objektorientierter Sicht.

# Model erstellen

```php
Book::create([
    "name" => "Harry Potter und der Stein der Weisen",
    "author" => "J.K. Rowling",
    "isbn" => "3551557411",
]);
```

## Resource Controller Methoden / CRUD / BREAD

Name | Resource-Controller Methode | HTTP-Methode | PFAD | Beschreibung
--- | --- | --- | --- | ---
Browse | index | GET | /books | Zeigt alle Resourcen an (Teil der REST-Konvention)
Read | show | GET | /books/{id} | Zeigt eine Resource mit der angegebenen ID (Teil der REST-Konvention)
Edit | update | PUT/PATCH | /books/{id} | Editieren einzelner oder aller Daten einer bereits bestehenden Resource (Teil der REST-Konvention)
Add | store | POST | /books | Erstellen einer Resource (Teil der REST-Konvention)
Delete | destroy | DELETE | /books/{id} | Löschen einer Resource (Teil der REST-Konvention)
- | create | GET | /books/create | Formular zum erstellen von der Resource (Laravel spezifisch 🐠)
- | edit | GET | /books/{id}/edit | Formular zum editieren einer Resource (Laravel spezifisch 🐠)

## Laravel Namenskonventionen

Was | Wie | Beispiel
------------ | ------------- | -------------
Controller | singular | ArticleController 
Route | plural | books/1
Named route | snake_case with dot notation | users.show_active
Model | singular | User
hasOne or belongsTo relationship | singular | articleComment
All other relationships | plural | articleComments
Table | plural | article_comments
Pivot table | singular model names in alphabetical order | article_user
Table column | snake_case without model name | meta_title
Model property | snake_case | $model->created_at
Foreign key | Model Name im singular mit _id suffix | author_id
Migration | snake_case_mit_datum_und_uhrzeit | 2017_01_01_000000_create_articles_table
Method | camelCase | getAll
Method in resource controller | [table](https://laravel.com/docs/master/controllers#resource-controllers) | store
Method in test class | camelCase | testGuestCannotSeeArticle
Variable | camelCase | $articlesWithAuthor
Collection | descriptive, plural | $activeUsers = User::active()->get()
Object | descriptive, singular | $activeUser = User::active()->first()
Config and language files index | snake_case | articles_enabled
View | kebab-case | show-filtered.blade.php
Config | snake_case | google_calendar.php
Contract (interface) | adjective or noun | Authenticatable
Trait | adjective | Notifiable
