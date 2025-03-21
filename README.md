# Contelizer recruitment task
Zadania zostały rozdzielone w katalogach.

## Zadanie nr 1.
Dodaj w głównym folderze plik "input.txt" z określoną treścią w pliku

Uruchom komendę ``` php run.php ```

W rezultacie utworzy sie plik "output.php"

## Zadanie nr 2.
Uruchom komendę ``` php run.php ``` z argumentem

Przykład:
``` php run.php 11111111111 ```

## Zadanie nr 3.
### Informacje techniczne dla zadania nr 3:
PHP: 8.2
Symfony: 5.4
Docker: 27.3.1

### Przygotowanie projektu
Aby uruchomić projekt, wykonaj poniższe kroki:
1. Skopiuj plik docker-compose.override.yml.dist, tworząc na jego podstawie docker-compose.override.yml.
2. W pliku docker-compose.override.yml ustaw swoje własne porty.
3. Dodaj do pliku .env klucz API do GOREST_API_KEY
4. Wykonaj następujące polecenia:
```
docker network create contelizer-project
```

```
docker compose build
```

```
docker compose up -d
```
```
docker compose exec -it contelizer-php bash
composer install
npm run dev
```
