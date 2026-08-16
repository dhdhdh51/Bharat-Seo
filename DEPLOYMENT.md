# CareerForge AI cPanel Deployment Guide

1. Upload files to cPanel File Manager or FTP.
2. Set the domain document root to `public/`.
3. Create a MySQL 8 database in cPanel.
4. Create a database user and assign all privileges.
5. Select PHP 8.2+ and enable PDO MySQL, cURL, OpenSSL, JSON, Mbstring, Fileinfo, GD/Imagick, and Zip.
6. Copy `config/config.example.php` to `config/config.php` and update database, app URL, app key, and security settings.
7. Import `database/schema.sql`, then `database/seed.sql` using phpMyAdmin.
8. Open `/install` and complete/verify system setup, then create `install/installed.lock` or remove the installer.
9. Configure SMTP in Admin > Email Settings and send a test email.
10. Configure Google OAuth in Admin > Google Login, including Client ID, Client Secret, and redirect URL.
11. Configure AI providers in Admin > AI Providers. Store keys server-side only and set provider priority for failover.
12. Configure payment gateways such as Razorpay, Stripe, Cashfree, or PayU and verify payments server-side.
13. Add cPanel cron jobs if enabled: `php /home/USER/public_html/cron/subscriptions.php`, `php /home/USER/public_html/cron/email_queue.php`, `php /home/USER/public_html/cron/cleanup.php`.
14. Enable SSL and force HTTPS.
15. Test registration, login, password reset, CV CRUD, AI fallback, credit deduction, ATS scan, PDF export, public CV, subscriptions, payments, admin login, SMTP, and mobile layouts.
16. Protect `storage/`, `database/`, `config/`, and backup files from public access.
17. Schedule database backups and download a verified backup before launch.
18. Production checklist: disable debug, rotate default keys, configure legal pages, set SEO metadata, verify no API keys appear in frontend JavaScript, and review activity logs.
