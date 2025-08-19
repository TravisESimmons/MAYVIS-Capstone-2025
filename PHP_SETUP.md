# MAYVIS Web Application - Modern PHP Project

## 🚀 Quick Start Guide

### Prerequisites
To run this PHP application locally, you need PHP installed on your system.

### Installing PHP on Windows

#### Option 1: XAMPP (Recommended for beginners)
1. Download XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Install XAMPP (includes PHP, Apache, MySQL)
3. Add PHP to your system PATH:
   - Open System Properties → Environment Variables
   - Add `C:\xampp\php` to your PATH variable
4. Restart VS Code

#### Option 2: Standalone PHP
1. Download PHP from [https://windows.php.net/download/](https://windows.php.net/download/)
2. Extract to `C:\php`
3. Add `C:\php` to your system PATH
4. Restart VS Code

#### Option 3: Using Scoop (Package Manager)
```powershell
# Install Scoop first (if not installed)
Set-ExecutionPolicy RemoteSigned -Scope CurrentUser
irm get.scoop.sh | iex

# Install PHP
scoop install php
```

### Running the Application

Once PHP is installed:

```bash
# Navigate to project directory
cd "c:\Users\Travis\OneDrive\Desktop\Portfolio Stuff\KEEN-Mayvis-WebApp-Capstone-main"

# Start PHP development server
php -S localhost:8000

# Open in browser
# http://localhost:8000
```

### VS Code Configuration

This project includes VS Code settings in `.vscode/settings.json` that:
- Disables PHP validation warnings (until PHP is properly installed)
- Configures proper file associations
- Sets up formatting preferences

### Project Structure

```
├── index.php           # Modern home page
├── css/
│   ├── home.css       # Modern CSS styles
│   └── ...
├── includes/
│   ├── header-new.php # Navigation header
│   ├── footer.php     # Modern footer
│   └── ...
├── resources/         # Images and assets
├── login/            # Authentication system
└── ...
```

### Features

✨ **Modern UI/UX**
- Responsive design with CSS Grid and Flexbox
- Modern color scheme with CSS custom properties
- Smooth animations and transitions
- Interactive elements with hover effects

🎨 **Design Updates**
- Contemporary typography (Inter & Poppins fonts)
- Gradient backgrounds and glassmorphism effects
- Card-based layout with shadow effects
- Mobile-first responsive design

⚡ **Performance**
- Optimized animations with requestAnimationFrame
- Lazy loading for scroll animations
- Efficient CSS and JavaScript

### Browser Support
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

### Development

For development, it's recommended to:
1. Install a PHP extension for VS Code (PHP Intelephense recommended)
2. Use a local development server (XAMPP or PHP built-in server)
3. Enable error reporting for debugging

### Troubleshooting

**"Cannot validate since a PHP installation could not be found"**
- Install PHP using one of the methods above
- Add PHP to your system PATH
- Restart VS Code
- Alternatively, disable PHP validation in VS Code settings

**Styles not loading**
- Ensure the CSS files are in the correct directories
- Check file permissions
- Clear browser cache

**Database connection issues**
- Ensure MySQL is running (if using XAMPP)
- Check database credentials in `connect.php`
- Verify database exists and is accessible

---

## 🎯 Next Steps

The home page has been completely modernized! Ready to modernize more pages:

1. **Login/Registration Pages** - Update authentication UI
2. **Dashboard Pages** - Client and employee dashboards  
3. **Proposal Creation** - Modern proposal builder
4. **Templates** - Template management interface
5. **Profile Pages** - User profile management

Each page will get the same modern treatment with:
- Contemporary design language
- Improved user experience
- Mobile-responsive layouts
- Performance optimizations
