#!/usr/bin/env python3
"""Reproducible, allowlisted WordPress theme ZIP. No dependency/vendor trees."""
from pathlib import Path
from zipfile import ZipFile, ZipInfo, ZIP_DEFLATED
import hashlib
import re

ROOT = Path(__file__).resolve().parents[1]
THEME = ROOT / 'mckk-ads-showcase'
VERSION = re.search(r'^Version:\s*(\d+\.\d+\.\d+)', (THEME / 'style.css').read_text(), re.M).group(1)
OUT = ROOT / 'dist' / f'mckk-ads-showcase-v{VERSION}.zip'
REQUIRED = ['style.css', 'index.php', 'functions.php', 'theme.json', 'screenshot.png', 'README.md', 'LICENSE']
for name in REQUIRED:
    assert (THEME / name).is_file(), f'Missing required release file: {name}'
assert VERSION in (THEME / 'functions.php').read_text()
OUT.parent.mkdir(exist_ok=True)
with ZipFile(OUT, 'w', compression=ZIP_DEFLATED, compresslevel=9) as archive:
    for path in sorted(THEME.rglob('*')):
        if not path.is_file():
            continue
        assert not path.is_symlink(), f'Unexpected symlink: {path}'
        assert path.suffix.lower() in {'.php', '.css', '.js', '.json', '.png', '.md', '.pot', '.txt'} or path.name == 'LICENSE', path
        info = ZipInfo(str(path.relative_to(ROOT)), date_time=(2026, 10, 28, 0, 0, 0))
        info.compress_type = ZIP_DEFLATED
        info.external_attr = 0o100644 << 16
        archive.writestr(info, path.read_bytes())
with ZipFile(OUT) as archive:
    assert archive.testzip() is None
digest = hashlib.sha256(OUT.read_bytes()).hexdigest()
(OUT.parent / (OUT.name + '.sha256')).write_text(f'{digest}  {OUT.name}\n')
print(f'{OUT}: {OUT.stat().st_size:,} bytes; SHA-256 {digest}')
