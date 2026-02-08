# 🎯 Theme Development Rules

## 1. File Organization
- All reusable functions go inside `/inc/`
- No direct logic in `functions.php`, only includes
- JS & Tailwind CSS are stored in `/assets/`

### Use this Structure
/mytheme/
├── style.css
├── functions.php
├── index.php
├── header.php
├── footer.php
├── page.php
├── single.php
├── screenshot.png
├── inc/
│   ├── setup.php
│   ├── enqueue.php
│   ├── widgets.php
│   ├── customizer.php
│   ├── acf-options.php
│   └── nav-menus.php
├── assets/
│   ├── css/
│   │   └── tailwind.css
│   └── js/
│       └── main.js
└── template-parts/
    ├── header/
    │   └── site-branding.php
    ├── footer/
    │   └── widgets.php


## 2. Theme Features
- Header/Footer use dynamic widget areas
- Customizer has options for:
  - Logo upload
  - Header button text/link
  - Footer column count

## 3. Editor Rules
- Always use `esc_html()`, `esc_url()` for output
- Sanitize user input before saving
- Keep code DRY (Don't Repeat Yourself)

## 4. Deployment
- Run Tailwind CLI to build CSS before pushing
- Make sure `style.css` has theme header for WordPress

## 5. Use Variables Colors 
- Use Variables Colors Where You Need 
- It Make Easier For Users Admin To Chnage The Colors