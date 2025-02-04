# Project Setup

## Prerequisites

- PHP (>=8.3)
- Composer
- MySQL or MariaDB

## Step-by-Step Guide

### Copy the .env.example file

```
cp .env.example .env
```

### Install dependencies using Composer

```
composer install
```

### Run the script to create the database

```
php database/migrations/create_orders_table.php
```

### Run the script

```
php index.php
```
