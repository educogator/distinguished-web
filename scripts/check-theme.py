#!/usr/bin/env python3
"""Check every theme PHP file and propagate the first real command failure."""
import argparse
import json
from pathlib import Path
import subprocess

parser = argparse.ArgumentParser()
parser.add_argument('--php', default='php')
args = parser.parse_args()
root = Path(__file__).resolve().parents[1]
files = sorted((root / 'mckk-ads-showcase').rglob('*.php'))
assert files, 'No theme PHP files found'
for path in files:
    subprocess.run([args.php, '-l', str(path)], check=True, stdout=subprocess.DEVNULL)
json.loads((root / 'mckk-ads-showcase/theme.json').read_text())
subprocess.run(['node', '--check', str(root / 'mckk-ads-showcase/assets/js/main.js')], check=True)
print(f'PHP syntax {len(files)}/{len(files)} passed; theme.json and JavaScript syntax passed.')
