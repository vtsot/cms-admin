#!/usr/bin/env python3
"""Grade fix-migrations eval runs: grade.py <iteration-dir>. Writes grading.json into each run dir."""

import json
import re
import subprocess
import sys
from pathlib import Path

PROJECT = Path('/home/vitaly/workspace/www/vacancy-grabber/cms-admin.local')
EVALS = PROJECT / '.claude/skills/fix-migrations/evals'
sys.path.insert(0, str(PROJECT / '.claude/skills/fix-migrations/scripts'))
from format_migrations import tokenize  # noqa: E402

CALL_ANY = re.compile(r"\$this->addSql\(\s*(?:/\*\*?\s*@lang\s+MySQL\s*\*/\s*)?'((?:[^'\\]|\\.)*)'(?P<args>[^;]*?)\);", re.S)
ONE_LINE = re.compile(r"^[ \t]*\$this->addSql\('.*'\);[ \t]*$", re.M)


def unescape(s):
    return re.sub(r"\\([\\'])", r'\1', s)


def sql_tokens(src):
    out = []
    for m in CALL_ANY.finditer(src):
        out.append([t.text.strip('`') if t.kind == 'bt' else t.text for t in tokenize(unescape(m.group(1)))])
    return out


GENERATED = [
    re.compile(r'/\*\*\s*\*\s*Auto-generated Migration: Please modify to your needs!\s*\*/'),
    re.compile(r'// this (?:up|down)\(\) migration is auto-generated, please modify it to your needs'),
]


def without_generated(src):
    for r in GENERATED:
        src = r.sub('', src)
    return src


def non_sql(src):
    return re.sub(r'\s+', '', CALL_ANY.sub('ADDSQL', without_generated(src)))


def check_generated(src):
    return [r.pattern[:30] for r in GENERATED if r.search(src)]


def check_fk_split(stmts):
    bad = []
    for s in stmts:
        for m in re.finditer(r'ADD CONSTRAINT[^\n]*', s):
            line = m.group(0)
            if 'FOREIGN KEY' in line or 'REFERENCES' in line or ' ON DELETE' in line:
                bad.append(line.strip()[:60])
                continue
            rest = s[m.end():].split('\n')[1:4]
            if not (rest and rest[0].strip().startswith('FOREIGN KEY') and len(rest) > 1 and rest[1].strip().startswith('REFERENCES')):
                bad.append(line.strip()[:60])
    return bad


def statements(src):
    return [unescape(m.group(1)) for m in CALL_ANY.finditer(src)]


def php_ok(files):
    rel = [str(f.relative_to(PROJECT)) for f in files]
    bad = []
    for r in rel:
        p = subprocess.run(['docker', 'compose', 'exec', '-T', 'php-fpm', 'php', '-l', r], cwd=PROJECT, capture_output=True, text=True)
        if 'No syntax errors' not in p.stdout:
            bad.append(r)
    return bad


def check_marker_indent(src):
    """$this->addSql(, the marker, the first SQL line and the closing quote start at the same column."""
    bad = []
    for m in re.finditer(r"^([ \t]*)\$this->addSql\(\n([ \t]*)/\*\*\s*@lang MySQL\s*\*/ '\n([ \t]*)\S.*?\n([ \t]*)'(?=\n|,)", src, re.M | re.S):
        if not (m.group(1) == m.group(2) == m.group(3) == m.group(4)):
            bad.append(src.count('\n', 0, m.start()) + 1)
    return bad


def check_create_table_gaps(stmts):
    bad = []
    for s in stmts:
        m = re.search(r'CREATE TABLE \S+\s*\(\n(.*)\n([ \t]*)\)', s, re.S)
        if not m:
            continue
        lines = m.group(1).split('\n')
        name = s.split('(')[0].strip()
        if lines[-1].strip() != '':
            bad.append(f'{name}: no empty line before )')
        filled = [l for l in lines if l.strip()]
        cols = [i for i, l in enumerate(lines) if re.match(r'\s*`', l)]
        keys = [i for i, l in enumerate(lines) if l.strip() and not re.match(r'\s*`', l)]
        if cols and keys and not (keys[0] - cols[-1] == 2 and lines[cols[-1] + 1].strip() == ''):
            bad.append(f'{name}: no empty line between columns and keys')
        if any(l != l.rstrip() for l in lines if not l.strip()):
            bad.append(f'{name}: empty line has trailing spaces')
        if not filled:
            bad.append(f'{name}: empty body')
    return bad


def check_key_alignment(stmts):
    bad = []
    for s in stmts:
        m = re.search(r'CREATE TABLE \S+\s*\(\n(.*)\n[ \t]*\)', s, re.S)
        if not m:
            continue
        keys = [l for l in m.group(1).split('\n') if re.match(r'\s*(?:UNIQUE |FULLTEXT |SPATIAL )?(?:INDEX|KEY|PRIMARY KEY)\b', l) and '(' in l]
        if len(keys) > 1 and len({l.index('(') for l in keys}) != 1:
            bad.append(s.split('(')[0].strip())
    return bad


def check_alter_add_alignment(stmts):
    bad = []
    for s in stmts:
        if not re.match(r'\s*ALTER TABLE', s):
            continue
        cols = [l for l in s.split('\n') if re.match(r'\s*(?:ADD|MODIFY)(?: COLUMN)? `', l)]
        if len(cols) > 1 and len({re.match(r'\s*(?:ADD|MODIFY)(?: COLUMN)? `[^`]+`\s+', l).end() for l in cols}) != 1:
            bad.append(s.strip().split('\n')[0])
    return bad


def check_call_gaps(src):
    return [src.count('\n', 0, m.start()) + 2 for m in re.finditer(r'\);[ \t]*\n[ \t]*\$this->addSql\(', src)]


def check_identifiers(stmts):
    """Table names after the leading keywords and CREATE TABLE column names must be backticked."""
    misses = []
    for s in stmts:
        for kw in (r'CREATE TABLE', r'ALTER TABLE', r'DROP TABLE', r'^\s*UPDATE', r'INSERT INTO', r'DELETE FROM', r'REFERENCES', r'\bON'):
            for m in re.finditer(kw + r'\s+(\S+)', s):
                name = m.group(1)
                if kw == r'\bON' and name.upper() in ('DELETE', 'UPDATE'):
                    continue
                if not name.startswith('`'):
                    misses.append(f'{kw.strip(chr(92) + "b")} {name}')
        for m in re.finditer(r'\bSET\s+(.+?)(?:\bWHERE\b|$)', s, re.S):
            for col in re.findall(r'(?:^|,)\s*([`\w]+)\s*=', m.group(1)):
                if not col.startswith('`'):
                    misses.append(f'SET {col}')
    return misses


def check_alignment(stmts):
    bad = []
    for s in stmts:
        m = re.search(r'CREATE TABLE \S+\s*\((.*)\n\s*\)', s, re.S)
        if not m:
            continue
        cols = [l for l in m.group(1).split('\n') if re.match(r'\s*`', l)]
        if len(cols) < 2:
            continue
        starts = {re.match(r'\s*`[^`]+`\s+', l).end() for l in cols}
        if len(starts) != 1:
            bad.append(s.split('(')[0].strip())
    return bad


def grade_run(case, run_dir):
    inputs = sorted((EVALS / case / 'files').rglob('*.php'))
    outs = {p.name: p for p in (run_dir / 'outputs').rglob('*.php')}
    res = []

    def add(text, passed, evidence):
        res.append({'text': text, 'passed': bool(passed), 'evidence': evidence})

    missing = [i.name for i in inputs if i.name not in outs]
    if missing:
        add('All input migrations are present in the result', False, f'missing: {missing}')
        return res

    one_line, no_marker, tok_diff, php_diff, ids, align, ml_stmt = [], [], [], [], [], [], []
    marker_bad, table_gaps, call_gaps, generated, fk_bad, key_align, add_align = [], [], [], [], [], [], []
    for i in inputs:
        a, b = i.read_text(), outs[i.name].read_text()
        if ONE_LINE.search(b):
            one_line.append(i.name)
        n_calls = len(re.findall(r'\$this->addSql\(', b))
        if len(re.findall(r'/\*\*\s*@lang MySQL\s*\*/', b)) != n_calls:
            no_marker.append(i.name)
        if sql_tokens(a) != sql_tokens(b):
            tok_diff.append(i.name)
        if non_sql(a) != non_sql(b):
            php_diff.append(i.name)
        ids += [f'{i.name}: {x}' for x in check_identifiers(statements(b))]
        align += [f'{i.name}: {x}' for x in check_alignment(statements(b))]
        for s in statements(b):
            if s.strip() and not s.startswith('\n'):
                ml_stmt.append(f'{i.name}: {s.strip()[:60]}')
        marker_bad += [f'{i.name}:{ln}' for ln in check_marker_indent(b)]
        table_gaps += [f'{i.name}: {x}' for x in check_create_table_gaps(statements(b))]
        call_gaps += [f'{i.name}:{ln}' for ln in check_call_gaps(b)]
        generated += [f'{i.name}: {x}' for x in check_generated(b)]
        fk_bad += [f'{i.name}: {x}' for x in check_fk_split(statements(b))]
        key_align += [f'{i.name}: {x}' for x in check_key_alignment(statements(b))]
        add_align += [f'{i.name}: {x}' for x in check_alter_add_alignment(statements(b))]

    add('No single-line $this->addSql(\'...\'); calls remain', not one_line, f'one-line calls in: {one_line}' if one_line else 'none found')
    add('Every addSql() has the /** @lang MySQL */ marker', not no_marker, f'missing in: {no_marker}' if no_marker else 'marker on every call')
    add('SQL is unchanged apart from backticks and whitespace (same tokens as the input)', not tok_diff, f'differs in: {tok_diff}' if tok_diff else 'token streams identical')
    add('Code outside the SQL strings (getDescription, docblocks, parameter arrays) is unchanged, apart from removing the Doctrine auto-generated comments', not php_diff, f'changed in: {php_diff}' if php_diff else 'identical ignoring whitespace and the generated comments')
    add('Table names and SET/CREATE TABLE column names are backticked', not ids, '; '.join(ids[:8]) or 'all backticked')
    add('Column names inside each CREATE TABLE are aligned', not align, '; '.join(align) or 'aligned (or no CREATE TABLE)')
    add('SQL bodies start on their own line (multi-line layout)', not ml_stmt, '; '.join(ml_stmt[:5]) or 'all multi-line')
    bad_php = php_ok(list(outs.values()))
    add('All migration files pass php -l', not bad_php, f'failed: {bad_php}' if bad_php else 'php -l ok for all files')
    add('$this->addSql(, /** @lang MySQL */, the first SQL line and the closing quote all start at the same indent', not marker_bad, f'{len(marker_bad)} call(s) indented differently, e.g. lines {marker_bad[:4]}' if marker_bad else 'same indent everywhere')
    add('Each CREATE TABLE has an empty line between the columns and the indexes/keys, and an empty line before the closing parenthesis', not table_gaps, '; '.join(table_gaps[:4]) or 'all CREATE TABLE blocks ok (or none)')
    add('Consecutive $this->addSql() calls are separated by one empty line', not call_gaps, f'{len(call_gaps)} missing, e.g. lines {call_gaps[:5]}' if call_gaps else 'all separated')
    add('No Doctrine auto-generated comments remain (no "Auto-generated Migration" docblock, no "this up()/down() migration is auto-generated" lines)', not generated, '; '.join(generated[:4]) or 'none left')
    add('Each foreign key is split over lines: ADD CONSTRAINT <name>, then FOREIGN KEY, REFERENCES and each ON DELETE/ON UPDATE on their own deeper lines', not fk_bad, '; '.join(fk_bad[:3]) or 'all split (or no foreign keys)')
    add('In each CREATE TABLE the index/key names (INDEX `x`, UNIQUE INDEX `y`, PRIMARY KEY) are padded so their column lists line up', not key_align, '; '.join(key_align[:4]) or 'aligned (or fewer than 2 keys)')
    add('When one ALTER TABLE adds or modifies several columns, the column names are padded so the types line up', not add_align, '; '.join(add_align[:4]) or 'aligned (or no multi-column ALTER)')
    return res


def main():
    it = Path(sys.argv[1])
    for case_dir in sorted(p for p in it.iterdir() if p.is_dir()):
        for run in sorted(p for p in case_dir.iterdir() if p.is_dir()):
            if not (run / 'outputs').exists():
                continue
            exp = grade_run(case_dir.name, run)
            passed = sum(e['passed'] for e in exp)
            (run / 'grading.json').write_text(json.dumps({
                'expectations': exp,
                'summary': {'passed': passed, 'failed': len(exp) - passed, 'total': len(exp), 'pass_rate': round(passed / len(exp), 2)},
            }, indent=2))
            print(f'{case_dir.name}/{run.name}: {passed}/{len(exp)}')


if __name__ == '__main__':
    main()
