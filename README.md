# 🎩 TopHat

A Heads Up-style party game that runs in any modern browser. Hold the device against your forehead, your team shouts clues, and you tilt forward to confirm a guess or back to skip. Optimised for mobile (Android tilt, iOS Add-to-Home-Screen) and works on desktop with keyboard or tap controls.

## What's in this repo

```
TopHat/
├── plugin/             WordPress plugin source. Install the inner folder
│                       into wp-content/plugins/ via FTP, or upload dist/
│                       headsup-mob.zip via the WP admin.
├── standalone/         Self-contained HTML version. Open standalone/index.html
│                       in any browser — no install or build step.
└── dist/               Pre-built plugin zip ready to upload via WP admin.
```

> The internal plugin slug is still `headsup-mob` from the original prototype name. Renaming to TopHat is straightforward but breaks any existing installs, so it's intentionally deferred until needed.

## Features

- **Six bundled categories**: Movies, Animals, Celebrities, Act It Out, Food & Drink, plus a customised "Humans" deck.
- **60-second rounds** with countdown, in-round timer, end-of-round recap, play-again flow.
- **Multi-input**: keyboard (Space/↓ correct, ↑ skip), full-screen tap zones (top half skip, bottom half correct), and **gravity-vector tilt** with edge-glow progress feedback for mobile.
- **PWA installable** on Android (one-tap "Add to Home Screen" via the install prompt) and iOS (Share → Add to Home Screen). Includes manifest, service worker, icons, and offline support.
- **Cheesy synth-pop background music** generated procedurally via the Web Audio API — no audio assets, no licensing.
- **Debug overlay** for tuning tilt thresholds (toggle via `🐞 Debug` button or `?debug=1`).
- **In-app cache reset** (`♻ Reset cache`) so PWA updates don't get stuck on stale assets.

## Running the standalone version

```bash
# Just open it
open standalone/index.html
```

For tilt to work on mobile, the page must be served over HTTPS or `localhost`. To test on a phone:

```bash
cd standalone
python3 -m http.server 8080
# Then visit http://<your-laptop-ip>:8080 from the phone
# (use ngrok or similar if you need HTTPS for tilt testing)
```

## Installing the WordPress plugin

**Option 1: Upload via admin**
1. WP Admin → Plugins → Add New → Upload Plugin
2. Choose `dist/headsup-mob.zip`
3. Install Now → Activate

**Option 2: Drop in via FTP**
1. Copy `plugin/headsup-mob/` into your site's `wp-content/plugins/`
2. Activate in WP admin

### Using the plugin

Two ways to expose the game:

- **Shortcode** for embedding in a page: `[headsup_game]`. Optional height attribute: `[headsup_game height="100vh"]`. Embeds the game in an iframe — fine for inline use, but PWA install isn't possible from a shortcode page.
- **Page template** for the installable fullscreen version: create a new page, set the template to **Heads Up Fullscreen** in Page Attributes. The page redirects to the game asset URL where the manifest, service worker, and install prompt all work.

## Tilt detection

Uses `DeviceMotionEvent.accelerationIncludingGravity`. The z-component of gravity in the device frame is naturally orientation-independent, so the same logic works in portrait, landscape, or any rotation without remapping axes. A low-pass filter and noise deadband suppress jitter; asymmetric thresholds compensate for the harder physical motion of tilting backwards. See `plugin/headsup-mob/assets/game.html` (search for `INPUT: TILT`) for the implementation.

## Versioning

The plugin version is in the header of `plugin/headsup-mob/headsup-mob.php`. The service worker cache key (`plugin/headsup-mob/assets/sw.js`) is bumped in lockstep so PWA updates evict stale assets. Bump both together when publishing.

## License

MIT — see [LICENSE](LICENSE).
