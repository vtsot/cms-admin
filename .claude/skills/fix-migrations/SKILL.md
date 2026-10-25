---
name: fix-migrations
description: Fix the code style of Doctrine migrations in this project (migrations/**/Version*.php) so they look like the hand-formatted references migrations/2026/Version20261022154442.php (generated DDL) and Version20261022154456.php (hand-written data SQL) — every addSql() split over several lines with a /** @lang MySQL */ marker, `backticked` identifiers, one column/index/clause per line, aligned column names and index column lists, foreign keys split over lines, empty lines between blocks and calls, and Doctrine's "auto-generated" comments removed. Use it whenever the user asks to fix, clean up, format, prettify or "make readable" migrations, after generating a migration with doctrine:migrations:diff / make:migration, or when they complain that a migration is one long unreadable line — even if they don't say "code style".
---

# Fix migration code style

Doctrine generates each statement as one long line, plus a few boilerplate comments:

```php
/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261022154442 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE navigations (id BINARY(16) NOT NULL, parent_id BINARY(16) DEFAULT NULL, INDEX idx_parent_id (parent_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE navigations ADD CONSTRAINT FK_AD21D8F3727ACA70 FOREIGN KEY (parent_id) REFERENCES navigations (id) ON DELETE CASCADE');
    }
```

The project style (references: `migrations/2026/Version20261022154442.php` for generated DDL,
`migrations/2026/Version20261022154456.php` for hand-written data SQL with parameters) is:

```php
final class Version20261022154442 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
        /** @lang MySQL */ '
        CREATE TABLE `navigations` (
            `id`        BINARY(16) NOT NULL,
            `parent_id` BINARY(16) DEFAULT NULL,

            INDEX `idx_parent_id` (`parent_id`),
            UNIQUE INDEX `uniq_id` (`id`),
            PRIMARY KEY           (`id`)

        ) DEFAULT CHARACTER SET utf8mb4
        '
        );

        $this->addSql(
        /** @lang MySQL */ '
        ALTER TABLE `site_settings`
            ADD `link_active`  TINYINT DEFAULT 1 NOT NULL,
            ADD `link_page_id` BINARY(16) DEFAULT NULL
        '
        );

        $this->addSql(
        /** @lang MySQL */ '
        ALTER TABLE `navigations`
            ADD CONSTRAINT `FK_AD21D8F3727ACA70`
                FOREIGN KEY (`parent_id`)
                REFERENCES `navigations` (`id`)
                ON DELETE CASCADE
        '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
        /** @lang MySQL */ '
        DROP TABLE `navigations`
        '
        );
    }
```

The layout rules:

- `$this->addSql(`, `/** @lang MySQL */ '`, the first SQL line, the closing `'` and `);` all start at the
  **same indent**; only the parts inside a statement (columns, keys, `ALTER` clauses) go one level (4 spaces)
  deeper.
- Identifiers (tables, columns, indexes, constraints) in backticks, keywords in upper case.
- `CREATE TABLE`: one column per line with the names padded so the types line up, an **empty line**, then the
  indexes/keys one per line with `INDEX `name`` / `UNIQUE INDEX `name`` / `PRIMARY KEY` padded so their
  `(column list)`s line up, another **empty line**, then `) <table options>`.
- `ALTER TABLE <table>` on its own line, each clause (`ADD`/`DROP`/`CHANGE`/...) on its own deeper line. When
  one statement adds (or modifies) several columns, pad `ADD `column`` so the types line up, like in
  `CREATE TABLE`. A foreign key is split further: `ADD CONSTRAINT <name>`, then `FOREIGN KEY (...)`,
  `REFERENCES ... (...)` and each `ON DELETE` / `ON UPDATE` on their own lines, one level deeper than the clause.
- With parameters, the closing quote is followed by a comma (`',`) and the parameter array starts on the next
  line at the same indent, its entries one level deeper and their `=>` aligned (see
  `Version20261022154456.php`).
- One **empty line between consecutive `$this->addSql(...)` calls**.
- Empty lines inside the SQL string are really empty (no trailing spaces).
- Doctrine's boilerplate comments go: the `Auto-generated Migration: Please modify to your needs!` class
  docblock and the `// this up()/down() migration is auto-generated, ...` lines.

The `/** @lang MySQL */` marker makes PhpStorm highlight and check the SQL, and the backticks keep
identifiers that are MySQL keywords (`field`, `position`, ...) safe.

## Scope

By default fix **every** file in `migrations/` (including already-executed migrations — only whitespace,
backticks and the generated comments change, the SQL stays the same). If the user names files, only fix those.

Leave everything else in the files as it is: `getDescription()` (even when it returns `''`), comments that a
person wrote, literal values, parameter arrays. The user wants the formatting changed, not the content.

## Steps

1. **Reformat the generated SQL** with the bundled script (run on the host from the project root; it
   only needs Python 3):

   ```bash
   python3 .claude/skills/fix-migrations/scripts/format_migrations.py            # all of migrations/
   python3 .claude/skills/fix-migrations/scripts/format_migrations.py migrations/2026/Version20261025101847.php
   ```

   It rewrites single-line `$this->addSql('...');` calls, adds the empty line between calls and removes the
   generated comments; hand-written multi-line SQL keeps its layout, so it is safe to run repeatedly. It
   understands what Doctrine generates for MySQL: `CREATE TABLE`, `ALTER TABLE` (`ADD`/`DROP`/`CHANGE`/
   `MODIFY`/`RENAME` clauses, constraints and indexes), `DROP TABLE`, `CREATE INDEX`, `DROP INDEX`,
   `RENAME TABLE`. Each rewritten statement is checked to contain exactly the original tokens plus backticks;
   otherwise it is left alone. `--check` reports without writing (exit 1 if something would change).

2. **Handle what the script reported as "left unchanged"** (exit code 2). Those are statements it doesn't
   recognise (e.g. `INSERT`/`UPDATE` data migrations, `SET FOREIGN_KEY_CHECKS`). Format them by hand with the
   layout rules above, looking at `Version20261022154456.php` for data SQL: backticks around table and column
   names, keywords in upper case, one logical part per line (`SET` assignments one per line and aligned,
   `WHERE` on its own line). Keep string literals and the escaping (`\'`) exactly as they are, and don't change
   what the SQL does.

   Also look over calls that were **already multi-line** before the script ran (hand-written SQL, often with a
   parameter array): the script leaves them alone, so fix their indentation by hand where it breaks the rules
   (closing `',` or parameter array not at the call's indent, misaligned `=>`).

3. **Check** the result:

   ```bash
   for f in $(git diff --name-only -- migrations); do docker compose exec -T php-fpm php -l "$f"; done
   python3 .claude/skills/fix-migrations/scripts/format_migrations.py --check   # → nothing to reformat
   git diff --stat -- migrations
   ```

   Don't run php-cs-fixer on migrations: its indentation fixer re-indents the marker and the SQL, which
   breaks the layout above, and the project's `.php-cs-fixer.php` only covers `src/` anyway.

4. **Report** which files changed and how many statements were reformatted, anything you formatted by hand,
   and anything you left as it was and why. Don't commit unless the user asks.

## Notes

- The script reads and writes files on the host; `php -l` runs in the `php-fpm` container
  (the project is mounted at `/var/www/html`).
- If Doctrine starts generating a statement shape the script doesn't know, extend `fmt_statement()` /
  `fmt_alter_clause()` in `scripts/format_migrations.py` rather than formatting many statements by hand.
