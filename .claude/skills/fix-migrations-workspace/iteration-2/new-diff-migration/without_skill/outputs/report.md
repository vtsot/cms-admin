# Reformat Version20261026080000.php (baseline, no skill)

## What I did
- Read the real `migrations/2026/` for reference. Almost all of them are raw diff output; the only hand-formatted one is
  `Version20261022154456.php`. I used it as the house style: `$this->addSql(` on its own line, then `/** @lang MySQL */ '`,
  multi-line SQL with `backticked` identifiers, aligned columns, and the closing `'` / `);` on their own lines.
- Rewrote all 10 `addSql()` calls in the sandbox copy
  `var/tmp-skill-eval/new-diff-migration/without_skill/migrations/2026/Version20261026080000.php`:
  - CREATE TABLE `site_redirects`: one column per line, names and types aligned; one index/PK per line.
  - ALTER TABLE statements: one clause per line (ADD / CHANGE / DROP INDEX / ADD CONSTRAINT ... FOREIGN KEY ... ON DELETE).
  - Short statements (CREATE/DROP INDEX, DROP TABLE) go in the same multi-line wrapper.
  - Took out the "this up()/down() migration is auto-generated" comments and filled in `getDescription()`.
- The SQL itself is unchanged: same statements, same order, same `\'permanent\'` escaping.
- The real `migrations/` folder was not modified, and nothing was committed.

## Commands and results
1. `docker compose exec -T php-fpm php -l /var/www/html/var/tmp-skill-eval/new-diff-migration/without_skill/migrations/2026/Version20261026080000.php`
   -> `No syntax errors detected`
2. Check that the SQL is equivalent: a temporary PHP script, deleted afterwards, built the migration with an in-memory sqlite DBAL
   connection and called `up()` + `down()`. It collected `getSql()`, stripped backticks and whitespace, and compared the result
   with the 10 original diff statements.
   `docker compose exec -T php-fpm php .../chk/chk.php` -> `bool(true)` (all 10 statements identical).
3. `git status --short migrations` -> empty (the real migrations are untouched).
