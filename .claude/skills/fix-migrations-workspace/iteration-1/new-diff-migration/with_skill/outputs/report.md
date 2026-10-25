# fix-migrations: new-diff-migration (with_skill)

Target (sandbox stand-in for `migrations/`): `var/tmp-skill-eval/new-diff-migration/with_skill/migrations/2026/Version20261026080000.php`.
Only this file was touched; the real `migrations/` folder is unchanged (`git diff --stat -- migrations` is empty). Nothing committed.

## What was done
All 10 `addSql()` statements (5 in `up()`, 5 in `down()`) were reformatted by the bundled script into the project style:
multi-line `addSql(` with `/** @lang MySQL */ '`, backticked identifiers, one column/index/clause per line,
aligned column names in `CREATE TABLE`. Shapes covered: CREATE TABLE, ALTER TABLE (ADD CONSTRAINT, ADD/CHANGE/DROP INDEX,
DROP FOREIGN KEY, RENAME INDEX, DROP column, ADD INDEX), CREATE INDEX, DROP INDEX ... ON, DROP TABLE.
Nothing needed hand-formatting. Class docblock, empty `getDescription()`, auto-generated comments and the
`\'permanent\'` literal were left as they were.

## Commands and results
1. `python3 .claude/skills/fix-migrations/scripts/format_migrations.py var/tmp-skill-eval/new-diff-migration/with_skill/migrations/2026/Version20261026080000.php`
   -> `10 statement(s) reformatted`, exit 0 (nothing left unchanged).
2. `docker compose exec -T php-fpm sh -c 'PHP_CS_FIXER_IGNORE_ENV=1 php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php --path-mode=override --using-cache=no var/tmp-skill-eval/new-diff-migration/with_skill/migrations'`
   -> `Fixed 0 of 1 files`, exit 0 (script output already matched cs-fixer style; diff before/after empty).
3. `docker compose exec -T php-fpm php -l var/tmp-skill-eval/.../Version20261026080000.php` -> `No syntax errors detected`.
4. `python3 .claude/skills/fix-migrations/scripts/format_migrations.py --check <file>` -> `nothing to reformat`, exit 0.
5. `git status --short` -> only pre-existing untracked `.claude/` and `var/tmp-skill-eval/`; `git diff --stat -- migrations` -> empty.
