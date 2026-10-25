# fix-migrations: Version20261026090000.php (data migration, hand format)

Sandbox file: `var/tmp-skill-eval/data-migration-hand-format/with_skill/migrations/2026/Version20261026090000.php` (real `migrations/` untouched, nothing committed).

## What was done
1. Ran the bundled formatter:
   `python3 .claude/skills/fix-migrations/scripts/format_migrations.py <file>`
   - Result: exit 2. 2 statements reformatted (`ALTER TABLE site_settings ADD reply_to_email ...` in up(), `ALTER TABLE site_settings DROP reply_to_email` in down()).
   - 4 left unchanged (unknown statement `UPDATE`): lines 23, 24, 29, 30.
2. Hand-formatted the 4 `UPDATE` statements in the reference style (`Version20261022154456.php`):
   `addSql(` / `/** @lang MySQL */ '` / SQL / `'` / `);`, backticked table and column names,
   `UPDATE` table, `SET` on its own line, one aligned assignment per line, `WHERE` on its own line.
   String literals and `\'` escaping kept exactly; SQL semantics unchanged.
3. php-cs-fixer:
   `docker compose exec -T php-fpm sh -c 'PHP_CS_FIXER_IGNORE_ENV=1 php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php --path-mode=override --using-cache=no <file>'`
   - Result: "Fixed 0 of 1 files" (layout already compliant). Only a deprecation notice about PHP_CS_FIXER_IGNORE_ENV.
4. Checks:
   - `docker compose exec -T php-fpm php -l <file>` -> No syntax errors detected
   - `format_migrations.py --check <file>` -> "nothing to reformat", exit 0
   - `git status --short` -> only pre-existing untracked `.claude/` and `var/tmp-skill-eval/`; no tracked files changed.

## Unchanged
Class docblock, `getDescription()`, values and statement order.
