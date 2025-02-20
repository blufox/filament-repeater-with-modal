# Laravel Filament Repeater with Modal
This is a sample Laravel application built with Filament that manages products and their parts. The app features:

- Two tables: products and product_parts.
- Filament-powered UI with a wizard-style form for creating products.
- Repeater with a modal for adding product parts (WIP).


## 🚀 Installation
Clone the repository:
```bash
git clone <your-repo-url>
cd <your-repo-folder>```
```

Install dependencies:
```bash
composer install
npm install && npm run build
```

Set up environment:
```bash
cp .env.example .env
php artisan key:generate
```

Configure your database in .env, then run:
```bash
php artisan migrate
```

Create an admin user for Filament:
```bash
php artisan filament:user
```

## 🔧 How It Works
1. Login to Filament at /admin using the created user.
2. Create a Product, which opens a wizard:
    1. Step 1: Enter product details.
    2. Step 2: Add product parts using a repeater.
3. Add a new Product Part (currently WIP):
    1. Clicking "Add to" should open a modal.
    2. After saving, the new part should appear in the list with edit & delete buttons.
    3. Clicking "Edit" should reopen the modal with the selected part's details.


## 🛠 Known Issues / To-Do
- Repeater modal not fully functional – Parts should be added dynamically.
- Edit functionality needs fixing – Modal should load existing part details.


## 📌 Contributing
Feel free to fork and submit PRs to improve the functionality! 🚀
