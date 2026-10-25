# new-diff-migration (iteration 3, with skill)

- Formatter: "21 change(s) made", exit 0; nothing left for hand formatting.
- FK split into ADD CONSTRAINT / FOREIGN KEY / REFERENCES / ON DELETE; generated docblock and up()/down() comments removed; empty lines between calls and around the CREATE TABLE index block.
- php -l: no syntax errors; --check: nothing to reformat; no trailing spaces.
