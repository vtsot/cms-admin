# fix-migrations run: fix-all-migrations (with_skill)

Task: "fix code style inside migrations, use the Version20261022154456.php as example"
Sandbox: `var/tmp-skill-eval/fix-all-migrations/with_skill/migrations/` was used as `migrations/`. The real `migrations/` folder was not touched, and nothing was committed.

## Steps / commands

1. Read `.claude/skills/fix-migrations/SKILL.md` and the reference `Version20261022154456.php`.
2. Reformatted the generated SQL:
   `python3 .claude/skills/fix-migrations/scripts/format_migrations.py var/tmp-skill-eval/fix-all-migrations/with_skill/migrations`
   Result: exit 0, 92 statements reformatted, nothing reported as "left unchanged":
   - Version20261022154442.php: 46
   - Version20261022161055.php: 6
   - Version20261022164933.php: 2
   - Version20261022170704.php: 4
   - Version20261022230520.php: 2
   - Version20261022231451.php: 12
   - Version20261022232453.php: 2
   - Version20261024174542.php: 6
   - Version20261025090949.php: 4
   - Version20261025101847.php: 8
   - Version20261022154456.php: 0 (already hand-written, multi-line)
3. Normalized PHP indentation:
   `docker compose exec -T php-fpm sh -c 'PHP_CS_FIXER_IGNORE_ENV=1 php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php --path-mode=override --using-cache=no var/tmp-skill-eval/fix-all-migrations/with_skill/migrations'`
   Result: fixed 1 of 11 files, Version20261022154456.php (the `/** @lang MySQL */` marker and the parameter arrays moved in one level, under `$this->addSql(`).
4. Checks:
   - `docker compose exec -T php-fpm php -l <file>` for all 11 files: "No syntax errors detected" every time.
   - `format_migrations.py --check <sandbox>`: "nothing to reformat", exit 0.
   - No single-line `addSql('...')` calls are left (grep count 0 in every file).
   - Diff against a copy of the original inputs: 11 files changed, 803 insertions(+), 102 deletions(-).

## Hand formatting

None was needed. The script handled every statement (CREATE TABLE, ALTER TABLE, DROP, indexes, and so on), and the only non-generated SQL (INSERT/DELETE in Version20261022154456.php) was already hand-formatted.

## Left as is

- Class docblocks, `getDescription()`, the auto-generated comments and literal values (for example `DEFAULT \'main\'`).
- The SQL text inside the reference file Version20261022154456.php. Only php-cs-fixer changed its PHP indentation; its SQL body keeps its original indentation.
