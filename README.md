```markdown
# Laravel Project - People and Contacts Manager

This Laravel project is a simple system to manage **people** and their **phone contacts**, following Laravel's best practices and naming conventions.

## Setup Instructions

### Database Setup

1. Run migrations:
```bash
php artisan migrate
```

2. Run seeders:
```bash
php artisan db:seed
# Or to run a specific seeder:
php artisan db:seed --class=UserSeeder
```

### Available Seeders

- `UserSeeder`: Creates initial admin/user accounts (if implemented)
- You can create additional seeders for sample people/contacts data

## General Structure

### Models

- **Person**: Represents a person with the fields `id`, `name`, and `email`.
- **Contact**: Represents a phone contact linked to a person, with the fields `id`, `person_id`, `country_code`, and `number`.

### Controllers

- **PersonController**: Handles actions related to the `Person` entity.
- **ContactController**: Handles actions related to the `Contact` entity.

### Migrations

- Table names follow Laravel conventions:
  - `people` table for Person model
  - `contacts` table for Contact model

### Relationships

- A person (`Person`) **has many** contacts (`Contact`).
- A contact (`Contact`) **belongs to one** person (`Person`).

## Application Routes

### Public Routes

| Method | URI | Name | Action |
|--------|-----|------|--------|
| GET | `/` | `people.index` | `PersonController@index` |

### Authenticated Routes

#### People Routes

| Method | URI | Name | Action |
|--------|-----|------|--------|
| GET | `people/create` | `people.create` | `PersonController@create` |
| POST | `people` | `people.store` | `PersonController@store` |
| GET | `people/{person}` | `people.show` | `PersonController@show` |
| GET | `people/{person}/edit` | `people.edit` | `PersonController@edit` |
| PUT | `people/{person}` | `people.update` | `PersonController@update` |
| DELETE | `people/{person}` | `people.destroy` | `PersonController@destroy` |

#### Contact Routes

| Method | URI | Name | Action |
|--------|-----|------|--------|
| GET | `people/{person}/contacts/create` | `contacts.create` | `ContactController@create` |
| POST | `people/{person}/contacts` | `contacts.store` | `ContactController@store` |
| GET | `contacts/{contact}/edit` | `contacts.edit` | `ContactController@edit` |
| PUT | `contacts/{contact}` | `contacts.update` | `ContactController@update` |
| DELETE | `contacts/{contact}` | `contacts.destroy` | `ContactController@destroy` |

## Validations

- `name`: must be at least **6 characters long**
- `email`: must be a **valid and unique email address**
- `number`: must contain **exactly 9 numeric digits**
- `country_code`: must be a valid value, usually obtained from an external API


## External APIs Integration

The project uses two external APIs with fallback mechanisms:

### 1. Avatar Generation API

**Initial API Attempt:**
```php
https://app.pixelencounter.com/api/basic/monsters/random
```
**Issue:** Frequently returned 404 (Not Found) errors

**Implemented Solution:**
```php
$encodedName = urlencode($name);
return "https://ui-avatars.com/api/?background=random&name={$encodedName}";
```

### 2. Countries Data API

**Primary API:**
```php
https://restcountries.com/v3.1/all?fields=name,idd
```
**Challenges:**
- Occasional slow response times
- Unreliable availability

**Implemented Fallback Solution:**
```php
try {
    $response = Http::timeout(5)->get('https://restcountries.com/v3.1/all?fields=name,idd');
    
    if ($response->successful()) {
        $countries = $response->json();
    } else {
        throw new \Exception('API did not respond with success');
    }
} catch (\Exception $e) {
    $json = Storage::get('data/countries.json');
    $countries = json_decode($json, true);
}
```

**Fallback Strategy:**
1. Attempt to fetch from REST Countries API with 5-second timeout
2. If API fails or times out, use local `countries.json` backup
3. Process and format the data consistently regardless of source
