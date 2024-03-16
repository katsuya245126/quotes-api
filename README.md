# FHSU INF653 Midterm Project
# Quotes API by Sung Guk (John) Lee

## About

This RESTful API is developed as the midterm project for the INF653 Back End Web Development course at Fort Hays State University (FHSU). It allows users to interact with a database of quotations. The API supports CRUD operations for quotes, authors, and categories, with all interactions conforming to REST standards and responses formatted in JSON.

## Features

- Fetch all quotes, a single quote, quotes by author, and quotes by category.
- Fetch all authors or a single author
- Fetch all categories or a single category
- Add, update, and delete quotes, authors, and categories.

## Usage

The API is accessible at the following base URL: `https://quotes-api-25h1.onrender.com/api`

## Endpoints

**GET Requests**
- `/quotes/` - Get all quotes
- `/quotes/?id=4` - Get a specific quote
- `/quotes/?author_id=10` - Get quotes by author ID
- `/quotes/?category_id=8` - Get quotes by category ID
- `/quotes/?author_id=3&category_id=4` - Get quotes by author and category IDs
- `/authors/` - Get all authors
- `/authors/?id=5` - Get a specific author
- `/categories/` - Get all categories
- `/categories/?id=7` - Get a specific category

**POST Requests**
- `/quotes/` - Create a new quote
- `/authors/` - Create a new author
- `/categories/` - Create a new category

**PUT Requests**
- `/quotes/` - Update an existing quote
- `/authors/` - Update an existing author
- `/categories/` - Update an existing category

**DELETE Requests**
- `/quotes/` - Delete an existing quote
- `/authors/` - Delete an existing author
- `/categories/` - Delete an existing category

**API Documentation**

For detailed information about the API endpoints, request/response formats, and examples, please refer to the `index.php` file in the project's root directory.

**Deployment**

This project is deployed on render.com and can be accessed at the following URL:

[https://quotes-api-25h1.onrender.com/](https://quotes-api-25h1.onrender.com/)

The database is hosted on Render.com using PostgreSQL.