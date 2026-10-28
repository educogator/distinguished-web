# Local development and reproducible validation

The production artifact is just the theme. The separate local WordPress/database and
QA tools below are **development fixtures only**, not a clone or dependency of the school.
Use the existing checkout: cloud tasks already have an isolated workspace. Do not create
another Git worktree unless explicitly requested.

## Prepared cloud instance

- Checkout: `/workspace/distinguished-web`.
- WordPress 6.8.3: `/workspace/mckk-tools/wordpress` (official WordPress Git tag).
- PHP 8.4.24: `/workspace/mckk-tools/php-run` (userland Debian packages, signed APT
  metadata and package checksum verification retained).
- WP-CLI: `/workspace/mckk-tools/wp` (wrapper for local WordPress only).
- SQLite integration: official `WordPress/sqlite-database-integration` repository,
  commit `c7d6963a839499459fedcdaf2ec260b843c3d220`. This is local test infrastructure,
  never a required production plugin. Production MySQL/MariaDB was not available to test.
- PHPCS 3.13.5 / WPCS 3.2.0 / PHPCSUtils 1.1.2 / PHPCSExtra 1.4.1 under the same tools
  directory. Full WordPress rules are registered, with no excluded security sniffs.
- Browser checks: locked development dependencies in `package-lock.json`, system Chromium.

The original machine had no PHP or writable system package installation path. Installation
used a private APT config under `/workspace/mckk-tools/apt`, the official HTTPS
`deb.debian.org/debian` trixie repository with the system Debian archive keyring, private
lists/cache and `apt-get --download-only -o Debug::NoLocking=1`. Packages were extracted
with `dpkg-deb -x` under `mckk-tools/php`; the wrapper sets only that process's library
path and PHP configuration. No signature, checksum or TLS checks were disabled.
The machine's original snapshot.debian.org sources were blocked; they were not overwritten.

## Start the retained local fixture

From `/workspace/distinguished-web`, refresh dev dependencies:

```sh
npm ci --cache /workspace/mckk-tools/npm-cache --no-audit --no-fund
npm run check:js
/workspace/mckk-tools/php-run -S 127.0.0.1:8080 \
  -t /workspace/mckk-tools/wordpress /workspace/mckk-tools/router.php
```

Run the server in a managed background/terminal session. Live processes do not survive
publication or a new task. Check a local HTTP response for the homepage and the marker
`HOME_CONTENT_SENTINEL`, not merely an open port. Do not present loopback addresses as
user-facing web preview links. Stop/restart only the server process you started.

The packaged theme is installed as an actual directory in the local WordPress theme
folder during release testing. For iterative edits, copy the source into that local
theme directory or use a source symlink **only on this disposable local site**. Do not
overwrite a production theme directory or assume a running browser serves repository
edits after a ZIP installation. To test a new release, install its ZIP locally with
`wp theme install /absolute/path/to/zip --force --activate` using the local wrapper.

## Run checks

```sh
# Current working directory: /workspace/distinguished-web
npm test
/workspace/mckk-tools/wp eval-file tests/integration.php
python3 scripts/check-theme.py --php /workspace/mckk-tools/php-run
/workspace/mckk-tools/php-run /workspace/mckk-tools/phpcs/bin/phpcs --standard=phpcs.xml.dist
python3 scripts/package-theme.py
```

Browser checks write ignored `test-results/browser.json`, refresh the six labelled local
fixture previews and theme screenshot, and preserve a nonzero status on failure. Use a
localhost fixture URL only (`WP_TEST_URL`); `CHROMIUM_PATH` can select another installed
Chromium binary. Node is not required in production. Integration tests also guard against
nonlocal use and verify content hashes and native behavior; their temporary synthetic
records are removed. Do not run fixture scripts against an actual school database.

## Independent local installation

Use a fresh local WordPress 6.6+ on a supported PHP release with MySQL/MariaDB, or the
official SQLite integration for development only. Set `WP_ENVIRONMENT_TYPE=local` and
use a `127.0.0.1` origin before invoking these guarded scripts. Choose a local-only
administrator credential securely; no real credentials ship in this repository.
Install the ZIP, then prepare clearly labelled synthetic content. `tests/fixture.php`
is the exact cloud fixture: it expects the two generated test images at
`/workspace/mckk-tools/fixtures/{landscape,portrait}.png`; adapt these **local-only paths**
for another machine. It creates test records and a test-only shortcode plugin and is
not an importer for production. Keep API keys, database files, uploads and credentials
outside source control. Existing production URLs in the audit are never fetched by tests.

## Network and saved environment settings

The saved environment draft adds `distinguished.mckk.edu.my`, `wordpress.org`,
`api.wordpress.org` and `downloads.wordpress.org`, preserving the package-manager preset.
Saving is not runtime application or publication. The public crawl remains blocked until
the policy is applied; subsequent tasks should retry read-only discovery after that change.
The local tests do not require production credentials. They use the platform Git proxy,
GitHub source downloads and npm/Debian registry access. No secret requirement was added.

## Post-install v1.1 review

See post-install-audit-v1.md, qa-v1.1.md and update-v1.1.md. The separate public rendered-content replay runs from `/workspace/mckk-tools/review-wordpress` on port 8081. Its media are remote references, not files in the theme. The retained `/workspace/mckk-tools/verified-fetch.py` service on port 8090 validates upstream HTTPS with the system trust store and caches only public GET assets for browser replay. Run `node tests/public-replay.mjs` only after both retained local services start; it performs no production writes. The original synthetic fixture on 8080 remains independent. Run `wp eval-file tests/release-v11.php` with the local wrapper for the additional regressions.
