# Fix code style inside migrations (baseline, no skill)

(Report returned by the run; its own Write of this file was blocked.)

- Wrote its own Python formatter in the scratchpad and reformatted 10 of 11 files (reference left as is).
- Removed the generated `// this up()/down() migration is auto-generated...` comments.
- ADD CONSTRAINT: FOREIGN KEY / REFERENCES / ON DELETE on separate continuation lines.
- DROP TABLE / DROP INDEX / CREATE INDEX kept on one line inside the multi-line wrapper.
- Verified: SQL equivalent (stubbed addSql, compared whitespace/backtick-insensitive), php -l ok.
- php-cs-fixer dry run with .php-cs-fixer.dist.php (@Symfony): 11/11 "can be fixed" (wants `/* @lang */`); not applied.
