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

## Tabellenbeziehungen in ORM (object-relational mapping)
Beziehungen werden in Laravel in den Models erstellt. 
### 1:1-Beziehung 
Beispielsweise kann ein Bürger genau eine Passnummer haben. 
Verknüpfung im Model des Bürgers (citizen):
````php
class Citizen extends Model {
    public function pass() {
        return $this->hasOne('Pfad zum Model\pass');
}
}
````
Verknüpfung im Model Personalausweisnummer (pass):
````php
class Pass extends Model {
    public function citizen() {
        return $this->belongsTo('Pfad zum Model\citizen');
    }
````
Wichtig hierbei ist, dass man nicht zweimal hasOne nehmen darf.

### 1:N-Beziehung
Bei einer 1:N-Beziehung gibt es die Methoden "belongsTo" und "hasMany". Hier ein Beispiel aus dem Skript mit "Books" und "Publisher". Ein Buch kann nur einen Publisher haben, umgekehrt kann aber ein Publisher mehrere Bücher veröffentlichen.
Im Book-Model muss es dann wie folgt geschrieben werden:
````php
class Book extends Model {
    public function publisher() {
        return $this->belongsTo('App\Book');
    }
 }
````
Es wird also gesagt, dieses Buch hat genau einen Publisher durch die belongsTo-Methode.

Im Publisher-Model sieht es dann wie folgt aus:
````php
class Publisher extends Model {
        public function books() {
            return $this->hasMany('App\Book');
    }
 }
 ````
Wichtig ist, dass in der Migration-File der Tabelle, in der der Fremdschlüssel steht, auch eine entsprechende Spalte erstellt wird. In der Books-Migration-File muss also für den Publisher noch eine entsprechende Spalte erstellt werden:
````php
$table->unsignedBigInteger('publisher_id');
//Die publisher_id wird nun noch mit der ID aus der Tabelle Publisher verknüpft
$table->foreign('publisher_id')->references('id')->on('publisher');
```` 
Das Grundprinzip ist immer das selbe:
$table->foreign("Spaltenname")->references("Primärspalte aus zu verknüpfender Tabelle")->on("Tabellenname welche verknüpft wird");

### N:M-Beziehung
Bei N:M-Beziehungen gibt es nur eine Methode, welche in beiden Models verwendet werden muss. Sie heißt "belongsToMany".
Ein Autor kann z.B. mehrere Bücher haben, ein Buch kann aber auch gleichzeitig mehrere Autoren haben (z.B. Handbücher für Programmiersprachen). 
im Author-Model ist der Code dann wie folgt:
````php
class Author extends Model {
    public function books() {
        return $this->belongsToMany('App\Book');
````
Auf der Gegenseite im Book-Model ist der Code (fast) der selbe:
````php
class Book extends Model {
    public function authors() {
        return $this->belongsToMany('App\Author');
````
Bei N:M-Beziehungen muss man immer einen Hilfstabelle erstellen, welche die zwei Primärschlüssel entgegen nimmt. Sehr wichtig ist, dass diese Migration-File erst nach den zwei Migration-Files für die Books und die Authors ausgeführt wird!
In der Hilfstaballe werden dann diese Spalten erstellt:
````php
    $table->unsignedBigInteger('author_id');
    $table->foreign('author_id')->references('id')->on('authors');
    $table->unsignedBigInteger('books_id');
    $table->foreign('books_id')->references('id')->on('books');
````
### Beispiel einer Datenbankabfrage, welche in einem Array gespeichert wird und dann ausgegeben wird

Code in web.php
````php
Route::get('/artists', function() {
    return view('artists', ['artists'=>Artist::all()]); 
});
//Mit dem Befehl Artist::all() werden alle Artisten, die in der Tabelle gespeichert sind abgerufen und im Array gespeichert
````
Code in dem View 'artists':
````html
<ul>
@foreach($artists as $artist)
    <li>{{$artist->name}}</li>
    @endforeach
</ul>
````
Der Befehl @foreach lädt nun alle artists, die im Array gespeichert sind in die Variable $artist. Für jeden $artist wird dann der Name als Item einer Liste ausgegeben.

### Beispiel einer for-Schleife
In diesem Beispiel wird über eine for-Schleife Artists erstellt und der Name, der an der jeweilgen Stelle steht, verwendet. 
````php
 public function run()
    {
        $artists = ['Artist1', 'Artist2', 'Artist3', 'Artist4', 'Artist5', 'Artist6, 'Artist7'];
        for($i = 0; $i < count($artists); $i++) {
            factory(Artist::class)->create(["name" => $artists[$i]]);
            }
    }
````
Mit "count($artists)" wird die Anzahl der im Array gespeicherten Werte herausgefunden. Der Name wird in Verbindung mit einer Factory erstellt. Den Namen geben wir hier vor, alle anderen Daten werden aber mit einem faker erstellt (später dazu mehr).
