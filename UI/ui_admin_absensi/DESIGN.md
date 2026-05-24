```markdown
# Design System Strategy: The Academic Atelier

## 1. Overview & Creative North Star
The North Star for this design system is **"The Academic Atelier."** 

In the world of private tutoring, we must move beyond the "SaaS dashboard" cliché. We are not just managing data; we are orchestrating educational growth. This system rejects the rigid, boxy constraints of traditional management software in favor of an editorial, high-end experience. By leveraging **intentional asymmetry**, **tonal layering**, and **expansive whitespace**, we create an environment that feels as organized as a premium stationery set and as trustworthy as a dean’s office. 

The goal is a "Zero-Line" interface where structure is felt through weight and depth rather than seen through borders.

---

## 2. Colors: Tonal Depth vs. Structural Lines
This system utilizes a sophisticated palette of blues and slates to establish authority without the coldness of a purely "corporate" tool.

### The "No-Line" Rule
**Explicit Instruction:** You are prohibited from using 1px solid borders to section content. Boundaries must be defined through background color shifts. To separate a sidebar from a main content area, use `surface-container-low` against `surface`. To separate a table header, use a shift to `surface-container-high` rather than a stroke.

### Surface Hierarchy & Nesting
Treat the UI as physical layers of fine paper. 
*   **Base:** `surface` (#f8f9ff) for the widest application background.
*   **Sections:** Use `surface-container-low` (#eff4ff) for secondary modules or side panels.
*   **Actionable Elements:** Use `surface-container-lowest` (#ffffff) for the primary content cards to make them "pop" against the tinted background.

### The "Glass & Gradient" Rule
To elevate the "Trustworthy Blue," use subtle linear gradients on primary CTAs:
*   **Primary CTA Gradient:** `primary` (#004ac6) to `primary_container` (#2563eb) at a 135-degree angle. This provides a "jewel" effect that flat color cannot replicate.
*   **Glassmorphism:** For floating navigation or modal overlays, use `surface` at 80% opacity with a `24px` backdrop blur to maintain context of the underlying data.

---

## 3. Typography: Editorial Authority
We pair **Manrope** (Display/Headlines) with **Inter** (Body/Labels) to create a hierarchy that feels both modern and academically rigorous.

*   **The Power of Scale:** Use `display-lg` (3.5rem) for high-level dashboard summaries (e.g., "Total Learning Hours"). This massive scale communicates confidence.
*   **The Headline System:** `headline-md` (Manrope) should be used for section titles to provide a geometric, architectural feel.
*   **The Utility Layer:** `body-md` (Inter) handles all management data. Its high x-height ensures readability in dense tutoring schedules or student logs.

---

## 4. Elevation & Depth: Tonal Layering
Traditional shadows are often "dirty." In this system, depth is clean and light-driven.

*   **The Layering Principle:** Avoid shadows for static cards. Instead, stack `surface-container-lowest` (#ffffff) on top of `surface-container-low` (#eff4ff). This creates a "soft lift."
*   **Ambient Shadows:** For active states or "floating" elements (like a student profile popover), use: `box-shadow: 0 12px 32px -4px rgba(13, 28, 46, 0.06);`. Note the use of `on_surface` (#0d1c2e) as the shadow tint rather than pure black.
*   **The Ghost Border Fallback:** If accessibility requires a container boundary, use `outline_variant` at **15% opacity**. It should be a whisper, not a statement.

---

## 5. Components

### Buttons: The "Call to Action"
*   **Primary:** Gradient of `primary` to `primary_container`. Border radius: `md` (0.75rem).
*   **Secondary:** Ghost style. No background, `primary` text, with a `surface-container-high` hover state.
*   **Tertiary:** `on_surface_variant` text, used for low-priority actions like "Cancel" or "Export."

### Data Tables: The "Organized Ledger"
*   **Forbid Dividers:** Do not use horizontal lines between rows. Use `8px` of vertical spacing and a `surface-container-low` background on hover to highlight the active row.
*   **Header:** Use `label-md` in all caps with `0.05em` letter spacing to create a professional, "ledger" feel.

### Input Fields: The "Interactive Paper"
*   **State:** Default inputs should have no visible border—only a `surface-container-highest` background. 
*   **Focus State:** Transition to a `surface-container-lowest` background with a subtle `2px` soft glow in `primary_fixed`.

### Chips & Badges
*   **Tutoring Status:** Use `tertiary_container` for "In Progress" and `primary_fixed` for "Completed." Use `xl` (1.5rem) radius for a pill shape.

### Progress Trackers (Custom Component)
For student progress, use a "Stepped Gradient" bar. Instead of a solid blue bar, use a sequence of rounded blocks (`sm` radius) that transition from `primary_fixed` to `primary` to show momentum.

---

## 6. Do’s and Don’ts

### Do:
*   **Embrace Negative Space:** If a section feels crowded, increase the padding to `xl` (1.5rem) rather than adding a border.
*   **Use Intentional Asymmetry:** Align primary stats to the left and secondary actions to the far right with significant "air" between them.
*   **Nesting Surfaces:** Place a "White" (`lowest`) card inside a "Light Blue" (`low`) section.

### Don't:
*   **No High-Contrast Borders:** Never use #000 or high-opacity slates for lines. It breaks the "Atelier" flow.
*   **No Sharp Corners:** Avoid the `none` or `sm` rounding scale for main containers; it feels too aggressive for an educational environment.
*   **No Standard Drop Shadows:** Avoid the default "Figma" shadow. Always tint your shadows with the `on_surface` color for a natural, premium look.

---

**Director's Closing Note:** 
Management systems are often exhausting to look at. By following this system, you are creating a workspace that feels like a calm, sun-drenched library—highly functional, yet visually restorative.```