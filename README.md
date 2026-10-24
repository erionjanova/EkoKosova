# 🌱 EkoKosova

*Platformë digjitale për raportimin e ndotjes në Kosovë.*

A web platform where citizens of Kosovo can report pollution in their city (illegal dumps, polluted rivers, air pollution) with a description and a photo, so problems become visible instead of being ignored.

Built with PHP and MySQL. The interface is in Albanian.

**Live demo:** [ekokosova.vercel.app](https://ekokosova.vercel.app)

<img src="https://skillicons.dev/icons?i=php,mysql,html,css,js,vercel" alt="PHP, MySQL, HTML, CSS, JavaScript, Vercel" />

## Why I built this

Pollution is a visible, everyday problem in many Kosovar towns, but there is no simple place where people can report it and see what others have reported. I wanted to build a full web application from scratch around a problem I actually care about, including user accounts, file uploads and an admin side.

## Features

**For users**
- create an account and log in
- submit a pollution report with city, type of pollution, description and a photo
- see the latest reports on the home page
- edit their profile and profile picture
- reset a forgotten password
- send a message through the contact form

**For admins**
- dashboard with an overview of the platform
- manage users, reports and contact messages (edit and delete)
- manage the environmental quotes shown on the site, including the author's photo

## How it works

- **Passwords** are stored with `password_hash()` and checked with `password_verify()`, never in plain text.
- **Database access** goes through PDO with prepared statements, which protects the queries against SQL injection.
- **Password reset** generates a random token with `random_bytes()` that expires after one hour and is stored with the user.
- **Admin pages** check the session and the `is_admin` flag before doing anything, and redirect everyone else to the login page.
- **Uploads** (report photos, profile pictures, quote images) are saved on the server and removed again when the related record is deleted.

## Database

| Table | Contents |
|---|---|
| `users` | accounts, profile picture, admin flag, reset token |
| `reports` | pollution reports: city, type, description, photo |
| `contacts` | messages from the contact form |
| `quotes` | environmental quotes shown on the site |

The full schema with sample data is in [`database/ekokosova.sql`](database/ekokosova.sql).

## Running it locally

You need a local PHP and MySQL server such as [MAMP](https://www.mamp.info/) or [XAMPP](https://www.apachefriends.org/).

1. Clone the repository into your server's web folder (`htdocs`).
2. Create a database called `ekokosova` and import `database/ekokosova.sql` (for example with phpMyAdmin).
3. Check the database user and password in `config.php`.
4. Open `http://localhost/EkoKosova` in your browser.

## What I'd improve next

- send the password reset link by email instead of redirecting straight to the reset page
- let admins mark reports as resolved and show the status publicly
- show reports on a map of Kosovo
- move the database credentials out of `config.php` into environment variables

## Author

Erion Janova · [GitHub](https://github.com/erionjanova) · [LinkedIn](https://www.linkedin.com/in/erion-janova-60bb42340)
