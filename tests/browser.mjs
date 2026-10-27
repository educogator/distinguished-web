import { chromium } from '@playwright/test';
import AxeBuilder from '@axe-core/playwright';
import assert from 'node:assert/strict';
import { mkdir, writeFile } from 'node:fs/promises';

const base = process.env.WP_TEST_URL || 'http://127.0.0.1:8080';
if (!['127.0.0.1', 'localhost'].includes(new URL(base).hostname)) throw new Error('Browser fixtures must run against localhost.');
const browser = await chromium.launch({ executablePath: process.env.CHROMIUM_PATH || '/usr/bin/chromium', args: ['--no-sandbox', '--disable-dev-shm-usage'] });
const results = [];
const errors = [];
const check = async (name, action) => {
  try { await action(); results.push({ name, status: 'passed' }); console.log(`PASS ${name}`); }
  catch (error) { results.push({ name, status: 'failed', error: error.message }); console.error(`FAIL ${name}: ${error.message}`); }
};
const context = await browser.newContext({ reducedMotion: 'reduce' });
const page = await context.newPage();
page.on('pageerror', (error) => errors.push(error.message));
await mkdir('docs/previews', { recursive: true });
const widths = [360, 390, 768, 1024, 1440];
for (const width of widths) {
  await page.setViewportSize({ width, height: 1000 });
  for (const [path, name] of [['/', 'home'], ['/visual-note-taking-using-ipad/', 'page']]) {
    await page.goto(base + path, { waitUntil: 'networkidle' });
    await check(`${name} at ${width}px has no horizontal overflow`, async () => {
      const sizes = await page.evaluate(() => ({ scroll: document.documentElement.scrollWidth, client: document.documentElement.clientWidth }));
      assert.ok(sizes.scroll <= sizes.client + 1, JSON.stringify(sizes));
    });
    await check(`${name} at ${width}px passes automated WCAG 2.2 AA scan`, async () => {
      const axe = await new AxeBuilder({ page }).withTags(['wcag2a', 'wcag2aa', 'wcag21a', 'wcag21aa', 'wcag22aa', 'best-practice']).analyze();
      assert.equal(axe.violations.length, 0, JSON.stringify(axe.violations.map((v) => ({ id: v.id, impact: v.impact, nodes: v.nodes.map((n) => n.target) }))));
    });
    if ([390, 768, 1440].includes(width)) await page.screenshot({ path: `docs/previews/${name}-${width}.png`, fullPage: true });
  }
}
await page.setViewportSize({ width: 390, height: 844 });
await page.goto(base + '/');
await check('Static homepage content is rendered exactly once', async () => {
  assert.equal(await page.locator('.entry-content').count(), 1);
  assert.equal((await page.locator('body').innerText()).split('HOME_CONTENT_SENTINEL').length - 1, 1);
});
await check('Mobile drawer opens, contains focus and restores focus on Escape', async () => {
  const toggle = page.getByRole('button', { name: 'Menu', exact: true });
  await toggle.click();
  assert.equal(await toggle.getAttribute('aria-expanded'), 'true');
  assert.ok(await page.locator('#site-navigation a').first().evaluate((el) => el === document.activeElement));
  const axe = await new AxeBuilder({ page }).withTags(['wcag2a', 'wcag2aa', 'wcag22aa']).analyze();
  assert.equal(axe.violations.length, 0, JSON.stringify(axe.violations.map((v) => v.id)));
  await page.locator('#site-navigation .search-access').focus();
  await page.keyboard.press('Tab');
  assert.ok(await toggle.evaluate((el) => el === document.activeElement));
  await page.keyboard.press('Escape');
  assert.equal(await toggle.getAttribute('aria-expanded'), 'false');
  assert.ok(await toggle.evaluate((el) => el === document.activeElement));
});
await check('Nested mobile menus expose correct expanded state', async () => {
  await page.getByRole('button', { name: 'Menu', exact: true }).click();
  const learning = page.getByRole('button', { name: 'Toggle submenu for Learning', exact: true });
  await learning.click();
  const stem = page.getByRole('button', { name: 'Toggle submenu for STEM AR', exact: true });
  await stem.click();
  assert.equal(await stem.getAttribute('aria-expanded'), 'true');
  assert.ok(await page.locator('#site-navigation').getByRole('link', { name: 'QA block compatibility' }).isVisible());
  await stem.focus();
  await page.keyboard.press('Escape');
  assert.equal(await stem.getAttribute('aria-expanded'), 'false');
  assert.equal(await learning.getAttribute('aria-expanded'), 'true');
  await page.keyboard.press('Escape');
  await page.keyboard.press('Escape');
});
await page.setViewportSize({ width: 1440, height: 1000 });
await page.goto(base + '/');
await check('Desktop submenu supports keyboard activation and Escape', async () => {
  const learning = page.getByRole('button', { name: 'Toggle submenu for Learning', exact: true });
  await learning.focus();
  await page.keyboard.press('Enter');
  assert.equal(await learning.getAttribute('aria-expanded'), 'true');
  await page.keyboard.press('Tab');
  assert.ok(await page.getByRole('navigation', { name: 'Primary', exact: true }).getByRole('link', { name: 'STEM AR', exact: true }).evaluate((el) => el === document.activeElement));
  await page.keyboard.press('Escape');
  assert.equal(await learning.getAttribute('aria-expanded'), 'false');
});
await page.goto(base + '/visual-note-taking-using-ipad/');
await check('Classic gallery, shortcode and resource URLs survive rendering', async () => {
  assert.ok(await page.locator('.gallery img').count() >= 2);
  assert.ok((await page.locator('.entry-content').innerText()).includes('SHORTCODE_RENDERED_SENTINEL'));
  assert.equal(await page.locator('.entry-content a[href="https://drive.google.com/file/d/QA_FIXTURE/view"]').count(), 1);
  assert.equal(await page.locator('.entry-content a[href="https://www.youtube.com/watch?v=QA_FIXTURE"]').count(), 1);
  assert.equal(await page.locator('.entry-content a[download]').count(), 1);
  assert.ok(await page.locator('.embed-fallback a').count());
  const fit = await page.locator('.gallery img').first().evaluate((el) => getComputedStyle(el).objectFit);
  assert.equal(fit, 'contain');
});
await check('Image dialog opens and closes with focus restored; original anchor stays intact', async () => {
  const trigger = page.locator('.lightbox-trigger').first();
  const href = await trigger.evaluate((el) => el.previousElementSibling.href);
  await trigger.click();
  assert.ok(await page.getByRole('dialog').isVisible());
  assert.equal(await page.getByRole('dialog').locator('img').getAttribute('src'), href);
  await page.keyboard.press('Escape');
  assert.equal(await page.getByRole('dialog').count(), 0); // Role locator excludes closed dialog.
  assert.ok(await trigger.evaluate((el) => el === document.activeElement));
  assert.equal(await trigger.evaluate((el) => el.previousElementSibling.href), href);
});
await check('Search returns actual matching pages', async () => {
  await page.goto(base + '/?s=Note-taking');
  assert.ok(await page.locator('.content-card').count());
  assert.ok(await page.locator('.card-link[href$="/visual-note-taking-using-ipad/"]').count());
});
await check('Search has a helpful empty state', async () => {
  await page.goto(base + '/?s=zzzzzznomatchesfixture');
  assert.ok(await page.getByRole('heading', { name: 'No matching content' }).isVisible());
});
await check('Unknown URL sends HTTP 404 with a usable search form', async () => {
  const response = await page.goto(base + '/qa-no-such-page-987/');
  assert.equal(response.status(), 404);
  assert.ok(await page.getByRole('searchbox').isVisible());
});
await check('Password-protected content stays protected', async () => {
  await page.goto(base + '/qa-protected/');
  assert.ok(await page.locator('.post-password-form').isVisible());
  assert.ok(!(await page.locator('body').innerText()).includes('PROTECTED_CONTENT_SENTINEL'));
});
await check('Gutenberg columns and native block content render', async () => {
  await page.goto(base + '/qa-blocks/');
  assert.ok((await page.locator('.entry-content').innerText()).includes('BLOCK_FIXTURE_SENTINEL'));
  assert.equal(await page.locator('.entry-content .wp-block-columns .wp-block-column').count(), 2);
});
await check('Posts index uses native pagination', async () => {
  await page.goto(base + '/journal/');
  assert.equal(await page.locator('.content-card').count(), 2);
  await page.getByRole('link', { name: 'Next' }).click();
  assert.ok(page.url().includes('/page/2/'));
  assert.ok(await page.locator('.content-card').count());
});
await check('Archive, single post and comments form render', async () => {
  await page.goto(base + '/category/uncategorized/');
  assert.ok(await page.locator('.content-card').count());
  await page.goto(base + '/qa-journal-1/');
  assert.ok(await page.locator('.entry-content .wp-block-columns').count());
  assert.ok(await page.locator('#commentform').count());
});
await check('200% text zoom has no viewport overflow', async () => {
  for (const width of [390, 1440]) {
    await page.setViewportSize({ width, height: 1000 });
    await page.goto(base + '/');
    await page.evaluate(() => { document.documentElement.style.fontSize = '200%'; });
    const ok = await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth + 1);
    assert.ok(ok, `Overflow at ${width}px with 200% text`);
  }
});
await check('Reduced-motion disables smooth scrolling', async () => {
  assert.equal(await page.evaluate(() => getComputedStyle(document.documentElement).scrollBehavior), 'auto');
});
const noJS = await browser.newContext({ javaScriptEnabled: false, viewport: { width: 390, height: 844 } });
await check('Navigation and content work without JavaScript', async () => {
  const plain = await noJS.newPage();
  await plain.goto(base + '/');
  assert.ok(await plain.locator('#site-navigation').getByRole('link', { name: 'STEM AR', exact: true }).isVisible());
  assert.ok((await plain.locator('body').innerText()).includes('HOME_CONTENT_SENTINEL'));
});
await noJS.close();
await check('Failed enhancement script recovers an expanded mobile navigation', async () => {
  const failed = await browser.newContext({ viewport: { width: 390, height: 844 } });
  await failed.route('**/assets/js/main.js*', (route) => route.abort());
  const plain = await failed.newPage();
  await plain.goto(base + '/');
  await plain.waitForFunction(() => !document.documentElement.classList.contains('mckk-pending'));
  assert.ok(await plain.locator('#site-navigation').getByRole('link', { name: 'STEM AR', exact: true }).isVisible());
  await failed.close();
});
await page.setViewportSize({ width: 1200, height: 900 });
await page.goto(base + '/');
await page.screenshot({ path: 'mckk-ads-showcase/screenshot.png' });
await check('No JavaScript runtime errors', async () => assert.deepEqual(errors, []));
await browser.close();
await mkdir('test-results', { recursive: true });
await writeFile('test-results/browser.json', JSON.stringify({ browser: 'System Chromium', base, results }, null, 2));
console.log(`${results.filter((r) => r.status === 'passed').length}/${results.length} checks passed`);
if (results.some((r) => r.status === 'failed')) process.exitCode = 1;
