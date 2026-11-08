# Developer exam: Order Desk

## Your task

Order Desk is an internal ordering app. It runs, but it has **10 bugs**. Find and fix as many as you can in **90 minutes**.

Two bugs have been reported by users:

1. **Cart page:** the total is wrong when an item's quantity is more than 1.
2. **Products page:** adding a product to the cart puts a different product in the cart.

The other 8 have not been reported. Find them by using the app and reading the code. Some only show up with certain inputs, and some won't show up during normal use at all.

Treat the user selected in the **Signed in as** dropdown as the logged-in user. The dropdown itself stands in for a real login and is not part of the exam.

## What a good fix looks like

- Fix the root cause, not just the symptom.
- Keep each change small and focused. Don't redesign the app or add features.
- Don't break anything that already works.

## Recording your work

1. Before you start, set your name in this repository:

   ```
   git config user.name "Your Name"
   git config user.email "you@example.com"
   ```

2. **Commit after each fix**, with a short message describing what was wrong, for example:

   ```
   git add -A
   git commit -m "Fix: <what was wrong>"
   ```

3. Fill in **FINDINGS.md** as you go: where each bug is, what caused it, and how you fixed it. If you find a bug but run out of time to fix it, still write it down.

## Rules

- **No AI tools of any kind:** no ChatGPT, Claude, Gemini, GitHub Copilot, Copilot Chat, Cursor, Codeium, or similar. Disable AI extensions in VS Code before you start.
- **No search engines.** Search pages show AI-generated summaries.
- **Allowed references**, opened directly in the browser:
  - Laravel documentation: https://laravel.com/docs
  - PHP manual: https://www.php.net/manual
- Share your **entire screen** and keep your **camera on** for the whole session.
- Close all other apps and browser tabs. Use one monitor only.

## Submitting

1. Make sure all your work is committed.
2. Zip this project folder. You can leave out the `vendor` folder to keep the file small, but **keep the `.git` folder**.
3. Send the zip as instructed by your interviewer.
