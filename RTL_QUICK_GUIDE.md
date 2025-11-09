# RTL Quick Guide

## 🔴 The Problem

**Issue**: Arabic pages were flipping/mirroring the entire layout (logo on right, menu on left, etc.)

**Root Causes**:
1. Bootstrap RTL CSS was loading for all pages
2. RTL CSS was using `flex-direction: row-reverse` and `direction: rtl` which flipped everything
3. Missing `dir="ltr"` on English pages

---

## ✅ The Solution

**Strategy**: Keep layout identical to English, only change text direction to RTL.

**Key Fixes**:
1. Added `dir="ltr"` to English header
2. Conditional Bootstrap RTL loading (only for Arabic pages)
3. RTL CSS: Use `direction: ltr !important` for containers, `direction: rtl` for text only

---

## 📝 Creating New Arabic Pages

### Step 1: Create Template File
**File**: `your-page-ar.php`
```php
<?php
/*
Template Name: Your Page Arabic
*/
get_header('ar');
?>

<main>
    <!-- Your Arabic content -->
</main>

<?php get_footer('ar'); ?>
```

### Step 2: Create RTL CSS
**File**: `assets/ar/your-page-rtl.css`
```css
/* Force LTR layout for containers */
html[dir="rtl"] .your-container {
    direction: ltr !important;
}

/* RTL for text only */
html[dir="rtl"] .your-text {
    direction: rtl;
    text-align: right;
}
```

### Step 3: Enqueue CSS in functions.php
```php
if ( is_page_template('your-page-ar.php') ) {
    wp_register_style('your-page', 
        get_template_directory_uri() . '/assets/en/your-page.css', 
        array('main'), '1.0.0', 'all');
    wp_enqueue_style('your-page');
    
    wp_register_style('your-page-rtl', 
        get_template_directory_uri() . '/assets/ar/your-page-rtl.css', 
        array('your-page'), '1.0.1', 'all');
    wp_enqueue_style('your-page-rtl');
}
```

---

## 🎯 RTL CSS Rules

**For Layout Containers** (nav, sections, grids):
```css
html[dir="rtl"] .container {
    direction: ltr !important;  /* Keep same layout */
    flex-direction: row !important;  /* Same as English */
}
```

**For Text Elements** (p, h1-h6, links):
```css
html[dir="rtl"] p, html[dir="rtl"] h1 {
    direction: rtl;  /* Arabic text flows RTL */
    text-align: right;
}
```

**Never Use**:
- ❌ `flex-direction: row-reverse`
- ❌ `direction: rtl` on containers (flips layout)

---

## ✅ Checklist

- [ ] Template file named `-ar.php`
- [ ] Use `get_header('ar')` and `get_footer('ar')`
- [ ] Create RTL CSS file
- [ ] Add CSS enqueue in `functions.php`
- [ ] Force `direction: ltr !important` on containers
- [ ] Use `direction: rtl` only on text elements

---

**That's it!** Same layout, Arabic text right-aligned.

