# Report: clean up code style of Version20261026090000.php (baseline, no skill)

## What was done
Edited only the sandbox copy:
`var/tmp-skill-eval/data-migration-hand-format/without_skill/migrations/2026/Version20261026090000.php`
(the real `migrations/` folder was not touched; nothing committed).

Reformatted the six one-line `addSql()` calls (3 in `up()`, 3 in `down()`) to match the
hand-written reference `migrations/2026/Version20261022154456.php`:

- every `addSql(` is split over several lines, the SQL string starts with a `/** @lang MySQL */` marker
  and sits on its own lines inside the quotes;
- all table and column identifiers are wrapped in backticks;
- `UPDATE ... SET` statements put `SET` on its own line, one assignment per line, with the `=` signs aligned;
  `WHERE` on its own line;
- `ALTER TABLE` statements put the `ADD` / `DROP` clause on its own indented line;
- a blank line between consecutive `addSql()` calls.

The SQL is unchanged apart from whitespace and backticks: string literals stay inline (escaped `\'...\'`),
no parameters were added, statement order is unchanged, and `getDescription()` stays as it was.

## Commands run and results
1. `docker compose exec -T php-fpm php -l /var/www/html/var/tmp-skill-eval/.../Version20261026090000.php`
   -> `No syntax errors detected`
2. A `php -r` script that pulls out each `addSql()` SQL string and squeezes the whitespace, as a check that the SQL means the same:
   ```
   ALTER TABLE `site_settings` ADD `reply_to_email` VARCHAR(255) DEFAULT NULL
   UPDATE `site_settings` SET `sender_name` = 'Robot', `sender_email` = 'robot@example.com' WHERE `sender_email` IS NULL
   UPDATE `pages` SET `sitemap_priority` = 0.8, `sitemap_change_frequency` = 'daily' WHERE `homepage` = 1
   UPDATE `pages` SET `sitemap_priority` = 0.5, `sitemap_change_frequency` = 'weekly' WHERE `homepage` = 1
   UPDATE `site_settings` SET `sender_name` = NULL, `sender_email` = NULL WHERE `sender_email` = 'robot@example.com'
   ALTER TABLE `site_settings` DROP `reply_to_email`
   ```
   -> these match the original statements apart from the added backticks.

No migration was run against the database.
