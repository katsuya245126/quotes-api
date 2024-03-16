<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotes API</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        p {
            line-height: 1.6;
            color: #555;
        }
        .endpoint {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .endpoint h3 {
            margin-top: 0;
            color: #333;
        }
        .endpoint p {
            margin-bottom: 5px;
        }
        .endpoint code {
            background-color: #e5e5e5;
            padding: 2px 5px;
            border-radius: 3px;
            font-family: Consolas, monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quotes API</h1>
        <p>Welcome to the Quotes API! This API provides the following endpoints:</p>

        <h2>GET Requests</h2>

        <div class="endpoint">
            <h3>GET /api/quotes/</h3>
            <p>Returns all quotes.</p>
            <p>Example: <code>https://quotes-api-25h1.onrender.com/api/quotes/</code></p>
        </div>

        <div class="endpoint">
            <h3>GET /api/quotes/?id=4</h3>
            <p>Returns the specific quote with the given id.</p>
            <p>Example: <code>https://quotes-api-25h1.onrender.com/api/quotes/?id=4</code></p>
        </div>

        <div class="endpoint">
            <h3>GET /api/quotes/?author_id=10</h3>
            <p>Returns all quotes from the author with the given id.</p>
            <p>Example: <code>https://quotes-api-25h1.onrender.com/api/quotes/?author_id=10</code></p>
        </div>

        <div class="endpoint">
            <h3>GET /api/quotes/?category_id=8</h3>
            <p>Returns all quotes in the category with the given id.</p>
            <p>Example: <code>https://quotes-api-25h1.onrender.com/api/quotes/?category_id=8</code></p>
        </div>

        <div class="endpoint">
            <h3>GET /api/quotes/?author_id=3&category_id=4</h3>
            <p>Returns all quotes from the author with id=3 that are in the category with id=4.</p>
            <p>Example: <code>https://quotes-api-25h1.onrender.com/api/quotes/?author_id=3&category_id=4</code></p>
        </div>

        <div class="endpoint">
            <p>If no quotes are found for the above routes, the response will be:</p>
            <p><code>{ message: 'No Quotes Found' }</code></p>
        </div>

        <div class="endpoint">
            <h3>GET /api/authors/</h3>
            <p>Returns all authors with their ids.</p>
            <p>Example: <code>https://quotes-api-25h1.onrender.com/api/authors/</code></p>
        </div>

        <div class="endpoint">
            <h3>GET /api/authors/?id=5</h3>
            <p>Returns the specific author with the given id.</p>
            <p>Example: <code>https://quotes-api-25h1.onrender.com/api/authors/?id=5</code></p>
        </div>

        <div class="endpoint">
            <p>If no authors are found for the above routes, the response will be:</p>
            <p><code>{ message: 'author_id Not Found' }</code></p>
        </div>

        <div class="endpoint">
            <h3>GET /api/categories/</h3>
            <p>Returns all categories with their ids and names.</p>
            <p>Example: <code>https://quotes-api-25h1.onrender.com/api/categories/</code></p>
        </div>

        <div class="endpoint">
            <h3>GET /api/categories/?id=7</h3>
            <p>Returns the specific category with the given id.</p>
            <p>Example: <code>https://quotes-api-25h1.onrender.com/api/categories/?id=7</code></p>
        </div>

        <div class="endpoint">
            <p>If no categories are found for the above routes, the response will be:</p>
            <p><code>{ message: 'category_id Not Found' }</code></p>
        </div>

        <h2>POST Requests</h2>

        <div class="endpoint">
            <h3>POST /api/quotes/</h3>
            <p>Creates a new quote.</p>
            <p>Response fields: <code>id, quote, author_id, category_id</code></p>
            <p>Note: The POST submission MUST contain the <code>quote</code>, <code>author_id</code>, and <code>category_id</code>.</p>
        </div>

        <div class="endpoint">
            <h3>POST /api/authors/</h3>
            <p>Creates a new author.</p>
            <p>Response fields: <code>id, author</code></p>
            <p>Note: The POST submission MUST contain the <code>author</code>.</p>
        </div>

        <div class="endpoint">
            <h3>POST /api/categories/</h3>
            <p>Creates a new category.</p>
            <p>Response fields: <code>id, category</code></p>
            <p>Note: The POST submission MUST contain the <code>category</code>.</p>
        </div>

        <div class="endpoint">
            <p>If the <code>author_id</code> does not exist, the response will be:</p>
            <p><code>{ message: 'author_id Not Found' }</code></p>
        </div>

        <div class="endpoint">
            <p>If the <code>category_id</code> does not exist, the response will be:</p>
            <p><code>{ message: 'category_id Not Found' }</code></p>
        </div>

        <div class="endpoint">
            <p>If any required parameters are missing, the response will be:</p>
            <p><code>{ message: 'Missing Required Parameters' }</code></p>
        </div>

        <h2>PUT Requests</h2>

        <div class="endpoint">
            <h3>PUT /api/quotes/</h3>
            <p>Updates an existing quote.</p>
            <p>Response fields: <code>id, quote, author_id, category_id</code></p>
            <p>Note: The PUT submission MUST contain the <code>id</code>, <code>quote</code>, <code>author_id</code>, and <code>category_id</code>.</p>
        </div>

        <div class="endpoint">
            <h3>PUT /api/authors/</h3>
            <p>Updates an existing author.</p>
            <p>Response fields: <code>id, author</code></p>
            <p>Note: The PUT submission MUST contain the <code>id</code> and <code>author</code>.</p>
        </div>

        <div class="endpoint">
            <h3>PUT /api/categories/</h3>
            <p>Updates an existing category.</p>
            <p>Response fields: <code>id, category</code></p>
            <p>Note: The PUT submission MUST contain the <code>id</code> and <code>category</code>.</p>
        </div>

        <div class="endpoint">
            <p>If the <code>author_id</code> does not exist, the response will be:</p>
            <p><code>{ message: 'author_id Not Found' }</code></p>
        </div>

        <div class="endpoint">
            <p>If the <code>category_id</code> does not exist, the response will be:</p>
            <p><code>{ message: 'category_id Not Found' }</code></p>
        </div>

        <div class="endpoint">
            <p>If no quotes are found to update, the response will be:</p>
            <p><code>{ message: 'No Quotes Found' }</code></p>
        </div>

        <div class="endpoint">
            <p>If any required parameters (except <code>id</code>) are missing, the response will be:</p>
            <p><code>{ message: 'Missing Required Parameters' }</code></p>
        </div>

        <h2>DELETE Requests</h2>

        <div class="endpoint">
            <h3>DELETE /api/quotes/</h3>
            <p>Deletes an existing quote.</p>
            <p>Response: <code>id of deleted quote</code></p>
            <p>Note: The DELETE request requires the <code>id</code> to be submitted.</p>
        </div>

        <div class="endpoint">
            <h3>DELETE /api/authors/</h3>
            <p>Deletes an existing author.</p>
            <p>Response: <code>id of deleted author</code></p>
            <p>Note: The DELETE request requires the <code>id</code> to be submitted.</p>
        </div>

        <div class="endpoint">
            <h3>DELETE /api/categories/</h3>
            <p>Deletes an existing category.</p>
            <p>Response: <code>id of deleted category</code></p>
            <p>Note: The DELETE request requires the <code>id</code> to be submitted.</p>
        </div>

        <div class="endpoint">
            <p>If no quotes are found to delete, the response will be:</p>
            <p><code>{ message: 'No Quotes Found' }</code></p>
        </div>

    </div>
</body>
</html>