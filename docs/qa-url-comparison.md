# Local URL comparison

These are synthetic, public local fixtures, not verified production pages. Original paths from the brief were instantiated locally only to test lookup/rendering. Integration tests verified that all fixture content hashes, IDs, metadata and permalinks were unchanged by theme switching. No public site content was imported.

| Local fixture path | Fixture type | HTTP result | Record/content preservation |
| --- | --- | --- | --- |
| `/hello-world/` | post | 200 | Unchanged |
| `/sample-page/` | page | 200 | Unchanged |
| `/` | page | 200 | Unchanged |
| `/learning/` | page | 200 | Unchanged |
| `/stem-ar/` | page | 200 | Unchanged |
| `/everyone-can-code-in-learning/` | page | 200 | Unchanged |
| `/visual-note-taking-using-ipad/` | page | 200 | Unchanged |
| `/koleq-podcast-with-garageband/` | page | 200 | Unchanged |
| `/garageband-mini-orchestra/` | page | 200 | Unchanged |
| `/mckk-apple-tech-leader/` | page | 200 | Unchanged |
| `/mckk-repository/` | page | 200 | Unchanged |
| `/showcase/` | page | 200 | Unchanged |
| `/house-rewards-programme/` | page | 200 | Unchanged |
| `/teaching/` | page | 200 | Unchanged |
| `/teachers-report-card/` | page | 200 | Unchanged |
| `/action-research-on-learning-with-ipad/` | page | 200 | Unchanged |
| `/apple-teacher-mckk/` | page | 200 | Unchanged |
| `/environment/` | page | 200 | Unchanged |
| `/environment/qa-environment-child/` | page | 200 | Unchanged |
| `/qa-blocks/` | page | 200 | Unchanged |
| `/journal/` | page | 200 | Unchanged |
| `/qa-journal-1/` | post | 200 | Unchanged |
| `/qa-journal-2/` | post | 200 | Unchanged |
| `/qa-journal-3/` | post | 200 | Unchanged |
| `/qa-journal-4/` | post | 200 | Unchanged |

Password-protected records are deliberately excluded from this public inventory. Their access control is tested separately. Attachments, restricted records, plugin resources and production URLs require staging reconciliation. To compare a real authorized staging copy, run `wp eval-file tests/export-public-inventory.php` before and after activation, store both outputs privately and compare IDs, slugs, parents, URLs and `content_sha256` fields.
