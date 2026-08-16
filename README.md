# CareerForge AI

CareerForge AI is a production-oriented PHP 8.2+/MySQL 8 SaaS foundation for an AI-powered CV/resume builder that works on standard cPanel/shared hosting without Node.js, Laravel, or npm in production.

## Included

- Premium responsive landing, dashboard, builder, admin, and auth screens.
- Modular PHP architecture under `app/` with services for authentication, resumes, credits, prompts, payments, email, ATS analysis, and AI provider orchestration.
- Central AI manager with provider priority failover and OpenAI-compatible API support.
- Admin-configurable providers, prompts, estimated costs, templates, plans, SMTP, OAuth, payments, SEO, legal pages, and security settings via schema support.
- MySQL schema with users, profiles, OAuth, resumes, sections, experiences, education, skills, projects, versions, AI logs, credits, jobs, ATS scans, plans, payments, email, notifications, resets, verification, admin logs, and settings.
- cPanel installer blueprint and deployment checklist.

## Production note

The repository is intentionally framework-free and cPanel-friendly. Configure `config/config.php`, import `database/schema.sql` and `database/seed.sql`, lock the installer, and add real provider/payment/SMTP credentials in the admin panel before launch.
