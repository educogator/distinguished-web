import { chromium } from '@playwright/test';
import assert from 'node:assert/strict';
import { execFileSync } from 'node:child_process';

// Only the guarded, retained local fixture. Never change a remote school's settings.
const wp = process.env.WP_CLI_BIN || '/workspace/mckk-tools/wp';
const command = (...args) => execFileSync(wp, args, { encoding: 'utf8' }).trim();
const base = command('option', 'get', 'home');
assert.equal(new URL(base).hostname, '127.0.0.1');
assert.equal(command('eval', 'echo wp_get_environment_type();'), 'local');
const browser = await chromium.launch({ executablePath: process.env.CHROMIUM_PATH || '/usr/bin/chromium', args: ['--no-sandbox', '--disable-dev-shm-usage'] });
const page = await browser.newPage({ viewport: { width: 390, height: 844 } });
const reading = command('option', 'get', 'show_on_front');
try {
  command('option', 'update', 'show_on_front', 'posts');
  await page.goto(base + '/');
  assert.equal(await page.locator('h1').count(), 1);
  assert.equal(await page.locator('.listing-section .content-card').count(), 2);
  assert.equal(await page.locator('.homepage-story').count(), 0);
  console.log('PASS Posts-on-front mode renders native query once with one main heading');
  await page.goto(base + '/page/2/');
  assert.equal(await page.locator('.listing-section .content-card').count(), 2);
  console.log('PASS Posts-on-front pagination preserves native URLs');
  command('option', 'update', 'show_on_front', reading);
  command('eval', 'set_theme_mod("mckk_ads_lightbox", false);');
  await page.goto(base + '/visual-note-taking-using-ipad/');
  assert.equal(await page.locator('.lightbox-trigger').count(), 0);
  assert.ok(await page.locator('.entry-content a[href$=".png"]').count());
  console.log('PASS Disabling the lightbox retains original media links');
  command('eval', 'remove_theme_mod("mckk_ads_lightbox");');
  command('eval', 'set_theme_mod("nav_menu_locations", array());set_theme_mod("mckk_ads_reuse_menu", false);');
  await page.goto(base + '/');
  await page.getByRole('button', { name: 'Menu', exact: true }).click();
  assert.ok(await page.locator('#primary-menu').getByRole('link', { name: 'Environment', exact: true }).isVisible());
  await page.getByRole('button', { name: 'Toggle submenu for Environment', exact: true }).click();
  assert.ok(await page.getByRole('link', { name: 'QA hierarchy child', exact: true }).isVisible());
  console.log('PASS Actual-page fallback supports touch disclosures and real hierarchy');
} finally {
  command('option', 'update', 'show_on_front', reading);
  command('eval', 'remove_theme_mod("mckk_ads_lightbox");remove_theme_mod("mckk_ads_reuse_menu");set_theme_mod("nav_menu_locations", array("primary" => wp_get_nav_menu_object("QA primary")->term_id));');
  await browser.close();
}
