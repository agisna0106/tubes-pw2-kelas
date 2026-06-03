# CONTRIBUTING GUIDE

## Project

Mini Market Management System

Framework:

* Laravel 13
* MySQL
* Spatie Laravel Permission

---

# TEAM STRUCTURE

## Member 1

Feature:

* Authentication
* Authorization
* User Management

Responsibilities:

* Login
* Logout
* Role Management
* Permission Management
* Middleware Role
* Dashboard
* User CRUD

---

## Member 2

Feature:

* Branch Management

Responsibilities:

* Branch CRUD
* Branch Assignment
* Manager Assignment

---

## Member 3

Feature:

* Product & Inventory

Responsibilities:

* Category CRUD
* Product CRUD
* Stock In
* Stock Out
* Inventory Monitoring

---

## Member 4

Feature:

* Transaction & Report

Responsibilities:

* Sales Transaction
* Transaction Detail
* Reports

---

# ROLE ACCESS

## OWNER

Access:

* Dashboard
* User Management
* Branch Management
* Product Management
* Inventory Management
* Transaction Reports
* Stock Reports

---

## MANAGER

Access:

* Dashboard
* Branch Reports
* Inventory Reports
* Transaction Reports

Cannot Access:

* User Management

---

## SUPERVISOR

Access:

* Dashboard
* Product Management
* Inventory Monitoring

Cannot Access:

* User Management
* Branch Management

---

## CASHIER

Access:

* Dashboard
* Sales Transaction

Cannot Access:

* User Management
* Inventory Management
* Branch Management

---

## WAREHOUSE

Access:

* Dashboard
* Stock In
* Stock Out
* Inventory Monitoring

Cannot Access:

* User Management
* Sales Transaction

---

# NAVIGATION

Navigation sudah disiapkan berdasarkan role.

Jangan mengubah navigation role tanpa koordinasi.

Gunakan directive:

@role()
@hasanyrole()

untuk menampilkan menu sesuai role.

---

# GIT WORKFLOW

## NEVER PUSH TO MAIN

Dilarang push langsung ke main.

---

## Update Project

git checkout main

git pull origin main

---

## Create Branch

git checkout -b feature/feature-name

Examples:

feature/branch-management

feature/product-management

feature/transaction-management

---

## Commit

git add .

git commit -m "feat: add branch crud"

---

## Push

git push origin feature/branch-management

---

## Pull Request

Setelah fitur selesai:

1. Push branch
2. Create Pull Request
3. Review
4. Merge

---

# DATABASE RULES

Do not modify:

* users
* roles
* permissions
* model_has_roles

without approval.

---

# SEEDER RULES

Every new table must have:

* Seeder
* Factory (if needed)

---

# CODE RULES

Controller:

* Validation required

Model:

* Fillable required

Migration:

* Foreign key required

Views:

* Use Blade Components if available

---

# TESTING

Before submitting:

1. Create data
2. Update data
3. Delete data
4. Check validation
5. Check role access

All features must be tested before creating Pull Request.
