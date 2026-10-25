# fix-migrations — fix-all-migrations (with_skill, iteration 2)

Task: "fix code style inside migrations, use the Version20261022154456.php as example".
Sandbox `var/tmp-skill-eval/fix-all-migrations/with_skill/migrations/` was treated as `migrations/`. The real `migrations/` folder was not touched and nothing was committed.

## What I did
1. Read `.claude/skills/fix-migrations/SKILL.md` and followed its steps.
2. Backed up the sandbox originals to the session scratchpad so I could diff against them.
3. Ran the bundled formatter on the sandbox folder:
   `python3 .claude/skills/fix-migrations/scripts/format_migrations.py var/tmp-skill-eval/fix-all-migrations/with_skill/migrations`
   Exit code 0, no statements reported as "left unchanged". Changes made per file:
   - Version20261022154442.php: 90
   - Version20261022161055.php: 10
   - Version20261022164933.php: 2
   - Version20261022170704.php: 6
   - Version20261022230520.php: 2
   - Version20261022231451.php: 22
   - Version20261022232453.php: 2
   - Version20261024174542.php: 10
   - Version20261025090949.php: 6
   - Version20261025101847.php: 14
   - Version20261022154456.php: 0 (the hand-written reference, already in the target style)
   ("changes" counts both reformatted addSql() calls and the empty lines added between calls.)
4. Hand formatting: none was needed, because the script recognised every statement.

## Checks
- `grep -rn "addSql('"` on the sandbox: no single-line addSql() calls left.
- `docker compose exec -T php-fpm php -l /var/www/html/<file>` for all 11 files: "No syntax errors detected" for each.
- `format_migrations.py --check <sandbox>`: "nothing to reformat", exit 0.
- Compared each sandbox file with the already-formatted real `migrations/2026/` file: 0 differing lines in all 11 files.
- `git status migrations`: same as at session start (nothing changed in the real folder).
- php-cs-fixer was not run, as the skill instructs.

## Left as is
The class docblocks, `getDescription()`, the "auto-generated" comments and the literal values were not changed. The SQL itself was not changed either: the script checks each statement token by token.
