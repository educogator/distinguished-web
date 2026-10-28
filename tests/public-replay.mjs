import { chromium } from '@playwright/test';
import AxeBuilder from '@axe-core/playwright';
import assert from 'node:assert/strict';
import { mkdir, writeFile } from 'node:fs/promises';

// A separate local database made from public rendered responses. Never production admin.
const base = 'http://127.0.0.1:8081';
const browser = await chromium.launch({ executablePath: '/usr/bin/chromium', args: ['--no-sandbox', '--disable-dev-shm-usage'] });
const context = await browser.newContext({ reducedMotion: 'reduce' });
await context.route('https://**/*', async (route) => {
  try {
    // The bridge performs upstream HTTPS with the system trust store; no TLS bypass.
    const response = await fetch('http://127.0.0.1:8090/?url=' + encodeURIComponent(route.request().url()));
    await route.fulfill({ status: response.status, contentType: response.headers.get('content-type') || 'application/octet-stream', body: Buffer.from(await response.arrayBuffer()) });
  } catch { await route.abort(); }
});
const page = await context.newPage();
const results = [];
await mkdir('docs/previews-v1.1', { recursive: true });
try {
  for (const width of [360, 390, 768, 1024, 1440]) {
    await page.setViewportSize({ width, height: 1000 });
    await page.goto(base + '/', { waitUntil: 'networkidle', timeout: 60000 });
    for (let y = 0; y < await page.evaluate(() => document.body.scrollHeight); y += 800) {
      await page.evaluate((top) => window.scrollTo(0, top), y);
      await page.waitForTimeout(120);
    }
    await page.evaluate(() => window.scrollTo(0, 0));
    await page.waitForTimeout(500);
    assert.ok(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth + 1));
    assert.equal(await page.locator('#homepage-story-title').innerText(), 'Our story');
    assert.ok(await page.locator('.hero-concept-fallback').isVisible());
    assert.equal(await page.locator('.hero-media>img').count(), 0);
    assert.ok(await page.locator('[aria-labelledby="student-work"] a[href$="/visual-note-taking-using-ipad/"]').count());
    assert.ok(await page.locator('.card-image img').count() >= 10);
    const broken = await page.locator('.card-image img').evaluateAll((images) => images.filter((image) => image.complete && image.naturalWidth === 0).map((image) => image.src));
    assert.deepEqual(broken, []);
    const axe = await new AxeBuilder({ page }).withTags(['wcag2a','wcag2aa','wcag21aa','wcag22aa','best-practice']).analyze();
    assert.deepEqual(axe.violations.map((v) => v.id), []);
    results.push({ width, status: 'passed', libraryPreviews: await page.locator('.card-image img').count(), axeViolations: 0 });
    console.log(`PASS Public-content replay ${width}px: no overflow, no broken card images, TIFF fallback, post link, empty title, axe`);
    if ([390, 768, 1440].includes(width)) await page.screenshot({ path: `docs/previews-v1.1/home-public-${width}.png`, fullPage: true });
  }
  await page.goto(base + '/environment/', { waitUntil: 'domcontentloaded' });
  assert.ok(await page.locator('[aria-labelledby="related-title"] a[href$="/charging-room/"]').count());
  assert.ok(await page.locator('[aria-labelledby="related-title"] a[href$="/creative-studio/"]').count());
  console.log('PASS Environment uses real menu relationships even with parent=0');
  await page.goto(base + '/charging-room/', { waitUntil: 'domcontentloaded' });
  assert.ok(await page.getByRole('heading', { name: 'Keep exploring.' }).isVisible());
  assert.ok(await page.getByRole('searchbox').isVisible());
  console.log('PASS Empty existing pages offer navigation without fabricated editorial content');
  await page.goto(base + '/visual-note-taking-using-ipad/', { waitUntil: 'domcontentloaded' });
  assert.ok(await page.locator('.entry-content img').count() >= 19);
  assert.ok(await page.locator('[aria-labelledby="related-title"] a[href$="/stem-ar/"]').count());
  console.log('PASS Existing post-based visual notes retain images and contextual navigation');
  await page.screenshot({ path: 'docs/previews-v1.1/visual-notes-public-1440.png', fullPage: true });
} finally {
  await browser.close();
  await writeFile('docs/qa-public-replay-v1.1.json', JSON.stringify({ provenance: 'Public content.rendered replay, not a database clone or production deployment', results }, null, 2));
}
