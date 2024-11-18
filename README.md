# Laravel 9 Project - 

This is a simple Laravel 9 project demonstrating role-based access for Admin and Customer users. Below are the instructions to set up and test the project.

## Step 1: Register with Two Different Dummy Emails
1. Go to `http://localhost:8000/register` in your browser.
2. Register two users with different dummy emails:
   - Example: `admin@example.com` for an Admin user
   - Example: `customer@example.com` for a Customer user

## Step 2: Change User Role to "Admin" in Database
1. Open the database management tool .
2. Go to the `users` table in the database.
3. Manually change the role of any user to `admin`.

## Step 3: Login with Different Emails to Access Different Paths
1. Go to `http://localhost:8000/login`.
2. Log in using the `admin@example.com` email to access the Admin URLs.
3. Log in using the `customer@example.com` email to access the Customer URLs.

### Admin URLs:
- Only accessible if logged in as Admin.

### Customer URLs:
- Only accessible if logged in as a Customer.

## Step 4: Login as Admin and Add Categories
1. Log in using the Admin account (e.g., `admin@example.com`).
2. Add new categories as an Admin.

## Step 5: Enjoy Using the Web App
1. Now that Admin and Customer roles are set up and the application is free to use.


