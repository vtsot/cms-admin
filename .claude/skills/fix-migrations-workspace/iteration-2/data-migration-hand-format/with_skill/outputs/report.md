# fix-migrations: Version20261026090000.php

Sandbox: `var/tmp-skill-eval/data-migration-hand-format/with_skill/migrations/` stood in for `migrations/`. The real `migrations/` folder was not touched. Its `git status` is the same as at the start. Nothing was committed.

## What was done
1. Read `.claude/skills/fix-migrations/SKILL.md` and the reference `migrations/2026/Version20261022154456.php`.
2. Ran the bundled formatter on the named file only:
   `python3 .claude/skills/fix-migrations/scripts/format_migrations.py var/tmp-skill-eval/.../Version20261026090000.php`
   -> exit 2: "4 change(s) made". The 2 `ALTER TABLE site_settings ADD/DROP reply_to_email` statements were reformatted. The 4 UPDATE statements were reported as "left unchanged (unknown statement UPDATE ...)".
3. Formatted the 4 UPDATE statements by hand, following the reference:
   - `$this->addSql(` + `/** @lang MySQL */ '` at the call indent, the SQL one level deeper
   - backticked table and column names
   - `UPDATE `table`` / `SET` / one assignment per line with the `=` signs aligned / `WHERE` on its own line
   - string literals and `\'` escaping kept exactly as they were
4. Fixed the blank lines between calls. After the script ran, the blank lines were uneven: there was none between the two UPDATEs in up(), and a misplaced one in down(). Now every pair of consecutive `addSql()` calls has exactly one empty line between them.
5. getDescription(), the class docblock and all other PHP were left as they were.

## Checks
- `docker compose exec -T php-fpm php -l /var/www/html/var/tmp-skill-eval/.../Version20261026090000.php` -> "No syntax errors detected"
- `format_migrations.py --check <file>` -> "nothing to reformat" (exit 0)
- `grep -n ' $' <file>` -> no trailing whitespace
- Python comparison of all 6 SQL strings against the original file, ignoring whitespace and backticks -> identical (True, 6 statements)
- php-cs-fixer was not run, as the skill instructs.
