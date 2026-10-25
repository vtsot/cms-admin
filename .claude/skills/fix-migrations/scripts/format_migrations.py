#!/usr/bin/env python3
"""Reformat Doctrine-generated one-line addSql() calls into the project's migration style.

    $this->addSql('CREATE TABLE t (id INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');

becomes

    $this->addSql(
    /** @lang MySQL */ '
    CREATE TABLE `t` (
        `id` INT NOT NULL,

        PRIMARY KEY (`id`)

    ) DEFAULT CHARACTER SET utf8mb4
    '
    );

Only single-line `$this->addSql('...');` calls without parameters are rewritten; anything already
multi-line or hand-written keeps its layout. Statements the parser does not recognise are left unchanged
and reported. Every rewritten statement is checked to have the same tokens as the original
(ignoring the added backticks), so the SQL meaning cannot change.
Consecutive addSql() calls (rewritten or not) are separated by one empty line, and the comments
Doctrine's generator adds ("Auto-generated Migration..." docblock, "this up() migration is
auto-generated..." lines) are removed.

Usage:
    format_migrations.py [--check] [FILE_OR_DIR ...]     (default: migrations/)
Exit code: 0 = ok / nothing to do, 1 = --check found files to reformat, 2 = unrecognised statements.
"""

from __future__ import annotations

import argparse
import re
import sys
from dataclasses import dataclass
from pathlib import Path

CALL_RE = re.compile(r"^(?P<ind>[ \t]*)\$this->addSql\('(?P<sql>(?:[^'\\]|\\.)*)'\);[ \t]*$", re.M)
# the end of one addSql() call directly followed by the next one (single-line or multi-line)
BETWEEN_CALLS_RE = re.compile(r"^([ \t]*(?:\$this->addSql\(.*)?\);)[ \t]*\n(?=[ \t]*\$this->addSql\()", re.M)
GENERATED_DOCBLOCK_RE = re.compile(r"^/\*\*\n \* Auto-generated Migration: Please modify to your needs!\n \*/\n(?=(?:final )?class )", re.M)
GENERATED_HINT_RE = re.compile(r"^[ \t]*// this (?:up|down)\(\) migration is auto-generated, please modify it to your needs\n", re.M)
TOKEN_RE = re.compile(
    r"(?P<ws>\s*)(?:(?P<str>'(?:[^'\\]|\\.|'')*')|(?P<bt>`[^`]*`)|(?P<num>\d+(?:\.\d+)?)"
    r"|(?P<word>[A-Za-z_$][A-Za-z0-9_$]*)|(?P<punct><=|>=|<>|!=|[(),;=.:*<>+\-/%?]))"
)
SQL_INDENT = '    '


class Unsupported(Exception):
    pass


@dataclass
class Tok:
    ws: str
    text: str
    kind: str  # str | bt | num | word | punct

    @property
    def up(self) -> str:
        return self.text.upper()


def tokenize(sql: str) -> list[Tok]:
    toks, pos = [], 0
    while pos < len(sql):
        if sql[pos:].strip() == '':
            break
        m = TOKEN_RE.match(sql, pos)
        if not m or m.end() == pos:
            raise Unsupported(f'cannot tokenize near: {sql[pos:pos + 30]!r}')
        kind = next(k for k in ('str', 'bt', 'num', 'word', 'punct') if m.group(k) is not None)
        toks.append(Tok(m.group('ws'), m.group(kind), kind))
        pos = m.end()

    return toks


def quote(t: Tok) -> Tok:
    if t.kind == 'word':
        return Tok(t.ws, f'`{t.text}`', 'bt')
    if t.kind == 'bt':
        return t
    raise Unsupported(f'expected an identifier, got {t.text!r}')


def render(toks: list[Tok]) -> str:
    return ''.join(t.ws + t.text for t in toks).strip()


def matching_paren(toks: list[Tok], start: int) -> int:
    depth = 0
    for i in range(start, len(toks)):
        if toks[i].text == '(':
            depth += 1
        elif toks[i].text == ')':
            depth -= 1
            if depth == 0:
                return i
    raise Unsupported('unbalanced parentheses')


def split_top(toks: list[Tok]) -> list[list[Tok]]:
    """Split on commas outside parentheses."""
    parts, cur, depth = [], [], 0
    for t in toks:
        if t.text == '(':
            depth += 1
        elif t.text == ')':
            depth -= 1
        if t.text == ',' and depth == 0:
            parts.append(cur)
            cur = []
        else:
            cur.append(t)
    parts.append(cur)

    return [p for p in parts if p]


def quote_column_list(toks: list[Tok], start: int) -> int:
    """Quote identifiers of a `(a, b)` list starting at toks[start] == '('; returns index of ')'."""
    if toks[start].text != '(':
        raise Unsupported('expected (')
    end = matching_paren(toks, start)
    depth = 0
    for i in range(start, end + 1):
        if toks[i].text == '(':
            depth += 1
        elif toks[i].text == ')':
            depth -= 1
        elif depth == 1 and toks[i].kind == 'word' and toks[i].up not in ('ASC', 'DESC'):
            toks[i] = quote(toks[i])

    return end


def words(toks: list[Tok], n: int) -> list[str]:
    return [t.up for t in toks[:n]]


def fmt_constraint_tail(toks: list[Tok], i: int) -> None:
    """Quote `name (cols)` / `(cols)` / `REFERENCES t (cols)` parts from toks[i] on, in place."""
    while i < len(toks):
        t = toks[i]
        if t.text == '(':
            i = quote_column_list(toks, i) + 1
        elif t.up == 'REFERENCES':
            toks[i + 1] = quote(toks[i + 1])
            i += 2
        elif t.up in ('ON', 'DELETE', 'UPDATE', 'CASCADE', 'SET', 'NULL', 'RESTRICT', 'NO', 'ACTION'):
            i += 1
        elif t.up in ('USING', 'BTREE', 'HASH'):
            i += 1
        else:
            raise Unsupported(f'unexpected {t.text!r} in constraint')


def fmt_table_element(toks: list[Tok]) -> tuple[list[Tok], bool]:
    """A CREATE TABLE element or ALTER ADD target. Returns (tokens, is_column)."""
    w = words(toks, 3)
    if w[:2] == ['PRIMARY', 'KEY']:
        fmt_constraint_tail(toks, 2)
        return toks, False
    if w[:1] in (['INDEX'], ['KEY']) or w[:2] in (['UNIQUE', 'INDEX'], ['UNIQUE', 'KEY'], ['FULLTEXT', 'INDEX'], ['SPATIAL', 'INDEX']):
        n = 1 if w[0] in ('INDEX', 'KEY') else 2
        if toks[n].text != '(':
            toks[n] = quote(toks[n])
            n += 1
        fmt_constraint_tail(toks, n)
        return toks, False
    if w[:1] == ['CONSTRAINT']:
        toks[1] = quote(toks[1])
        if words(toks[2:], 2) != ['FOREIGN', 'KEY'] and words(toks[2:], 1) not in (['UNIQUE'], ['PRIMARY'], ['CHECK']):
            raise Unsupported('unknown CONSTRAINT form')
        if toks[2].up == 'CHECK':
            return toks, False
        fmt_constraint_tail(toks, 4 if toks[2].up in ('FOREIGN', 'PRIMARY') else 3)
        return toks, False
    if w[:2] == ['FOREIGN', 'KEY']:
        fmt_constraint_tail(toks, 2)
        return toks, False
    # column definition: name + type and options (type part is kept verbatim)
    toks[0] = quote(toks[0])
    return toks, True


def fmt_create_table(toks: list[Tok]) -> str:
    i = 2
    if words(toks[i:], 3) == ['IF', 'NOT', 'EXISTS']:
        i += 3
    toks[i] = quote(toks[i])
    open_i = i + 1
    if toks[open_i].text != '(':
        raise Unsupported('CREATE TABLE without column list')
    close_i = matching_paren(toks, open_i)

    elements = [fmt_table_element(list(e)) for e in split_top(toks[open_i + 1:close_i])]
    width = max((len(e[0].text) for e, is_col in elements if is_col), default=0)
    columns, key_parts = [], []
    for e, is_col in elements:
        if is_col:
            columns.append(SQL_INDENT + e[0].text.ljust(width) + ' ' + render(e[1:]))
        else:
            # split "UNIQUE INDEX `name`" from "(`cols`) ..." so the column lists line up
            paren = next((i for i, t in enumerate(e) if t.text == '('), None)
            key_parts.append((render(e[:paren]), render(e[paren:])) if paren else (render(e), ''))
    key_width = max((len(head) for head, cols in key_parts if cols), default=0)
    keys = [SQL_INDENT + (head.ljust(key_width) + ' ' + cols if cols else head) for head, cols in key_parts]

    head = render(toks[:open_i]) + ' ('
    tail = ')' + (' ' + render(toks[close_i + 1:]) if close_i + 1 < len(toks) else '')
    # columns, an empty line, indexes/keys, an empty line, the closing parenthesis
    body = ',\n\n'.join(',\n'.join(group) for group in (columns, keys) if group)

    return head + '\n' + body + '\n\n' + tail


def fmt_alter_clause(c: list[Tok]) -> str:
    w = words(c, 3)
    if w[0] == 'ADD':
        rest = c[2:] if w[1] == 'COLUMN' else c[1:]
        elem, _ = fmt_table_element(list(rest))
        toks = c[:len(c) - len(rest)] + elem
        if w[1] == 'CONSTRAINT' and any(t.up == 'FOREIGN' for t in toks):
            return fmt_foreign_key(toks)
        return render(toks)
    if w[0] == 'DROP':
        if w[1:3] == ['FOREIGN', 'KEY']:
            c[3] = quote(c[3])
        elif w[1] in ('INDEX', 'KEY'):
            c[2] = quote(c[2])
        elif w[1:3] == ['PRIMARY', 'KEY']:
            pass
        elif w[1] == 'COLUMN':
            c[2] = quote(c[2])
        elif len(c) == 2:
            c[1] = quote(c[1])
        else:
            raise Unsupported('unknown DROP clause')
        return render(c)
    if w[0] == 'CHANGE':
        i = 2 if w[1] == 'COLUMN' else 1
        c[i], c[i + 1] = quote(c[i]), quote(c[i + 1])
        return render(c)
    if w[0] == 'MODIFY':
        i = 2 if w[1] == 'COLUMN' else 1
        c[i] = quote(c[i])
        return render(c)
    if w[0] == 'RENAME':
        if w[1] in ('INDEX', 'KEY', 'COLUMN') and c[3].up == 'TO':
            c[2], c[4] = quote(c[2]), quote(c[4])
        elif w[1] == 'TO':
            c[2] = quote(c[2])
        else:
            raise Unsupported('unknown RENAME clause')
        return render(c)
    raise Unsupported(f'unknown ALTER clause {c[0].text!r}')


def fmt_foreign_key(toks: list[Tok]) -> str:
    """ADD CONSTRAINT `name` / FOREIGN KEY (...) / REFERENCES t (...) / ON DELETE ... / ON UPDATE ..., one per line."""
    parts: list[list[Tok]] = [[]]
    for i, t in enumerate(toks):
        starts_part = t.up in ('FOREIGN', 'REFERENCES') or (
            t.up == 'ON' and i + 1 < len(toks) and toks[i + 1].up in ('DELETE', 'UPDATE')
        )
        if starts_part and parts[-1]:
            parts.append([])
        parts[-1].append(t)

    return render(parts[0]) + ''.join('\n' + SQL_INDENT + render(p) for p in parts[1:])


def fmt_alter_table(toks: list[Tok]) -> str:
    toks[2] = quote(toks[2])
    clauses = [fmt_alter_clause(list(c)) for c in split_top(toks[3:])]

    # several ADD/MODIFY column clauses: pad the column names so the types line up
    column_clause = re.compile(r'^((?:ADD|MODIFY)(?: COLUMN)? `[^`]+`) (.*)$', re.S)
    matches = [column_clause.match(c) for c in clauses]
    if sum(1 for m in matches if m) > 1:
        width = max(len(m.group(1)) for m in matches if m)
        clauses = [m.group(1).ljust(width) + ' ' + m.group(2) if m else c for c, m in zip(clauses, matches)]

    indented = ['\n'.join(SQL_INDENT + line for line in c.split('\n')) for c in clauses]

    return render(toks[:3]) + '\n' + ',\n'.join(indented)


def fmt_statement(sql: str) -> str:
    toks = tokenize(sql)
    original = [t.text for t in toks]
    w = words(toks, 4)

    if w[:2] == ['CREATE', 'TABLE']:
        out = fmt_create_table(toks)
    elif w[:2] == ['ALTER', 'TABLE']:
        out = fmt_alter_table(toks)
    elif w[:2] == ['DROP', 'TABLE']:
        i = 4 if w[2:4] == ['IF', 'EXISTS'] else 2
        toks[i] = quote(toks[i])
        out = render(toks)
    elif w[:2] == ['CREATE', 'INDEX'] or w[:3] in (['CREATE', 'UNIQUE', 'INDEX'], ['CREATE', 'FULLTEXT', 'INDEX']):
        n = 2 if w[1] == 'INDEX' else 3
        toks[n] = quote(toks[n])
        if toks[n + 1].up != 'ON':
            raise Unsupported('CREATE INDEX without ON')
        toks[n + 2] = quote(toks[n + 2])
        quote_column_list(toks, n + 3)
        out = render(toks)
    elif w[:2] == ['DROP', 'INDEX'] and toks[3].up == 'ON':
        toks[2], toks[4] = quote(toks[2]), quote(toks[4])
        out = render(toks)
    elif w[:2] == ['RENAME', 'TABLE'] and toks[3].up == 'TO':
        toks[2], toks[4] = quote(toks[2]), quote(toks[4])
        out = render(toks)
    else:
        raise Unsupported(f'unknown statement {" ".join(w[:2])}')

    # safety net: same tokens as before, apart from the backticks we added
    after = [t.text.strip('`') if t.kind == 'bt' else t.text for t in tokenize(out)]
    if after != [t.strip('`') if t.startswith('`') else t for t in original]:
        raise Unsupported('reformatted statement does not match the original tokens')

    return out


def php_unescape(s: str) -> str:
    return re.sub(r"\\([\\'])", r'\1', s)


def php_escape(s: str) -> str:
    return s.replace('\\', '\\\\').replace("'", "\\'")


def fix_file(path: Path, problems: list[str]) -> tuple[str, int]:
    src = path.read_text()
    changed = 0

    def repl(m: re.Match) -> str:
        nonlocal changed
        ind, sql = m.group('ind'), php_unescape(m.group('sql'))
        try:
            formatted = fmt_statement(sql)
        except Unsupported as e:
            line = src.count('\n', 0, m.start()) + 1
            problems.append(f'{path}:{line}: left unchanged ({e})')
            return m.group(0)
        changed += 1
        body = '\n'.join(ind + line if line else '' for line in php_escape(formatted).split('\n'))
        return (
            f'{ind}$this->addSql(\n'
            f"{ind}/** @lang MySQL */ '\n"
            f'{body}\n'
            f"{ind}'\n"
            f'{ind});'
        )

    new = CALL_RE.sub(repl, src)

    # drop the comments Doctrine's generator adds (the class docblock and the up()/down() hints)
    new, n_doc = GENERATED_DOCBLOCK_RE.subn('', new)
    new, n_hint = GENERATED_HINT_RE.subn('', new)
    changed += n_doc + n_hint

    # one empty line between consecutive addSql() calls
    # (lookahead, so a call that ends one gap can start the next one)
    new, gaps = BETWEEN_CALLS_RE.subn(r'\1\n\n', new)

    return new, changed + gaps


def main() -> int:
    ap = argparse.ArgumentParser(description=__doc__, formatter_class=argparse.RawDescriptionHelpFormatter)
    ap.add_argument('--check', action='store_true', help='only report, do not write')
    ap.add_argument('paths', nargs='*', default=['migrations'])
    args = ap.parse_args()

    files: list[Path] = []
    for p in map(Path, args.paths):
        files += sorted(p.rglob('*.php')) if p.is_dir() else [p]

    problems: list[str] = []
    total = 0
    for f in files:
        new, changed = fix_file(f, problems)
        if changed:
            total += changed
            print(f'{f}: {changed} change(s) {"to make" if args.check else "made"}')
            if not args.check:
                f.write_text(new)

    for p in problems:
        print(p, file=sys.stderr)
    if not total and not problems:
        print('nothing to reformat')

    if problems:
        return 2

    return 1 if args.check and total else 0


if __name__ == '__main__':
    sys.exit(main())
